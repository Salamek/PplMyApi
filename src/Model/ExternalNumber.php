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
     */
    public function setCode($code)
    {
        $this->code = $code;
    }

    /**
     * @param string $externalNumber
     * @throws \Exception
     */
    public function setExternalNumber($externalNumber)
    {
        if (!in_array($externalNumber, ExternalNumberEnum::$list))
        {
            throw new WrongDataException(sprintf('$externalNumber has wrong value, only %s are allowed', implode(', ', ExternalNumberEnum::$list)));
        }

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