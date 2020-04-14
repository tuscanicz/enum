<?php

declare(strict_types = 1);

namespace Fixtures;

use Enum\AbstractEnum;

class EmployeeNameWithLabelEnum extends AbstractEnum
{

    public const JOHN_SMITH = 'john-smith';
    public const JANE_BROWN = 'jane-brown';
    public const GEORGE_JONES = 'george-jones';
    public const PHILLIP_JOHNSON = 'phillip-johnson';
    public const MARY_WILSON = 'mary-wilson';

    public function getLabel(): string
    {
        return sprintf(
            'Label of value: %s (%d character long)',
            parent::getValue(),
            mb_strlen(parent::getValue())
        );
    }

}
