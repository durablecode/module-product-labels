<?php

declare(strict_types=1);

namespace DurableCode\ProductLabels\Block\Adminhtml\ProductLabel;

use Magento\Customer\Block\Adminhtml\Edit\GenericButton;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;

class AddButton extends GenericButton implements ButtonProviderInterface
{
    /**
     * 'Add New Product Label' button data
     *
     * @return array
     */
    public function getButtonData(): array
    {
        return [
            'label' => __('Add New Product Label'),
            'class' => 'primary',
            'url' => $this->getUrl('*/*/new'),
            'sort_order' => 10,
        ];
    }
}
