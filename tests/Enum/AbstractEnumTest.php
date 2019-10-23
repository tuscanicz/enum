<?php

namespace Enum;

use Fixtures\EmployeeNameEnum;
use Fixtures\EmployeeNameWithLabelEnum;
use Fixtures\EntityStatusEnum;
use Fixtures\ExtendedEnum;
use InvalidArgumentException;
use PHPUnit_Framework_TestCase;

class AbstractEnumTest extends PHPUnit_Framework_TestCase
{
    public function testConstructWithoutDefaultWillFail()
    {
        $this->setExpectedException(InvalidArgumentException::class, 'Enum value is not defined');

        new EmployeeNameEnum();
    }

    public function testConstructWithoutDefaultWithArgument()
    {
        $enum = new EmployeeNameEnum(EmployeeNameEnum::GEORGE_JONES);

        self::assertEquals('george-jones', $enum->getValue());
        self::assertEquals('george-jones', $enum->getLabel());
    }

    public function testConstructExtended()
    {
        $enum = new ExtendedEnum(ExtendedEnum::GEORGE_JONES);

        self::assertEquals('george-jones', $enum->getValue());
        self::assertEquals('george-jones', $enum->getLabel());
    }

    public function testConstructWithInvalidArgumentWillFail()
    {
        $this->setExpectedException(InvalidArgumentException::class, 'Value "invalid" is not defined');

        new EmployeeNameEnum('invalid');
    }

    public function testCreateWithoutDefaultAsArgument()
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

    public function testWithCustomLabel()
    {
        $enum = new EmployeeNameWithLabelEnum(EmployeeNameWithLabelEnum::GEORGE_JONES);

        self::assertEquals('george-jones', $enum->getValue());
        self::assertEquals('Label of value: george-jones (12 character long)', $enum->getLabel());
    }

    public function testExtendedIs()
    {
        $enum = new ExtendedEnum(ExtendedEnum::GEORGE_JONES);

        self::assertTrue($enum->is(ExtendedEnum::GEORGE_JONES));
        self::assertFalse($enum->is(ExtendedEnum::JANE_BROWN));
        self::assertTrue(
            $enum->is(
                new ExtendedEnum(ExtendedEnum::GEORGE_JONES)
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

    public function testExtendedIn()
    {
        $enum = new ExtendedEnum(ExtendedEnum::GEORGE_JONES);

        self::assertTrue(
            $enum->in(
                [
                    ExtendedEnum::GEORGE_JONES,
                    ExtendedEnum::JANE_BROWN
                ]
            )
        );
        self::assertFalse(
            $enum->in(
                [
                    ExtendedEnum::JANE_BROWN,
                    ExtendedEnum::MARY_WILSON
                ]
            )
        );
        self::assertTrue(
            $enum->in(
                [
                    new ExtendedEnum(ExtendedEnum::GEORGE_JONES),
                    new ExtendedEnum(ExtendedEnum::JANE_BROWN)
                ]
            )
        );
        self::assertFalse(
            $enum->in(
                [
                    new ExtendedEnum(ExtendedEnum::JANE_BROWN),
                    new ExtendedEnum(ExtendedEnum::MARY_WILSON)
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
        self::assertEquals('new', EntityStatusEnum::getDefaultValue());
    }
}
