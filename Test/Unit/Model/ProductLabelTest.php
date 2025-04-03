<?php
declare(strict_types=1);

namespace DurableCode\ProductLabels\Test\Unit\Model;

use DurableCode\ProductLabels\Model\ProductLabel;

use PHPUnit\Framework\TestCase;
use ReflectionClass;

class ProductLabelTest extends TestCase
{

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
    
    /**
     * Test fail cases
     *
     * @dataProvider failTestCases
     * @param string $labelText
     * @param string $expectedError
     * @return void
     */
    public function testErrors(string $labelText, string $expectedError): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage($expectedError);
        
        $reflection = new ReflectionClass(ProductLabel::class);
        $productLabelModel = $reflection->newInstanceWithoutConstructor();
        $productLabelModel->fromArray([
            'label_text' => $labelText,
            'label_id' => 12
        ]);
    }
    
    /**
     * Fail cases
     *
     * @return array
     */
    private function failTestCases(): array
    {
        return [
            'test_empty_label_text' => [
                '',
                __('Label Text field canno\'t be empty')->getText()
            ],
            'test_exceed_label_text_length' => [
                'Lorem ipsum dolor sit amet, consectetur.1',
                __('Label Text is longer than 40 characters.')->getText()
            ]
        ];
    }
}
