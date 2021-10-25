<?php

declare(strict_types=1);

namespace Webshippy\Enum;

abstract class Enum implements EnumInterface
{
    /**
     * @var int|string
     */
    protected $value;
    
    /**
     * @var array
     */
    protected static array $cache = [];
    
    /**
     * @var array
     */
    protected static array $objectCache = [];
    
    /**
     * @param mixed $value
     *
     * @throws \Exception
     */
    public function __construct($value)
    {
        self::checkConstant($value);
        $this->value = $value;
    }
    
    /**
     * @inheritdoc
     */
    public function getValue()
    {
        return $this->value;
    }
    
    /**
     * @inheritdoc
     */
    public static function create($value): EnumInterface
    {
        $class = get_called_class();
        if (!isset(static::$objectCache[$class][$value])) {
            static::$objectCache[$class][$value] = new $class($value);
        }
        
        return static::$objectCache[$class][$value];
    }
    
    /**
     * @param $const
     *
     * @return bool
     * @throws \Exception
     */
    public static function checkConstant($const): bool
    {
        if (self::hasConstant($const)) {
            return true;
        }
        throw new \Exception(
            sprintf(
                'Constant value not found: %s in enum class: %s',
                $const,
                get_called_class()
            )
        );
    }
    
    /**
     * @inheritdoc
     */
    public static function hasConstant($const): bool
    {
        return in_array($const, self::getConstants(), true);
    }
    
    /**
     * @inheritdoc
     */
    public static function getEnumValues(): array
    {
        return array_values(self::getConstants());
    }
    
    /**
     * @return array
     */
    protected static function getConstants(): array
    {
        $class = get_called_class();
        if (!isset(static::$cache[$class])) {
            static::$cache[$class] = (new \ReflectionClass($class))->getConstants();
        }
        
        return static::$cache[$class];
    }
    
    /**
     * @return string
     */
    public function __toString(): string
    {
        return (string)$this->getValue();
    }
}