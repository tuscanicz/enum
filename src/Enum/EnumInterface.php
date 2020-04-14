<?php

declare(strict_types = 1);

namespace Enum;

interface EnumInterface
{

    /**
     * @param mixed $value
     */
    public function __construct($value = null);

    /**
     * @return mixed
     */
    public function getValue();

}
