<?php

declare(strict_types=1);

namespace Webshippy\DataObject;

use Webshippy\Enum\PriorityEnum;

class Order
{
    protected int $product_id;
    
    protected int $quantity;
    
    protected PriorityEnum $priority;
    
    protected \DateTime $created_at;
    
    /**
     * @return int
     */
    public function getProductId(): int
    {
        return $this->product_id;
    }
    
    /**
     * @param int $product_id
     */
    public function setProductId(int $product_id): void
    {
        $this->product_id = $product_id;
    }
    
    /**
     * @return int
     */
    public function getQuantity(): int
    {
        return $this->quantity;
    }
    
    /**
     * @param int $quantity
     */
    public function setQuantity(int $quantity): void
    {
        $this->quantity = $quantity;
    }
    
    /**
     * @return PriorityEnum
     */
    public function getPriority(): PriorityEnum
    {
        return $this->priority;
    }
    
    /**
     * @param PriorityEnum $priority
     */
    public function setPriority(PriorityEnum $priority): void
    {
        $this->priority = $priority;
    }
    
    /**
     * @return \DateTime
     */
    public function getCreatedAt(): \DateTime
    {
        return $this->created_at;
    }
    
    /**
     * @param \DateTime $created_at
     */
    public function setCreatedAt(\DateTime $created_at): void
    {
        $this->created_at = $created_at;
    }
}