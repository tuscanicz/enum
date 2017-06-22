<?php

namespace Enum;

use Fixtures\EmployeeNameEnum;
use Fixtures\EntityStatusEnum;
use InvalidArgumentException;
use PHPUnit_Framework_TestCase;

class AbstractEnumTest extends PHPUnit_Framework_TestCase
{
    public function testConstructWithoutDefaultWillFail()
    {
        $this->setExpectedException(InvalidArgumentException::class, 'Enum value is not defined');

        new EmployeeNameEnum();
    }

    public function testConstructWithDefaultAsArgument()
    {
        $enum = new EmployeeNameEnum(EmployeeNameEnum::GEORGE_JONES);

        self::assertEquals('george-jones', $enum->getValue());
        self::assertEquals('george-jones', $enum->getLabel());
    }

    public function testConstructWithInvalidDefaultAsArgument()
    {
        $this->setExpectedException(InvalidArgumentException::class, 'Value "invalid" is not defined');

        new EmployeeNameEnum('invalid');
    }

    public function testCreateWithDefaultAsArgument()
    {
        $enum = EmployeeNameEnum::create(EmployeeNameEnum::GEORGE_JONES);

        self::assertEquals('george-jones', $enum->getValue());
        self::assertEquals('george-jones', $enum->getLabel());
        self::assertEquals('george-jones', (string)$enum);
    }

    public function testHasCorrectValues()
    {
        self::assertNull(EmployeeNameEnum::getDefaultValue());
        self::assertTrue(EmployeeNameEnum::hasValue('george-jones'));
    }

    public function testGetDefaultWithoutDefaultWillFail()
    {
        $this->setExpectedException(InvalidArgumentException::class, 'Enum value is not defined');

        self::assertNull(EmployeeNameEnum::getDefault());
    }

    public function testGetValues()
    {
        self::assertContains('george-jones', EmployeeNameEnum::getValues());
        self::assertCount(5, EmployeeNameEnum::getValues());
    }

    public function testGetLabels()
    {
        self::assertContains('george-jones', EmployeeNameEnum::getLabels());
        self::assertCount(5, EmployeeNameEnum::getLabels());
    }

    public function testIs()
    {
        $enum = new EmployeeNameEnum(EmployeeNameEnum::GEORGE_JONES);

        self::assertTrue($enum->is(EmployeeNameEnum::GEORGE_JONES));
        self::assertFalse($enum->is(EmployeeNameEnum::JANE_BROWN));
        self::assertTrue(
            $enum->is(
                new EmployeeNameEnum(EmployeeNameEnum::GEORGE_JONES)
            )
        );
    }

    public function testIn()
    {
        $enum = new EmployeeNameEnum(EmployeeNameEnum::GEORGE_JONES);

        self::assertTrue(
            $enum->in(
                [
                    EmployeeNameEnum::GEORGE_JONES,
                    EmployeeNameEnum::JANE_BROWN
                ]
            )
        );
        self::assertFalse(
            $enum->in(
                [
                    EmployeeNameEnum::JANE_BROWN,
                    EmployeeNameEnum::MARY_WILSON
                ]
            )
        );
        self::assertTrue(
            $enum->in(
                [
                    new EmployeeNameEnum(EmployeeNameEnum::GEORGE_JONES),
                    new EmployeeNameEnum(EmployeeNameEnum::JANE_BROWN)
                ]
            )
        );
        self::assertFalse(
            $enum->in(
                [
                    new EmployeeNameEnum(EmployeeNameEnum::JANE_BROWN),
                    new EmployeeNameEnum(EmployeeNameEnum::MARY_WILSON)
                ]
            )
        );
    }

    public function testConstructWithDefault()
    {
        $enum = new EntityStatusEnum();

        self::assertEquals('new', $enum->getValue());
        self::assertEquals('new', $enum->getLabel());
    }

    public function testGetDefaultWithDefault()
    {
        self::assertEquals('new', EntityStatusEnum::getDefault());
        self::assertEquals('new', EntityStatusEnum::getDefaultValue(true));
    }
}
