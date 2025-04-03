<?php

declare(strict_types=1);

namespace DurableCode\ProductLabels\Controller\Adminhtml\Index;

use DurableCode\ProductLabels\Api\ProductLabelRepositoryInterface;
use DurableCode\ProductLabels\Api\ProductLabelOptionRepositoryInterface;
use DurableCode\ProductLabels\Model\ResourceModel\ProductLabelOption\Collection;
use DurableCode\ProductLabels\Vo\LabelOption;

use Magento\Backend\App\Action;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Backend\App\Action\Context;

class Save extends Action implements HttpPostActionInterface
{
    public const ADMIN_RESOURCE = 'DurableCode_ProductLabels::save';
    
    /**
     * @param Context $context
     * @param ProductLabelRepositoryInterface $prodLabelRepository
     * @param ProductLabelOptionRepositoryInterface $prodLabelOptRepository
     * @param Collection $collection
     */
    public function __construct(
        Context $context,
        private ProductLabelRepositoryInterface $prodLabelRepository,
        private ProductLabelOptionRepositoryInterface $prodLabelOptRepository,
        private Collection $collection
    ) {
        parent::__construct($context);
    }
    
    /**
     * Run save controller
     *
     * @return void
     */
    public function execute(): void
    {
        $labelId = $this->getRequest()->getParam('label_id');
        try {
            $this->deleteOptions();
            $labelId = $this->insertOrUpdateLabel();
            $this->insertOrUpdateOptions($labelId);
        } catch (\Exception $error) {
            $this->messageManager->addExceptionMessage($error);
        }
        
        if ($labelId) {
            $this->_redirect('*/*/edit', ['label_id' => $labelId]);
        } else {
            $this->_redirect('*/*/new');
        }
    }
    
    /**
     * Delete requested label options
     *
     * @return void
     */
    private function deleteOptions(): void
    {
        $id = (int)$this->getRequest()->getParam('label_id');
        $options = (array)$this->getRequest()->getParam('label_options');
        $optionIds = array_column($options, 'option_id');
        $labelOptions = $this->collection->getByLabelId($id);
        $idsToDelete = array_diff($labelOptions->getAllIds(), $optionIds);
        $this->prodLabelOptRepository->deleteByIds($idsToDelete);
    }
    
    /**
     * Insert/Update requested label
     *
     * @return int
     */
    private function insertOrUpdateLabel(): int
    {
        $id = (int)$this->getRequest()->getParam('label_id');
        $productLabel = $this->prodLabelRepository->get($id);
        $params = $this->getRequest()->getParams();
        if (!$productLabel->getId()) {
            unset($params['label_id']);
        }
        
        $productLabel->fromArray($params);
        $this->prodLabelRepository->save($productLabel);
        return (int)$productLabel->getId();
    }
    
    /**
     * Insert/Update requested label options
     *
     * @param int $labelId
     * @return void
     */
    private function insertOrUpdateOptions(int $labelId): void
    {
        foreach ((array)$this->getRequest()->getParam('label_options') as $optionData) {
            $this->prodLabelOptRepository->save(
                new LabelOption($optionData['name'], $optionData['value']),
                $labelId,
                (int)$optionData['option_id']
            );
        }
    }
}
