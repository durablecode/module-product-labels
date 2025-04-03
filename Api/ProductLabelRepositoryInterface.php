<?php

namespace DurableCode\ProductLabels\Api;

use DurableCode\ProductLabels\Api\Data\ProductLabelInterface;

interface ProductLabelRepositoryInterface
{
    /**
     * Get product label
     *
     * @param int $labelId
     * @return ProductLabelInterface
     */
    public function get(int $labelId): ProductLabelInterface;
    
    /**
     * Save product label
     *
     * @param ProductLabelInterface $label
     * @return void
     */
    public function save(ProductLabelInterface $label): void;
    
    /**
     * Delete product labels by label_id's
     *
     * @param array $ids
     * @return void
     */
    public function deleteByIds(array $ids): void;
}
