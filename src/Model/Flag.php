<?php
/**
 * Copyright (C) 2016 Adam Schubert <adam.schubert@sg1-game.net>.
 */

namespace Salamek\PplMyApi\Model;


use Salamek\PplMyApi\Enum\Flag as FlagEnum;
use Salamek\PplMyApi\Exception\WrongDataException;

class Flag
{
    /** @var string */
    public $code;

    /** @var boolean */
    public $value = true;

    /**
     * Flag constructor.
     * @param string $code
     * @param bool $value
     */
    public function __construct($code, $value)
    {
        $this->setCode($code);
        $this->setValue($value);
    }

    /**
     * @param string $code
     * @throws WrongDataException
     */
    public function setCode($code)
    {
        if (!in_array($code, FlagEnum::$list)) {
            throw new WrongDataException(sprintf('$code has wrong value, only %s are allowed', implode(', ', FlagEnum::$list)));
        }
        $this->code = $code;
    }

    /**
     * @param boolean $value
     * @throws WrongDataException
     */
    public function setValue($value)
    {
        if (!is_bool($value)) {
            throw new WrongDataException('$value has wrong value');
        }
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return boolean
     */
    public function isValue()
    {
        return $this->value;
    }
}