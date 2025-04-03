<?php

declare(strict_types=1);

namespace DurableCode\ProductLabels\Block\Product;

use DurableCode\ProductLabels\Setup\Patch\Data\AddLabelMultiSelectProductAttribute;
use DurableCode\ProductLabels\Model\ResourceModel\ProductLabel\CollectionFactory;
use DurableCode\ProductLabels\Vo\LabelOption;

use Magento\Framework\View\Element\Template;
use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\Template\Context;

class LabelRenderer extends Template
{
    /**
     * @inheritdoc
     * @var string
     */
    protected $_template = 'DurableCode_ProductLabels::product/view/label.phtml';
 
    /**
     * @param CollectionFactory $collectionFactory
     * @param Registry $registry
     * @param Context $context
     * @param array $data
     */
    public function __construct(
        private CollectionFactory $collectionFactory,
        private Registry $registry,
        Context $context,
        array $data = []
    ) {
        parent::__construct($context, $data);
    }
    
    /**
     * Get labels data
     *
     * @return array
     */
    public function getLabels(): array
    {
        return array_reduce(
            $this->collectionFactory->create()->getLabelsByIds($this->labelOptionIds()),
            function ($carry, $item) {
                $carry[$item['label_text']][] = ['name' => $item['name'], 'value' => $item['value']];
                return $carry;
            },
            []
        );
    }
    
    /**
     * Get css
     *
     * @param array $optionData
     * @return string
     */
    public function getCss(array $optionData): string
    {
        try {
            return (new LabelOption((string)$optionData['name'], (string)$optionData['value']))->toCss();
        } catch (\InvalidArgumentException $error) {
            return '';
        }
    }
    
    /**
     * Get product object
     *
     * @return ProductInterface|null
     */
    private function getProduct(): ?ProductInterface
    {
        return !isset($this->_data['product']) ? $this->registry->registry('current_product'): $this->_data['product'];
    }
    
    /**
     * Get label option id's
     *
     * @return array
     */
    private function labelOptionIds(): array
    {
        return explode(',', (string)$this->getProduct()?->getData(AddLabelMultiSelectProductAttribute::ATTRIBUTE_CODE));
    }
}
