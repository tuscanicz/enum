<?php

declare(strict_types = 1);

namespace Enum;

use InvalidArgumentException;
use ReflectionClass;

abstract class AbstractEnum implements EnumInterface
{

    /** @var string|int */
    private $value;

    /** @var mixed[] */
    private static array $cache;

    /** @var string|int */
    protected static $defaultValue;

    /**
     * @param string|int|null $value
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
     * @param string|int|null $value
     * @return static
     */
    public static function create($value): self
    {
        return new static($value);
    }

    public static function getDefault(): self
    {
        return new static(self::getDefaultValue());
    }

    /**
     * @return string|int
     */
    public static function getDefaultValue()
    {
        return static::$defaultValue;
    }

    /**
     * @return string[]|int[]
     */
    public static function getValues(): array
    {
        static::initialize();

        return self::$cache[static::class]['values'];
    }

    /**
     * @return static[]
     */
    public static function getEnums(): array
    {
        $className = static::class;
        if (isset(self::$cache[$className]['enums']) === false) {
            foreach (static::getValues() as $value) {
                self::$cache[$className]['enums'][$value] = new static($value);
            }
        }

        return self::$cache[$className]['enums'];
    }

    /**
     * @return array<int|string, int|string>
     */
    public static function getLabels(): array
    {
        $className = static::class;
        if (isset(self::$cache[$className]['labels']) === false) {
            self::$cache[$className]['labels'] = static::loadLabels();
        }

        return self::$cache[$className]['labels'];
    }

    /**
     * @param string|int|null $value
     * @return bool
     */
    public static function hasValue($value): bool
    {
        return in_array($value, static::getValues(), true);
    }

    /**
     * @return string|int
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return string|int
     */
    public function getLabel()
    {
        return $this->value;
    }

    /**
     * @param EnumInterface|string|int|null $value
     * @return bool
     * @throws InvalidArgumentException
     */
    public function is($value): bool
    {
        if ($value instanceof EnumInterface) {
            $value = $value->getValue();
        }
        $this->checkValue($value);

        return $value === $this->getValue();
    }

    /**
     * @param EnumInterface[]|string[]|int[]|null[] $values
     * @return bool
     */
    public function in(array $values): bool
    {
        return in_array($this->getValue(), $this->normalizeValues($values), true);
    }

    public function __toString(): string
    {
        return (string) $this->value;
    }

    private function normalizeValues(array $values): array
    {
        return array_map(function ($value) {
            if ($value instanceof EnumInterface) {
                $value = $value->getValue();
            }
            $this->checkValue($value);

            return $value;
        }, $values);
    }

    private static function initialize(): void
    {
        $className = static::class;
        if (isset(self::$cache[$className]['values']) === false) {
            self::$cache[$className]['values'] = static::loadValues();
        }
    }

    private static function loadValues(): array
    {
        $reflectionClass = new ReflectionClass(static::class);

        return $reflectionClass->getConstants();
    }

    /**
     * @return array<int|string, int|string>
     */
    private static function loadLabels(): array
    {
        $arr = [];
        foreach (static::getEnums() as $enum) {
            $arr[$enum->getValue()] = $enum->getLabel();
        }

        return $arr;
    }

    /**
     * @param string|int|null $value
     * @return void
     * @throws InvalidArgumentException
     */
    private function setValue($value): void
    {
        $this->checkValue($value);

        $this->value = $value;
    }

    /**
     * @param null|string|int $value
     * @return void
     * @throws InvalidArgumentException
     */
    private function checkValue($value): void
    {
        if ($value === null) {
            throw new InvalidArgumentException('Enum value is not defined');
        }
        if (static::hasValue($value) === false) {
            throw new InvalidArgumentException('Value "'.$value.'" is not defined');
        }
    }

}
