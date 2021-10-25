<?php

declare(strict_types=1);

namespace Webshippy\Enum;

interface EnumInterface
{
    /**
     * @return int|string
     */
    public function getValue();
    
    /**
     * @param $value
     *
     * @return EnumInterface
     */
    public static function create($value): EnumInterface;
    
    /**
     * @param $const
     *
     * @return bool
     */
    public static function checkConstant($const): bool;
    
    /**
     * @param $const
     *
     * @return bool
     */
    public static function hasConstant($const): bool;
    
    /**
     * @return array
     */
    public static function getEnumValues(): array;
}