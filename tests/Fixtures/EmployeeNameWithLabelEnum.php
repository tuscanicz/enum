<?php

namespace Fixtures;

use Enum\AbstractEnum;

class EmployeeNameWithLabelEnum extends AbstractEnum
{
    const JOHN_SMITH = 'john-smith';
    const JANE_BROWN = 'jane-brown';
    const GEORGE_JONES = 'george-jones';
    const PHILLIP_JOHNSON = 'phillip-johnson';
    const MARY_WILSON = 'mary-wilson';

    public function getLabel()
    {
        return sprintf(
            'Label of value: %s (%d character long)',
            parent::getValue(),
            strlen(parent::getValue())
        );
    }
}
