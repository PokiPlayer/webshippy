<?php

declare(strict_types=1);

namespace Webshippy\Service\Render;

use ReflectionClass;
use ReflectionProperty;

abstract class ObjectAwareDataTableRenderer
{
    protected int                 $columnWidth;
    protected string              $headerSeparatorLine;
    
    public function __construct(int $columnWidth = 20, string $headerSeparatorLine = '=')
    {
        $this->columnWidth         = $columnWidth;
        $this->headerSeparatorLine = $headerSeparatorLine;
    }
    
    /**
     * @throws \ReflectionException
     */
    public function renderDataHeader(): void
    {
        $properties = (new ReflectionClass($this->getSupportedDataObjectClass()))->getProperties();
        
        foreach ($properties as $column) {
            /** @var ReflectionProperty $column */
            echo str_pad($column->getName(), $this->columnWidth);
        }
        
        $this->breakLine();
        
        for ($i = 0, $iMax = count($properties); $i <= $iMax; $i++) {
            echo str_repeat($this->headerSeparatorLine, $this->columnWidth);
        }
        
        $this->breakLine();
    }
    
    /**
     * @inheritDoc
     */
    public function renderDataRow($dataRow): void
    {
        if (!is_object($dataRow)) {
            throw new \InvalidArgumentException(sprintf('data row argument is not object!'));
        }
        
        if (get_class($dataRow) !== $this->getSupportedDataObjectClass()) {
            throw new \InvalidArgumentException(sprintf('Data row argument is not supported!'));
        }
        
        $row = (array)$dataRow;
        foreach ($row as $key => $value) {
            if ($value instanceof \DateTime) {
                echo str_pad($value->format('Y-m-d H:i:s'), $this->columnWidth);
                continue;
            }
            
            echo str_pad((string)$value, $this->columnWidth);
        }
        
        $this->breakLine();
    }
    
    /**
     * @return void
     */
    public function breakLine(): void
    {
        echo "\n";
    }
    
    /**
     * @return string
     */
    abstract protected function getSupportedDataObjectClass(): string;
}