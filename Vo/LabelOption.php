<?php

declare(strict_types=1);

namespace DurableCode\ProductLabels\Vo;

class LabelOption
{
    /**
     * @param string $name
     * @param string $value
     * @throws \InvalidArgumentException
     */
    public function __construct(
        private readonly string $name,
        private readonly string $value,
    ) {
        
        if (empty($this->name)) {
            throw new \InvalidArgumentException(__('Option name cannot\'t be empty.')->getText());
        }
        
        if (empty($this->value)) {
            throw new \InvalidArgumentException(__('Option value cannot\'t be empty.')->getText());
        }
        
        if (strlen($this->name) > 30) {
            throw new \InvalidArgumentException(__('Option name is longer than 30 characters.')->getText());
        }
        
        if (strlen($this->value) > 100) {
            throw new \InvalidArgumentException(__('Option value is longer than 100 characters.')->getText());
        }
    }
    
    /**
     * Render css format
     *
     * @return string
     */
    public function toCss(): string
    {
        return $this->name.': '.$this->value.';';
    }
    
    /**
     * Convert to array
     *
     * @return array
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'value' => $this->value
        ];
    }
}
