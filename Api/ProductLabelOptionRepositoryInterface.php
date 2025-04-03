<?php

namespace DurableCode\ProductLabels\Api;

use DurableCode\ProductLabels\Vo\LabelOption;

interface ProductLabelOptionRepositoryInterface
{
    /**
     * Save product label option
     *
     * @param LabelOption $labelOptionData
     * @param int $labelId
     * @param int $optionId
     * @return void
     */
    public function save(LabelOption $labelOptionData, int $labelId, int $optionId = null): void;
    
    /**
     * Delete product label options by option_id's
     *
     * @param array $ids
     * @return void
     */
    public function deleteByIds(array $ids): void;
}
