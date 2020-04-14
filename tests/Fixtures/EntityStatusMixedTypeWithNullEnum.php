<?php

declare(strict_types = 1);

namespace Fixtures;

use Enum\AbstractEnum;

class EntityStatusMixedTypeWithNullEnum extends AbstractEnum
{

    public const NEW_ENTITY = null;
    public const MODIFIED_ENTITY = 2;
    public const SAVED_ENTITY = 'saved';
    public const DEFAULT_ENTITY_STATUS = 'default-value';

    protected static $defaultValue = self::DEFAULT_ENTITY_STATUS;

}
