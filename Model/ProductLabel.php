<?php
declare(strict_types=1);

namespace DurableCode\ProductLabels\Model;

use DurableCode\ProductLabels\Model\ResourceModel\ProductLabel as ProductLabelResource;
use DurableCode\ProductLabels\Api\Data\ProductLabelInterface;

use Magento\Framework\Model\AbstractModel;

class ProductLabel extends AbstractModel implements ProductLabelInterface
{
    /**
     * @inheritdoc
     * @var string
     */
    protected $_eventPrefix = ProductLabelResource::TABLE_NAME;
    
    /**
     * @inheritdoc
     * @var string
     */
    protected $_eventObject = 'object';
    
    /**
     * Initial product label resource
     *
     * @return void
     */
    #[\Override]
    protected function _construct(): void
    {
        $this->_init(ProductLabelResource::class);
    }
    
    /**
     * Create new item from array
     *
     * @param array $data
     * @return self
     * @throws \InvalidArgumentException
     */
    public function fromArray(array $data): self
    {
        if (empty($data['label_text'])) {
            throw new \InvalidArgumentException(__('Label Text field canno\'t be empty')->getText());
        }

        if (strlen($data['label_text']) > 40) {
            throw new \InvalidArgumentException(__('Label Text is longer than 40 characters.')->getText());
        }
        
        if (isset($data['label_id'])) {
            $this->setLabelId($data['label_id']);
        }
        
        $this->setLabelText($data['label_text']);
        return $this;
    }
}
