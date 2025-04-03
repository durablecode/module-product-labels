<?php
declare(strict_types=1);

namespace DurableCode\ProductLabels\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class ProductLabel extends AbstractDb
{
    public const TABLE_NAME = 'labels';
    
    /**
     * Initial product label resource
     *
     * @return void
     */
    #[\Override]
    protected function _construct(): void
    {
        $this->_init(self::TABLE_NAME, 'label_id');
    }
}
