<?php

declare(strict_types=1);

namespace DurableCode\ProductLabels\Model;

use DurableCode\ProductLabels\Api\Data\ProductLabelInterfaceFactory;
use DurableCode\ProductLabels\Api\Data\ProductLabelInterface;
use DurableCode\ProductLabels\Model\ResourceModel\ProductLabel as ProductLabelResource;
use DurableCode\ProductLabels\Api\ProductLabelRepositoryInterface;

use Magento\Framework\App\ResourceConnection;

class ProductLabelRepository implements ProductLabelRepositoryInterface
{
    /**
     * @param ProductLabelInterfaceFactory $productLabelFactory
     * @param ProductLabelResource $productLabelResource
     * @param ResourceConnection $resource
     */
    public function __construct(
        private ProductLabelInterfaceFactory $productLabelFactory,
        private ProductLabelResource $productLabelResource,
        private ResourceConnection $resource
    ) {
    }
    
    /**
     * @inheritdoc
     */
    public function get(int $labelId): ProductLabelInterface
    {
        $productLabel = $this->productLabelFactory->create();
        $this->productLabelResource->load($productLabel, $labelId, 'label_id');
        return $productLabel;
    }
    
    /**
     * @inheritdoc
     */
    public function save(ProductLabelInterface $productLabel): void
    {
        $this->productLabelResource->save($productLabel);
    }
    
    /**
     * @inheritdoc
     * @throws \Exception
     */
    public function deleteByIds(array $ids): void
    {
        $connection = $this->resource->getConnection();
        try {
            $connection->beginTransaction();
            $connection->delete(ProductLabelResource::TABLE_NAME, $connection->quoteInto('label_id IN(?)', $ids));
            $connection->commit();
        } catch (\Exception $e) {
            $connection->rollBack();
            throw $e;
        }
    }
}
