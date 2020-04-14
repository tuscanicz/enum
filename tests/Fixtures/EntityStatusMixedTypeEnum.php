<?php

declare(strict_types = 1);

namespace Fixtures;

use Enum\AbstractEnum;

class EntityStatusMixedTypeEnum extends AbstractEnum
{

    public const NEW_ENTITY = 'new';
    public const MODIFIED_ENTITY = 2;
    public const SAVED_ENTITY = 'saved';

    protected static $defaultValue = self::NEW_ENTITY;

}
