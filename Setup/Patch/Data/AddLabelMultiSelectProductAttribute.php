<?php

declare(strict_types=1);

namespace DurableCode\ProductLabels\Setup\Patch\Data;

use DurableCode\ProductLabels\Model\Config\Product\Labels;

use Magento\Framework\Setup\Patch\DataPatchInterface;
use Magento\Framework\Setup\Patch\PatchRevertableInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Catalog\Model\Product;
use Magento\Eav\Model\Entity\Attribute\Backend\ArrayBackend;
use Magento\Catalog\Model\ResourceModel\Eav\Attribute;
use Magento\Eav\Setup\EavSetupFactory;
use Magento\Eav\Api\AttributeRepositoryInterface;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Eav\Api\Data\AttributeInterface;

class AddLabelMultiSelectProductAttribute implements DataPatchInterface, PatchRevertableInterface
{
    public const ATTRIBUTE_CODE = 'product_labels';
    
    /**
     * @param ModuleDataSetupInterface $moduleDataSetup
     * @param EavSetupFactory $eavSetupFactory
     * @param AttributeRepositoryInterface $attributeRepository
     */
    public function __construct(
        private ModuleDataSetupInterface $moduleDataSetup,
        private EavSetupFactory $eavSetupFactory,
        private AttributeRepositoryInterface $attributeRepository
    ) {
    }
    
    /**
     * Create attribute
     *
     * @return void
     */
    public function apply(): void
    {
        $this->moduleDataSetup->getConnection()->startSetup();
        $eavSetup = $this->eavSetupFactory->create(['setup' => $this->moduleDataSetup]);

        try {
            $this->getAttribute();
        } catch (NoSuchEntityException $e) {
            $eavSetup->addAttribute(
                Product::ENTITY,
                self::ATTRIBUTE_CODE,
                [
                    'group' => 'Product Details',
                    'label' => 'Labels',
                    'type'  => 'text',
                    'input' => 'multiselect',
                    'source' => Labels::class,
                    'required' => false,
                    'sort_order' => 30,
                    'global' => Attribute::SCOPE_STORE,
                    'used_in_product_listing' => true,
                    'backend' => ArrayBackend::class,
                    'visible_on_front' => true,
                    'required' => false,
                    'user_defined' => true
                ]
            );
        }
        
        $this->moduleDataSetup->getConnection()->endSetup();
    }
    
    /**
     * Remove Attribute
     *
     * @return void
     */
    public function revert(): void
    {
        try {
            $this->attributeRepository->delete($this->getAttribute());
        } catch (NoSuchEntityException $e) {
            return;
        }
    }
    
    /**
     * Get Aliases
     *
     * @return array
     */
    public function getAliases(): array
    {
        return [];
    }

    /**
     * Get dependencies
     *
     * @return array
     */
    public static function getDependencies(): array
    {
        return [];
    }
    
    /**
     * Get attribute data
     *
     * @return AttributeInterface
     */
    private function getAttribute(): AttributeInterface
    {
        return $this->attributeRepository->get(Product::ENTITY, self::ATTRIBUTE_CODE);
    }
}
