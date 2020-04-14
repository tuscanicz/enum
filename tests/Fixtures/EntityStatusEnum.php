<?php

declare(strict_types = 1);

namespace Fixtures;

use Enum\AbstractEnum;

class EntityStatusEnum extends AbstractEnum
{

    public const NEW_ENTITY = 'new';
    public const MODIFIED_ENTITY = 'modified';
    public const SAVED_ENTITY = 'saved';

    protected static $defaultValue = self::NEW_ENTITY;

}
