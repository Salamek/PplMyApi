<?php
/**
 * Copyright (C) 2016 Adam Schubert <adam.schubert@sg1-game.net>.
 */

namespace Salamek\PplMyApi\Model;


use Salamek\PplMyApi\Enum\ExternalNumber;

class ExternalNumbers
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
        if (!in_array($externalNumber, ExternalNumber::$list))
        {
            throw new \Exception(sprintf('$externalNumber has wrong value, only %s are allowed', implode(', ', ExternalNumber::$list)));
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