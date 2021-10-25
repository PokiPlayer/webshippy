<?php

declare(strict_types=1);

namespace Webshippy\Enum;

class PriorityEnum extends Enum
{
    public const HIGH   = 'high';
    public const MEDIUM = 'medium';
    public const LOW    = 'low';
    
    /**
     * @var array|string[]
     */
    protected static array $priorityIdEnumMap = [
        0 => self::LOW,
        1 => self::LOW,
        2 => self::MEDIUM,
        3 => self::HIGH,
    ];
    
    /**
     * @return int
     */
    public function getPriorityId(): int{
        return array_search($this->getValue(), self::$priorityIdEnumMap, true);
    }
    
    /**
     * @param int $id
     *
     * @return PriorityEnum
     * @throws \Exception
     */
    public static function getEnumById(int $id): PriorityEnum
    {
        if (!array_key_exists($id, self::$priorityIdEnumMap)) {
            throw new \Exception(sprintf('Not found PriorityEnum by id: "%s"', $id));
        }
    
        return self::create(self::$priorityIdEnumMap[$id]);
    }
}