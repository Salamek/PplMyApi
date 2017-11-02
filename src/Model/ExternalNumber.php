<?php
/**
 * Copyright (C) 2016 Adam Schubert <adam.schubert@sg1-game.net>.
 */

namespace Salamek\PplMyApi\Model;


use Salamek\PplMyApi\Enum\ExternalNumber as ExternalNumberEnum;
use Salamek\PplMyApi\Exception\WrongDataException;

class ExternalNumber
{
    /** @var string */
    private $code;

    /** @var string */
    private $externalNumber;

    /**
     * PackageExternalNumbers constructor.
     * @param string $code
     * @param string $externalNumber
     */
    public function __construct($code, $externalNumber)
    {
        $this->setCode($code);
        $this->setExternalNumber($externalNumber);
    }

    /**
     * @param string $code
     * @throws WrongDataException
     */
    public function setCode($code)
    {
        if (!in_array($code, ExternalNumberEnum::$list)) {
            throw new WrongDataException(sprintf('$code has wrong value, only %s are allowed', implode(', ', ExternalNumberEnum::$list)));
        }
        $this->code = $code;
    }

    /**
     * @param string $externalNumber
     */
    public function setExternalNumber($externalNumber)
    {
        $this->externalNumber = $externalNumber;
    }

    /**
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function getExternalNumber()
    {
        return $this->externalNumber;
    }

}
