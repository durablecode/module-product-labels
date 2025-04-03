<?php

declare(strict_types=1);

namespace DurableCode\ProductLabels\Test\Unit\Vo;

use DurableCode\ProductLabels\Vo\LabelOption;

use PHPUnit\Framework\TestCase;

class LabelOptionTest extends TestCase
{

    public function testCssStringSuccess(): void
    {
        $this->assertEquals('border: 2px solid red;', (new LabelOption('border', '2px solid red'))->toCss());
    }
    
    public function testArrayConvertionSuccess(): void
    {
        $labelOptionData = (new LabelOption('border', '2px solid red'))->toArray();
        $this->assertCount(2, $labelOptionData);
        $this->assertEquals('border', $labelOptionData['name']);
        $this->assertEquals('2px solid red', $labelOptionData['value']);
    }
    
    /**
     * Test fail cases
     *
     * @dataProvider testCases
     * @param string $name
     * @param string $value
     * @param string $expectedError
     * @return void
     */
    public function testErrors(string $name, string $value, string $expectedError): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage($expectedError);
        
        new LabelOption($name, $value);
    }
    
    /**
     * Fail cases
     *
     * @return array
     */
    private function testCases(): array
    {
        return [
            'testIsEmptyOptionName' => ['', 'Lorem', __('Option name cannot\'t be empty.')->getText()],
            'testIsEmptyOptionValueFail' => ['Lorem', '', __('Option value cannot\'t be empty.')->getText()],
            'testExceedOptionNameLengthFail' => [
                'Lorem ipsum dolor sit amet, cons.',
                'test',
                __('Option name is longer than 30 characters.')->getText()
            ],
            'testExceedOptionValueLengthFail' => [
                'test',
                'Lorem ipsum dolor sit amet, consectetur adipiscing elit. '
                . 'Vestibulum at sapien euismod, feugiat justo vel.',
                __('Option value is longer than 100 characters.')->getText()
            ]
        ];
    }
}
