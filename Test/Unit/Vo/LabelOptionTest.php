<?php

declare(strict_types=1);

namespace DurableCode\ProductLabels\Test\Unit\Vo;

use DurableCode\ProductLabels\Vo\LabelOption;

use PHPUnit\Framework\TestCase;

class LabelOptionTest extends TestCase
{
    public function testIsEmptyOptionName(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(__('Option name cannot\'t be empty.')->getText());
        
        new LabelOption('', 'Lorem');
    }
    
    public function testIsEmptyOptionValueFail(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(__('Option value cannot\'t be empty.')->getText());
        
        new LabelOption('Lorem', '');
    }
    
    public function testExceedOptionNameLengthFail(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(__('Option name is longer than 30 characters.')->getText());
        
        new LabelOption('Lorem ipsum dolor sit amet, cons.', 'test');
    }
    
    public function testExceedOptionValueLengthFail(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage(__('Option value is longer than 100 characters.')->getText());
        
        new LabelOption('test', 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. '
                . 'Vestibulum at sapien euismod, feugiat justo vel.');
    }
    
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
}
