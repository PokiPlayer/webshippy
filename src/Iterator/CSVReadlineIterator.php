<?php

declare(strict_types=1);

namespace Webshippy\Iterator;

class CSVReadlineIterator implements \Iterator
{
    public const MODE                   = 'rb';
    public const ALLOWED_FILE_EXTENSION = 'csv';
    
    /**
     * @var resource
     */
    protected $resource;
    
    /**
     * @var string
     */
    protected string $delim;
    
    /**
     * @var bool
     */
    protected bool $skipHeader;
    
    /**
     * @var int
     */
    protected int $cnt = 0;
    
    /**
     * @var array
     */
    protected array $current = [];
    
    /**
     * @param string $filename
     * @param string $delim
     * @param bool   $skipHeader
     *
     * @throws \Exception
     */
    public function __construct(string $filename, string $delim = ',', bool $skipHeader = true)
    {
        $this->isExist($filename);
        $this->checkMimeType($filename);
        $this->resource   = fopen($filename, self::MODE);
        $this->delim      = $delim;
        $this->skipHeader = $skipHeader;
    }
    
    /**
     * @param string $filename
     *
     * @return void
     *
     * @throws \Exception
     */
    protected function isExist(string $filename): void
    {
        if (!is_file($filename) || !is_readable($filename)) {
            throw new \Exception(sprintf('\"%s\" is not exists or not readeable!', $filename));
        }
    }
    
    /**
     * @param string $filename
     *
     * @throws \Exception
     */
    protected function checkMimeType(string $filename): void
    {
        if (self::ALLOWED_FILE_EXTENSION !== $extension = pathinfo($filename)['extension']) {
            throw new \Exception(sprintf('\"%s\" extension is not allowed', $extension));
        }
    }
    
    /**
     * @inheritDoc
     */
    public function rewind()
    {
        $this->current = [];
        $this->cnt     = 0;
        
        if (is_resource($this->resource)) {
            rewind($this->resource);
        }
    }
    
    /**
     * @inheritDoc
     */
    public function current()
    {
        return $this->current;
    }
    
    /**
     * @inheritDoc
     */
    public function key()
    {
        return $this->cnt;
    }
    
    /**
     * @inheritDoc
     */
    public function next()
    {
        $this->cnt++;
    }
    
    /**
     * @inheritDoc
     */
    public function valid()
    {
        if (!is_resource($this->resource)) {
            return false;
        }
        
        if (feof($this->resource)) {
            fclose($this->resource);
            
            return false;
        }
        
        if ($this->cnt === 0 && true === $this->skipHeader) {
            fgets($this->resource); // @TODO: ez elegánsabban kéne megoldani, mondjuk fseek-el pl
        }
        
        $current = $this->getLine();
        
        if (!is_array($current)) {
            return false;
        }
        
        $this->current = $current;
        
        return true;
    }
    
    /**
     * @return array
     */
    protected function getLine()
    {
        return fgetcsv($this->resource, 4096, $this->delim);
    }
}