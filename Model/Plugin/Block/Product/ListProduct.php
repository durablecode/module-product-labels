<?php

declare(strict_types=1);

namespace DurableCode\ProductLabels\Model\Plugin\Block\Product;

use DurableCode\ProductLabels\Block\Product\LabelRendererFactory;

use Magento\Catalog\Block\Product\ListProduct as ListProductSubject;
use Magento\Catalog\Api\Data\ProductInterface;

class ListProduct
{
    /**
     * @param LabelRendererFactory $blockFactory
     */
    public function __construct(
        private LabelRendererFactory $blockFactory
    ) {
    }
    
    /**
     * After plugin for ListProductSubject::getProductDetailsHtml
     *
     * @param ListProductSubject $subject
     * @param string $html
     * @param ProductInterface $product
     * @return string
     */
    public function afterGetProductDetailsHtml(
        ListProductSubject $subject,
        string $html,
        ProductInterface $product
    ): string {
        return $html.$this->blockFactory
                ->create(['data' => ['product' => $product]])->toHtml();
    }
}
