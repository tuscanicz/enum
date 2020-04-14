Strict Enum v3
====

PHP implementation of enumeration with strict comparisons that work with integer or string values.

## Example of numeric version

```php
<?php

use Enum\AbstractNumericEnum;

class Day extends AbstractNumericEnum
{
    public const SUNDAY = 0;
    public const MONDAY = 1;
    public const TUESDAY = 2;
    public const WEDNESDAY = 3;
    public const THURSDAY = 4;
    public const FRIDAY = 5;
    public const SATURDAY = 6;

    public function getLabel(): string
    {
        return date('l', strtotime(sprintf('Sunday + %d Days', $this->getValue())));
    }
}

$monday = new Day(Day::MONDAY);
echo $monday->getValue();
// 1
echo $monday;
// 1
print_r(Day::getValues());
// Array ( [SUNDAY] => 0 [MONDAY] => 1 [TUESDAY] => 2 [WEDNESDAY] => 3 [THURSDAY] => 4 [FRIDAY] => 5 [SATURDAY] => 6 )
echo $monday->getLabel();
// Monday
print_r(Day::getLabels());
// Array ( [0] => Sunday [1] => Monday [2] => Tuesday [3] => Wednesday [4] => Thursday [5] => Friday [6] => Saturday )
```

## Example of string version

```php
<?php

use Enum\AbstractStringEnum;

class Day extends AbstractStringEnum
{
    public const SUNDAY = 'sunday';
    public const MONDAY = 'monday';
    public const TUESDAY = 'tuesday';
    public const WEDNESDAY = 'wednesday';
    public const THURSDAY = 'thursday';
    public const FRIDAY = 'friday';
    public const SATURDAY = 'saturday';

    public function getLabel(): string
    {
        return date('l', strtotime(sprintf('Today is %s', $this->getValue())));
    }
}

$monday = new Day(Day::MONDAY);
echo $monday->getValue();
// 'monday'
echo $monday;
// 'monday'
```

# Supported versions

You are now reading documentation of **v3.x** that benefits from **PHP 7.4 features** and is no longer compatible with older version.
For PHP versions *>=5.6*, use **v2.1.x** version that **is still maintained**.

# Migration from 2.1.x to 3.x

You need to refactor all the usages of AbstractEnum into two versions for separate types:
- AbstractNumericEnum
- AbstractStringEnum

In order to help you with the migration, final version 3.x should contain a migration script
 that will refactor your usages automatically by a detected type. 

# Contribute

[![Build Status](https://travis-ci.org/tuscanicz/enum.svg?branch=develop)](https://travis-ci.org/tuscanicz/enum)

Feel free to contribute!

Please, run the tests via phpunit ``composer ci`` and keep the full code coverage and coding standards.
