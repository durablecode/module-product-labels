<?php

declare(strict_types=1);

namespace DurableCode\ProductLabels\Controller\Adminhtml\Index;

use DurableCode\ProductLabels\Api\ProductLabelRepositoryInterface;

use Magento\Backend\App\Action;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use Magento\Backend\Model\View\Result\Page;

class Edit extends Action implements HttpGetActionInterface
{
    public const ADMIN_RESOURCE = 'DurableCode_ProductLabels::edit';
    
    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     * @param ProductLabelRepositoryInterface $productLabelRepository
     */
    public function __construct(
        Context $context,
        private PageFactory $resultPageFactory,
        private ProductLabelRepositoryInterface $productLabelRepository,
    ) {
        parent::__construct($context);
    }
    
    /**
     * Run edit controller
     *
     * @return type
     */
    public function execute()
    {
        $id = (int)$this->getRequest()->getParam('label_id');
        $resultPage = $this->initPageSettings();
        
        if ($id) {
            $productLabel = $this->productLabelRepository->get($id);
            if (!$productLabel->getId()) {
                $this->messageManager->addErrorMessage(__('This label doesn\'t exists.')->getText());
                return $this->resultRedirectFactory->create()->setPath('*/*/index');
            }
            
            $resultPage->getConfig()->getTitle()
            ->prepend($productLabel->getId() ? $productLabel->getLabelText() : __('Product Label'));
        }

        return $resultPage;
    }
    
    /**
     * Initial page settings
     *
     * @return Page
     */
    private function initPageSettings(): Page
    {
        $resultPage = $this->resultPageFactory->create()
            ->setActiveMenu('DurableCode_ProductLabels::list');
        $resultPage->getConfig()->getTitle()->prepend(__('New Product Label'));
        return $resultPage;
    }
}
