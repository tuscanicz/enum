<?php

declare(strict_types = 1);

namespace Enum;

use InvalidArgumentException;
use ReflectionClass;

// @todo: has the interface any value?
abstract class AbstractNumericEnum // implements EnumInterface
{

    private int $value;

    /** @var mixed[] */
    private static array $cache;

    final public function __construct(int $value)
    {
        static::initialize();

        $this->setValue($value);
    }

    public static function create(int $value): self
    {
        return new static($value);
    }

    /**
     * @return int[]
     */
    public static function getValues(): array
    {
        static::initialize();

        return self::$cache[static::class]['values'];
    }

    /**
     * @return self[]
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
     * @return array<int, int>
     */
    public static function getLabels(): array
    {
        $className = static::class;
        if (isset(self::$cache[$className]['labels']) === false) {
            self::$cache[$className]['labels'] = static::loadLabels();
        }

        return self::$cache[$className]['labels'];
    }

    public static function hasValue(int $value): bool
    {
        return in_array($value, static::getValues(), true);
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function getLabel(): string
    {
        return sprintf('%d', $this->value);
    }

    // @todo: will be a BC BREAK!
    public function is(EnumInterface $value): bool
    {
        if ($value instanceof EnumInterface) {
            $value = $value->getValue();
        }
        return $this->isValue($value);
    }

    public function isValue(int $value): bool
    {
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
