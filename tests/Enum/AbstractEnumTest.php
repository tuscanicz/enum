<?php

declare(strict_types = 1);

namespace Enum;

use Fixtures\EmployeeNameEnum;
use Fixtures\EmployeeNameWithLabelEnum;
use Fixtures\EntityStatusEnum;
use Fixtures\EntityStatusMixedTypeEnum;
use Fixtures\EntityStatusMixedTypeWithNullEnum;
use Fixtures\ExtendedEnum;
use InvalidArgumentException;
use PHPUnit\Framework\TestCase;

class AbstractEnumTest extends TestCase
{

    public function testConstructWithoutDefaultWillFail(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Enum value is not defined');

        new EmployeeNameEnum();
    }

    public function testConstructWithoutDefaultWithArgument(): void
    {
        $enum = new EmployeeNameEnum(EmployeeNameEnum::GEORGE_JONES);

        self::assertEquals('george-jones', $enum->getValue());
        self::assertEquals('george-jones', $enum->getLabel());
    }

    public function testConstructExtended(): void
    {
        $enum = new ExtendedEnum(ExtendedEnum::GEORGE_JONES);

        self::assertEquals('george-jones', $enum->getValue());
        self::assertEquals('george-jones', $enum->getLabel());
    }

    public function testConstructWithMixed(): void
    {
        $enumString = new EntityStatusMixedTypeEnum(EntityStatusMixedTypeEnum::NEW_ENTITY);

        self::assertEquals('new', $enumString->getValue());
        self::assertEquals('new', $enumString->getLabel());

        $enumNumeric = new EntityStatusMixedTypeEnum(EntityStatusMixedTypeEnum::MODIFIED_ENTITY);

        self::assertEquals(2, $enumNumeric->getValue());
        self::assertEquals(2, $enumNumeric->getLabel());
    }

    public function testConstructWithNullAndMixed(): void
    {
        $enumWithNullValue = new EntityStatusMixedTypeWithNullEnum(EntityStatusMixedTypeWithNullEnum::NEW_ENTITY);

        self::assertEquals('default-value', $enumWithNullValue->getValue());
        self::assertEquals('default-value', $enumWithNullValue->getLabel());

        $enumNumeric = new EntityStatusMixedTypeWithNullEnum(EntityStatusMixedTypeWithNullEnum::MODIFIED_ENTITY);

        self::assertEquals(2, $enumNumeric->getValue());
        self::assertEquals(2, $enumNumeric->getLabel());
    }

    public function testConstructWithInvalidArgumentWillFail(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Value "invalid" is not defined');

        new EmployeeNameEnum('invalid');
    }

    public function testCreateWithoutDefaultAsArgument(): void
    {
        $enum = EmployeeNameEnum::create(EmployeeNameEnum::GEORGE_JONES);

        self::assertEquals('george-jones', $enum->getValue());
        self::assertEquals('george-jones', $enum->getLabel());
        self::assertEquals('george-jones', (string)$enum);
    }

    public function testHasCorrectValues(): void
    {
        self::assertNull(EmployeeNameEnum::getDefaultValue());
        self::assertTrue(EmployeeNameEnum::hasValue('george-jones'));
    }

    public function testGetDefaultWithoutDefaultWillFail(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Enum value is not defined');

        self::assertNull(EmployeeNameEnum::getDefault());
    }

    public function testGetValues(): void
    {
        self::assertContains('george-jones', EmployeeNameEnum::getValues());
        self::assertCount(5, EmployeeNameEnum::getValues());
    }

    public function testGetLabels(): void
    {
        self::assertContains('george-jones', EmployeeNameEnum::getLabels());
        self::assertCount(5, EmployeeNameEnum::getLabels());
    }

    public function testIs(): void
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

    public function testWithCustomLabel(): void
    {
        $enum = new EmployeeNameWithLabelEnum(EmployeeNameWithLabelEnum::GEORGE_JONES);

        self::assertEquals('george-jones', $enum->getValue());
        self::assertEquals('Label of value: george-jones (12 character long)', $enum->getLabel());
    }

    public function testExtendedIs(): void
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

    public function testIn(): void
    {
        $enum = new EmployeeNameEnum(EmployeeNameEnum::GEORGE_JONES);

        self::assertTrue(
            $enum->in(
                [
                    EmployeeNameEnum::GEORGE_JONES,
                    EmployeeNameEnum::JANE_BROWN,
                ]
            )
        );
        self::assertFalse(
            $enum->in(
                [
                    EmployeeNameEnum::JANE_BROWN,
                    EmployeeNameEnum::MARY_WILSON,
                ]
            )
        );
        self::assertTrue(
            $enum->in(
                [
                    new EmployeeNameEnum(EmployeeNameEnum::GEORGE_JONES),
                    new EmployeeNameEnum(EmployeeNameEnum::JANE_BROWN),
                ]
            )
        );
        self::assertFalse(
            $enum->in(
                [
                    new EmployeeNameEnum(EmployeeNameEnum::JANE_BROWN),
                    new EmployeeNameEnum(EmployeeNameEnum::MARY_WILSON),
                ]
            )
        );
    }

    public function testExtendedIn(): void
    {
        $enum = new ExtendedEnum(ExtendedEnum::GEORGE_JONES);

        self::assertTrue(
            $enum->in(
                [
                    ExtendedEnum::GEORGE_JONES,
                    ExtendedEnum::JANE_BROWN,
                ]
            )
        );
        self::assertFalse(
            $enum->in(
                [
                    ExtendedEnum::JANE_BROWN,
                    ExtendedEnum::MARY_WILSON,
                ]
            )
        );
        self::assertTrue(
            $enum->in(
                [
                    new ExtendedEnum(ExtendedEnum::GEORGE_JONES),
                    new ExtendedEnum(ExtendedEnum::JANE_BROWN),
                ]
            )
        );
        self::assertFalse(
            $enum->in(
                [
                    new ExtendedEnum(ExtendedEnum::JANE_BROWN),
                    new ExtendedEnum(ExtendedEnum::MARY_WILSON),
                ]
            )
        );
    }

    public function testConstructWithDefault(): void
    {
        $enum = new EntityStatusEnum();

        self::assertEquals('new', $enum->getValue());
        self::assertEquals('new', $enum->getLabel());
    }

    public function testGetDefaultWithDefault(): void
    {
        self::assertEquals('new', EntityStatusEnum::getDefault());
        self::assertEquals('new', EntityStatusEnum::getDefaultValue());
    }

}
