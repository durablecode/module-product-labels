<?php

declare(strict_types=1);

namespace DurableCode\ProductLabels\Model;

use DurableCode\ProductLabels\Model\ResourceModel\ProductLabel\CollectionFactory;

use Magento\Ui\DataProvider\AbstractDataProvider;
use Magento\Framework\Api\Filter;

class DataProvider extends AbstractDataProvider
{
    /**
     * @inheritdoc
     */
    public function __construct(
        CollectionFactory $collectionFactory,
        $name,
        $primaryFieldName,
        $requestFieldName,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collectionFactory->create();
    }
    
    /**
     * Get product label data
     *
     * @return array
     */
    #[\Override]
    public function getData(): array
    {
        $labelData = $this->collection->getFirstItem();
        $collection = $this->collection->getLabelWithOptions();
        $data = [
            'label_text' => $labelData['label_text'],
            'label_id' => $labelData['label_id']
        ];
        $options = $collection->getData();
        if (count($options)) {
            $data['label_options'] = $options;
        }
        
        return [(int)$labelData['label_id'] => $data];
    }
    
    /**
     * Added table alias for label_id
     *
     * @param Filter $filter
     */
    #[\Override]
    public function addFilter(Filter $filter)
    {
        $filter->setField('main_table.'.$filter->getField());
        parent::addFilter($filter);
    }
}
