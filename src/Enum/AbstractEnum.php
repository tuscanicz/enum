<?php

namespace Enum;

use InvalidArgumentException;
use ReflectionClass;

abstract class AbstractEnum implements EnumInterface
{
    /** @var mixed */
    private $value;

    /** @var array */
    private static $cache = [];

    /** @var mixed */
    protected static $defaultValue;

    /**
     * @param $value
     * @throws InvalidArgumentException
     */
    public function __construct($value = null)
    {
        if ($value === null) {
            $value = static::$defaultValue;
        }

        static::initialize();

        $this->setValue($value);
    }

    /**
     * @param $value
     * @return static
     */
    public static function create($value)
    {
        return new static($value);
    }

    /**
     * @return static
     */
    public static function getDefault()
    {
        return new static(self::getDefaultValue());
    }

    /**
     * @return mixed
     */
    public static function getDefaultValue()
    {
        return static::$defaultValue;
    }

    /**
     * @return array
     */
    protected static function loadValues()
    {
        $reflectionClass = new ReflectionClass(static::class);

        return $reflectionClass->getConstants();
    }

    protected static function initialize()
    {
        $className = static::class;
        if (isset(self::$cache[$className]['values']) === false) {
            self::$cache[$className]['values'] = static::loadValues();
        }
    }

    /**
     * @return mixed[]
     */
    public static function getValues()
    {
        static::initialize();

        return self::$cache[static::class]['values'];
    }

    /**
     * @return static[]
     */
    public static function getEnums()
    {
        $className = static::class;
        if (!isset(self::$cache[$className]['enums'])) {
            foreach (static::getValues() as $value) {
                self::$cache[$className]['enums'][$value] = new static($value);
            }
        }

        return self::$cache[$className]['enums'];
    }

    /**
     * @return array
     */
    protected static function loadLabels()
    {
        $arr = [];
        foreach (static::getEnums() as $enum) {
            $arr[$enum->getValue()] = $enum->getLabel();
        }

        return $arr;
    }

    /**
     * @return mixed
     */
    public static function getLabels()
    {
        $className = static::class;
        if (isset(self::$cache[$className]['labels']) === false) {
            self::$cache[$className]['labels'] = static::loadLabels();
        }

        return self::$cache[$className]['labels'];
    }

    /**
     * @param $value
     * @return bool
     */
    public static function hasValue($value)
    {
        return in_array($value, static::getValues(), true);
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param mixed $value
     * @throws InvalidArgumentException
     */
    protected function checkValue($value)
    {
        if ($value === null) {
            throw new InvalidArgumentException('Enum value is not defined');
        }
        if (static::hasValue($value) === false) {
            throw new InvalidArgumentException('Value "' . $value . '" is not defined');
        }
    }

    /**
     * @param $value
     * @throws InvalidArgumentException
     */
    protected function setValue($value)
    {
        $this->checkValue($value);

        $this->value = $value;
    }

    /**
     * @return mixed
     */
    public function getLabel()
    {
        return $this->value;
    }

    /**
     * @param EnumInterface|string $value
     * @throws InvalidArgumentException
     * @return bool
     */
    public function is($value)
    {
        if ($value instanceof EnumInterface) {
            $value = $value->getValue();
        }

        $this->checkValue($value);

        return $value === $this->getValue();
    }

    protected function normalizeValues(array $values)
    {
        return array_map(function($value) {
            if ($value instanceof EnumInterface) {
                $value = $value->getValue();
            }

            $this->checkValue($value);

            return $value;
        }, $values);
    }

    /**
     * @param array $values [Enum::VALUE_1, new Enum(Enum:VALUE_2),]
     * @return bool
     */
    public function in(array $values)
    {
        return in_array($this->getValue(), $this->normalizeValues($values), true);
    }

    /**
     * @return mixed
     */
    public function __toString()
    {
        return (string)$this->value;
    }
}
