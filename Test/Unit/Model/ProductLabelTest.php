<?php
declare(strict_types=1);

namespace DurableCode\ProductLabels\Test\Unit\Model;

use DurableCode\ProductLabels\Model\ProductLabel;

use PHPUnit\Framework\TestCase;
use ReflectionClass;

class ProductLabelTest extends TestCase
{
    public function testEmptyLabelTextFail(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(__('Label Text field canno\'t be empty')->getText());
        
        $reflection = new ReflectionClass(ProductLabel::class);
        $productLabelModel = $reflection->newInstanceWithoutConstructor();
        $productLabelModel->fromArray([
            'label_text' => '',
            'label_id' => 12
        ]);
    }
    
    public function testExceedLabelTextLengthFail(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(__('Label Text is longer than 40 characters.')->getText());
        
        $reflection = new ReflectionClass(ProductLabel::class);
        $productLabelModel = $reflection->newInstanceWithoutConstructor();
        $productLabelModel->fromArray([
            'label_text' => 'Lorem ipsum dolor sit amet, consectetur.1',
            'label_id' => 12
        ]);
    }
    
    public function testLabelTextSuccess()
    {
        $reflection = new ReflectionClass(ProductLabel::class);
        $productLabelModel = $reflection->newInstanceWithoutConstructor();
        $productLabelModel->fromArray([
            'label_text' => 'Lorem ipsum dolor',
            'label_id' => 12
        ]);
        
        $this->assertEquals('Lorem ipsum dolor', $productLabelModel->getLabelText());
        $this->assertEquals(12, $productLabelModel->getLabelId());
    }
}
