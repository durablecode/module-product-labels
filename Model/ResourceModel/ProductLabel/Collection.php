<?php
declare(strict_types=1);

namespace DurableCode\ProductLabels\Model\ResourceModel\ProductLabel;

use DurableCode\ProductLabels\Model\ResourceModel\ProductLabel as ProductLabelResource;
use DurableCode\ProductLabels\Model\ProductLabel;
use DurableCode\ProductLabels\Model\ResourceModel\ProductLabelOption;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Magento\Framework\DB\Select;

class Collection extends AbstractCollection
{
    /**
     * @inheritdoc
     * @var string
     */
    protected $_idFieldName = 'label_id';
    
    /**
     * Initial product label collection
     *
     * @return void
     */
    #[\Override]
    protected function _construct(): void
    {
        $this->_init(ProductLabel::class, ProductLabelResource::class);
    }
    
    /**
     * Get product labels by label_id's
     *
     * @param array $ids
     * @return self
     */
    public function getByIds(array $ids): self
    {
        $this->getSelect()->where('main_table.label_id IN(?)', $ids);
        return $this;
    }
    
    /**
     * Get product labels and options
     *
     * @return self
     */
    public function getLabelWithOptions(): self
    {
        $this->getSelect()->reset(Select::COLUMNS);
        $this->getSelect()
                ->joinLeft(
                    ['opt' => ProductLabelOption::TABLE_NAME],
                    'opt.label_id = main_table.label_id',
                    ['main_table.label_text', 'opt.name', 'opt.value']
                );
        return $this;
    }
    
    /**
     * Get labels and options data by id's
     *
     * @param array $ids
     * @return array
     */
    public function getLabelsByIds(array $ids): array
    {
        return $this->getByIds($ids)
                ->getLabelWithOptions()
                ->getItems();
    }
}
