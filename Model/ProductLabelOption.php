<?php
declare(strict_types=1);

namespace DurableCode\ProductLabels\Model;

use DurableCode\ProductLabels\Model\ResourceModel\ProductLabelOption as ProductLabelOptionResource;

use Magento\Framework\Model\AbstractModel;

class ProductLabelOption extends AbstractModel
{
    /**
     * @inheritdoc
     * @var string
     */
    protected $_eventPrefix = ProductLabelOptionResource::TABLE_NAME;
    
    /**
     * @inheritdoc
     * @var string
     */
    protected $_eventObject = 'object';
    
    /**
     * Set product label option resource
     *
     * @return void
     */
    protected function _construct(): void
    {
        $this->_init(ProductLabelOptionResource::class);
    }
}
