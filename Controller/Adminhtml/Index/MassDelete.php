<?php

declare(strict_types=1);

namespace DurableCode\ProductLabels\Controller\Adminhtml\Index;

use DurableCode\ProductLabels\Model\ResourceModel\ProductLabel\CollectionFactory;
use DurableCode\ProductLabels\Api\ProductLabelRepositoryInterface;

use Magento\Framework\App\Action\HttpPostActionInterface as HttpPostActionInterface;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Ui\Component\MassAction\Filter;

class MassDelete extends Action implements HttpPostActionInterface
{
    public const ADMIN_RESOURCE = 'DurableCode_ProductLabels::massDelete';
    
    /**
     * @param Context $context
     * @param CollectionFactory $collectionFactory
     * @param ProductLabelRepositoryInterface $productLabelRepository
     * @param Filter $filter
     */
    public function __construct(
        Context $context,
        private CollectionFactory $collectionFactory,
        private ProductLabelRepositoryInterface $productLabelRepository,
        private Filter $filter
    ) {
        parent::__construct($context);
    }
    
    /**
     * Run massDelete controller
     *
     * @return void
     */
    public function execute(): void
    {
        $collection = $this->filter->getCollection($this->collectionFactory->create());
        $ids = $collection->getAllIds();
        if ($ids) {
            try {
                $this->productLabelRepository->deleteByIds($ids);
            } catch (\Exception $error) {
                $this->messageManager->addExceptionMessage($error);
                return;
            }
            $this->messageManager->addSuccessMessage(
                __('Labels have been deleted.')->getText()
            );
        } else {
            $this->messageManager->addErrorMessage(
                __('Labels doesn\'t exists.')->getText()
            );
        }
        
        $this->_redirect('*/*');
    }
}
