<?php

declare(strict_types = 1);

namespace Enum;

interface EnumInterface
{

    /**
     * @param int|string $value
     */
    public function __construct($value);

    /**
     * @return int|string
     */
    public function getValue();

}
