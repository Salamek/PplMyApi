<?php
/**
 * Copyright (C) 2016 Adam Schubert <adam.schubert@sg1-game.net>.
 */

namespace Salamek\PplMyApi\Model;


use Salamek\PplMyApi\Enum\Depo;
use Salamek\PplMyApi\Enum\Product;
use Salamek\PplMyApi\Exception\WrongDataException;
use Salamek\PplMyApi\Tools;

class Package
{
    /** @var integer */
    private $seriesNumberId;

    /** @var string */
    private $packageNumber;

    /** @var integer */
    private $packageProductType;

    /** @var float */
    private $weight;

    /** @var string */
    private $note;

    /** @var string */
    private $depoCode;

    /** @var Sender */
    private $sender;

    /** @var Recipient */
    private $recipient;

    /** @var null|SpecialDelivery */
    private $specialDelivery = null;

    /** @var null|PaymentInfo */
    private $paymentInfo = null;

    /** @var null|ExternalNumbers */
    private $externalNumbers = null;

    /**
     * Package constructor.
     * @param null|integer $seriesNumberId
     * @param int $packageProductType
     * @param float $weight
     * @param string $note
     * @param string $depoCode
     * @param Sender $sender
     * @param Recipient $recipient
     * @param null|SpecialDelivery $specialDelivery
     * @param null|PaymentInfo $paymentInfo
     * @param null|ExternalNumbers $externalNumbers
     * @throws \Exception
     */
    public function __construct($seriesNumberId, $packageProductType, $weight, $note, $depoCode, Sender $sender, Recipient $recipient, SpecialDelivery $specialDelivery = null, PaymentInfo $paymentInfo = null, ExternalNumbers $externalNumbers = null)
    {
        if (in_array($packageProductType, Product::$cashOnDelivery) && is_null($paymentInfo))
        {
            throw new WrongDataException('$paymentInfo must be set if product type is CoD');
        }

        $this->setPackageProductType($packageProductType);
        $this->setWeight($weight);
        $this->setNote($note);
        $this->setDepoCode($depoCode);
        $this->setSender($sender);
        $this->setRecipient($recipient);
        $this->setSpecialDelivery($specialDelivery);
        $this->setPaymentInfo($paymentInfo);
        $this->setExternalNumbers($externalNumbers);

        if (!is_null($seriesNumberId))
        {
            $this->setSeriesNumberId($seriesNumberId);
        }
    }

    /**
     * @param $seriesNumberId
     * @throws \Exception
     */
    public function setSeriesNumberId($seriesNumberId)
    {
        if (!is_numeric($seriesNumberId))
        {
            throw new WrongDataException('$seriesNumberId has wrong format');
        }

        $this->seriesNumberId = $seriesNumberId;
        $this->setPackageNumber(Tools::generatePackageNumber($this));
    }

    /**
     * @param null|string $note
     * @throws \Exception
     */
    public function setNote($note = null)
    {
        if (strlen($note) > 100)
        {
            throw new WrongDataException('$note is longer then 300 characters');
        }

        $this->note = $note;
    }

    /**
     * @param $packageProductType
     * @throws \Exception
     */
    public function setPackageProductType($packageProductType)
    {
        if (!in_array($packageProductType, Product::$list))
        {
            throw new WrongDataException(sprintf('$packageProductType has wrong value, only %s are allowed', implode(', ', Product::$list)));
        }
        $this->packageProductType = $packageProductType;
    }

    /**
     * @param string $packageNumber
     */
    public function setPackageNumber($packageNumber)
    {
        $this->packageNumber = $packageNumber;
    }

    /**
     * @param float $weight
     */
    public function setWeight($weight)
    {
        $this->weight = $weight;
    }

    /**
     * @param string $depoCode
     * @throws \Exception
     */
    public function setDepoCode($depoCode)
    {
        if (!in_array($depoCode, Depo::$list))
        {
            throw new WrongDataException(sprintf('$depoCode has wrong value, only %s are allowed', implode(', ', Depo::$list)));
        }
        $this->depoCode = $depoCode;
    }

    /**
     * @param Sender $sender
     */
    public function setSender(Sender $sender)
    {
        $this->sender = $sender;
    }

    /**
     * @param Recipient $recipient
     */
    public function setRecipient(Recipient $recipient)
    {
        $this->recipient = $recipient;
    }

    /**
     * @param null|SpecialDelivery $specialDelivery
     */
    public function setSpecialDelivery(SpecialDelivery $specialDelivery = null)
    {
        $this->specialDelivery = $specialDelivery;
    }

    /**
     * @param null|PaymentInfo $paymentInfo
     */
    public function setPaymentInfo($paymentInfo)
    {
        $this->paymentInfo = $paymentInfo;
    }

    /**
     * @param null|ExternalNumbers $externalNumbers
     */
    public function setExternalNumbers(ExternalNumbers $externalNumbers = null)
    {
        $this->externalNumbers = $externalNumbers;
    }

    /**
     * @return string
     */
    public function getPackageNumber()
    {
        return $this->packageNumber;
    }

    /**
     * @return int
     */
    public function getPackageProductType()
    {
        return $this->packageProductType;
    }

    /**
     * @return float
     */
    public function getWeight()
    {
        return $this->weight;
    }

    /**
     * @return string
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * @return string
     */
    public function getDepoCode()
    {
        return $this->depoCode;
    }

    /**
     * @return Sender
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * @return Recipient
     */
    public function getRecipient()
    {
        return $this->recipient;
    }

    /**
     * @return null|SpecialDelivery
     */
    public function getSpecialDelivery()
    {
        return $this->specialDelivery;
    }

    /**
     * @return null|PaymentInfo
     */
    public function getPaymentInfo()
    {
        return $this->paymentInfo;
    }

    /**
     * @return null|ExternalNumbers
     */
    public function getExternalNumbers()
    {
        return $this->externalNumbers;
    }

    /**
     * @return int
     */
    public function getSeriesNumberId()
    {
        return $this->seriesNumberId;
    }
}
