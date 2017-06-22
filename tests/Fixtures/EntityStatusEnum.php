<?php

namespace Fixtures;

use Enum\AbstractEnum;

class EntityStatusEnum extends AbstractEnum
{
    const NEW_ENTITY = 'new';
    const MODIFIED_ENTITY = 'modified';
    const SAVED_ENTITY = 'saved';

    protected static $defaultValue = self::NEW_ENTITY;
}
