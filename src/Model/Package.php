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

    /** @var ISender */
    private $sender;

    /** @var Recipient */
    private $recipient;

    /** @var null|SpecialDelivery */
    private $specialDelivery = null;

    /** @var null|PaymentInfo */
    private $paymentInfo = null;

    /** @var null|ExternalNumber */
    private $externalNumbers = [];

    /** @var PackageService[] */
    private $packageServices = [];

    /** @var Flag[] */
    private $flags = [];

    /** @var null|PalletInfo */
    private $palletInfo = null;

    /** @var null|WeightedPackageInfo */
    private $weightedPackageInfo = null;

    /** @var int */
    private $packageCount = 1;

    /** @var int */
    private $packagePosition = 1;

    /**
     * Package constructor.
     * @param null|integer $seriesNumberId
     * @param int $packageProductType
     * @param float $weight
     * @param string $note
     * @param string $depoCode
     * @param ISender $sender
     * @param Recipient $recipient
     * @param null|SpecialDelivery $specialDelivery
     * @param null|PaymentInfo $paymentInfo
     * @param ExternalNumber[] $externalNumbers
     * @param PackageService[] $packageServices
     * @param Flag[] $flags
     * @param null|PalletInfo $palletInfo
     * @param null|WeightedPackageInfo $weightedPackageInfo
     * @param integer $packageCount
     * @param integer $packagePosition
     * @throws WrongDataException
     */
    public function __construct(
        $seriesNumberId,
        $packageProductType,
        $weight,
        $note,
        $depoCode,
        ISender $sender,
        Recipient $recipient,
        SpecialDelivery $specialDelivery = null,
        PaymentInfo $paymentInfo = null,
        array $externalNumbers = [],
        array $packageServices = [],
        array $flags = [],
        PalletInfo $palletInfo = null,
        WeightedPackageInfo $weightedPackageInfo = null,
        $packageCount = 1,
        $packagePosition = 1
    ) {
        if (in_array($packageProductType, Product::$cashOnDelivery) && is_null($paymentInfo)) {
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
        $this->setPackageServices($packageServices);
        $this->setFlags($flags);
        $this->setPalletInfo($palletInfo);
        $this->setWeightedPackageInfo($weightedPackageInfo);
        $this->setPackageCount($packageCount);
        $this->setPackagePosition($packagePosition);


        if (!is_null($seriesNumberId)) {
            $this->setSeriesNumberId($seriesNumberId);
        }
    }

    /**
     * @param $seriesNumberId
     * @throws WrongDataException
     */
    public function setSeriesNumberId($seriesNumberId)
    {
        if (!is_numeric($seriesNumberId)) {
            throw new WrongDataException('$seriesNumberId has wrong format');
        }

        $this->seriesNumberId = $seriesNumberId;
        $this->setPackageNumber(Tools::generatePackageNumber($this));
    }

    /**
     * @param null|string $note
     * @throws WrongDataException
     */
    public function setNote($note = null)
    {
        $noteLen = mb_strlen($note);
        if ($noteLen > 300) {
            throw new WrongDataException(sprintf('$note is longer than 300 characters (%s)', $noteLen));
        }

        $this->note = $note;
    }

    /**
     * @param $packageProductType
     * @throws WrongDataException
     */
    public function setPackageProductType($packageProductType)
    {
        if (!in_array($packageProductType, Product::$list)) {
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
     * @throws WrongDataException
     */
    public function setDepoCode($depoCode)
    {
        if (!in_array($depoCode, Depo::$list)) {
            throw new WrongDataException(sprintf('$depoCode has wrong value, only %s are allowed', implode(', ', Depo::$list)));
        }
        $this->depoCode = $depoCode;
    }

    /**
     * @param ISender $sender
     */
    public function setSender(ISender $sender)
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
     * @param ExternalNumber[] $externalNumbers
     */
    public function setExternalNumbers(array $externalNumbers)
    {
        $this->externalNumbers = $externalNumbers;
    }

    /**
     * @param PackageService[] $packageServices
     */
    public function setPackageServices(array $packageServices)
    {
        $this->packageServices = $packageServices;
    }

    /**
     * @param Flag[] $flags
     */
    public function setFlags(array $flags)
    {
        $this->flags = $flags;
    }

    /**
     * @param null|PalletInfo $palletInfo
     */
    public function setPalletInfo(PalletInfo $palletInfo = null)
    {
        $this->palletInfo = $palletInfo;
    }

    /**
     * @param null|WeightedPackageInfo $weightedPackageInfo
     */
    public function setWeightedPackageInfo($weightedPackageInfo)
    {
        $this->weightedPackageInfo = $weightedPackageInfo;
    }

    /**
     * @param int $packageCount
     */
    public function setPackageCount($packageCount)
    {
        $this->packageCount = $packageCount;
    }

    /**
     * @param int $packagePosition
     */
    public function setPackagePosition($packagePosition)
    {
        $this->packagePosition = $packagePosition;
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
     * @return ISender
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
     * @return ExternalNumber[]
     */
    public function getExternalNumbers()
    {
        return $this->externalNumbers;
    }

    /**
     * @return PackageService[]
     */
    public function getPackageServices()
    {
        return $this->packageServices;
    }

    /**
     * @return Flag[]
     */
    public function getFlags()
    {
        return $this->flags;
    }

    /**
     * @return PalletInfo
     */
    public function getPalletInfo()
    {
        return $this->palletInfo;
    }

    /**
     * @return null|WeightedPackageInfo
     */
    public function getWeightedPackageInfo()
    {
        return $this->weightedPackageInfo;
    }

    /**
     * @return int
     */
    public function getSeriesNumberId()
    {
        return $this->seriesNumberId;
    }

    /**
     * @return int
     */
    public function getPackageCount()
    {
        return $this->packageCount;
    }

    /**
     * @return int
     */
    public function getPackagePosition()
    {
        return $this->packagePosition;
    }
}
