<?php
declare(strict_types=1);

namespace DurableCode\ProductLabels\Model\ResourceModel\ProductLabelOption;

use DurableCode\ProductLabels\Model\ResourceModel\ProductLabelOption as ProductLabelOptionResource;
use DurableCode\ProductLabels\Model\ProductLabelOption;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * @inheritdoc
     * @var string
     */
    protected $_idFieldName = 'option_id';
    
    /**
     * Initial product label options collection
     *
     * @return void
     */
    #[\Override]
    protected function _construct(): void
    {
        $this->_init(ProductLabelOption::class, ProductLabelOptionResource::class);
    }
    
    /**
     * Get one product label options by label_id
     *
     * @param int $id
     * @return self
     */
    public function getByLabelId(int $id): self
    {
        $this->getSelect()->where('label_id = ?', $id);
        return $this;
    }
}
