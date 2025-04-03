<?php

declare(strict_types=1);

namespace DurableCode\ProductLabels\Controller\Adminhtml\Index;

use Magento\Framework\App\Action\HttpGetActionInterface as HttpGetActionInterface;
use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Backend\Model\View\Result\ForwardFactory;
use Magento\Backend\Model\View\Result\Forward;

class NewAction extends Action implements HttpGetActionInterface
{
    public const ADMIN_RESOURCE = 'DurableCode_ProductLabels::add';
    
    /**
     * @param Context $context
     * @param ForwardFactory $resultForwardFactory
     */
    public function __construct(
        Context $context,
        private ForwardFactory $resultForwardFactory
    ) {
        parent::__construct($context);
    }
    
    /**
     * Run new action controller
     *
     * @return Forward
     */
    public function execute(): Forward
    {
        return $this->resultForwardFactory->create()->forward('edit');
    }
}
