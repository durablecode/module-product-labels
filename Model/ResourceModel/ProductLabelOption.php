<?php
declare(strict_types=1);

namespace DurableCode\ProductLabels\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class ProductLabelOption extends AbstractDb
{
    public const TABLE_NAME = 'label_options';
    
    /**
     * Initial product label option resource
     *
     * @return void
     */
    #[\Override]
    protected function _construct(): void
    {
        $this->_init(self::TABLE_NAME, 'option_id');
    }
}
