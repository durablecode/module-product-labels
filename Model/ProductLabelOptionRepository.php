<?php

declare(strict_types=1);

namespace DurableCode\ProductLabels\Model;

use DurableCode\ProductLabels\Api\ProductLabelOptionRepositoryInterface;
use DurableCode\ProductLabels\Vo\LabelOption;
use DurableCode\ProductLabels\Model\ResourceModel\ProductLabelOption;

use Magento\Framework\App\ResourceConnection;

class ProductLabelOptionRepository implements ProductLabelOptionRepositoryInterface
{
    /**
     * @param ResourceConnection $resource
     */
    public function __construct(
        private ResourceConnection $resource
    ) {
    }

    /**
     * @inheritdoc
     * @throws \Exception
     */
    #[\Override]
    public function save(LabelOption $labelOptionData, int $labelId, int $optionId = null): void
    {
        $connection = $this->resource->getConnection();
        $data = $labelOptionData->toArray();
        if ($labelId <= 0) {
            throw new \InvalidArgumentException(__('Label ID must be greater than 0'));
        }
        
        $data['label_id'] = $labelId;
        $data['option_id'] = $optionId;
        try {
            $connection->beginTransaction();
            $connection->insertOnDuplicate(ProductLabelOption::TABLE_NAME, $data);
            $connection->commit();
        } catch (\Exception $error) {
            $connection->rollBack();
            throw $error;
        }
    }
    
    /**
     * @inheritdoc
     * @throws \Exception
     */
    #[\Override]
    public function deleteByIds(array $ids): void
    {
        $connection = $this->resource->getConnection();
        try {
            $connection->beginTransaction();
            $connection->delete('label_options', $connection->quoteInto('option_id IN(?)', $ids));
            $connection->commit();
        } catch (\Exception $error) {
            $connection->rollBack();
            throw $error;
        }
    }
}
