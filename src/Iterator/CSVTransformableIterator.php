<?php

declare(strict_types=1);

namespace Webshippy\Iterator;

abstract class CSVTransformableIterator extends \IteratorIterator
{
    /**
     * @return mixed|void
     */
    public function current()
    {
        $data   = parent::current();
        
        $class  = $this->getObjectClass();
        $object = new $class();
        
        $this->transform($data, $object);
        
        return $object;
    }
    
    /**
     * @return string
     */
    abstract protected function getObjectClass(): string;
    
    /**
     * @param mixed $from
     * @param mixed $to
     *
     * @return void
     */
    abstract protected function transform($from, $to): void;
}