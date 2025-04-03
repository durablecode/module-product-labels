<?php

declare(strict_types=1);

namespace DurableCode\ProductLabels\Model\Config\Product;

use DurableCode\ProductLabels\Model\ResourceModel\ProductLabel\CollectionFactory;

use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;

class Labels extends AbstractSource
{
    /**
     * @param CollectionFactory $collectionFactory
     */
    public function __construct(
        private CollectionFactory $collectionFactory
    ) {
    }
    
    /**
     * Options for product_labels product attribute
     *
     * @return array
     */
    public function getAllOptions(): array
    {
        if ($this->_options === null) {
            foreach ($this->collectionFactory->create() as $label) {
                $this->_options[] = [
                    'value' => $label->getData('label_id'),
                    'label' => $label->getData('label_text')
                ];
            }
        }

        return $this->_options;
    }
}
