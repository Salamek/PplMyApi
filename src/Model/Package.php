<?php
/**
 * Copyright (C) 2016 Adam Schubert <adam.schubert@sg1-game.net>.
 */

namespace Salamek\PplMyApi\Model;


use Salamek\PplMyApi\Enum\Depo;
use Salamek\PplMyApi\Enum\Product;
use Salamek\PplMyApi\Exception\WrongDataException;
use Salamek\PplMyApi\Tools;

class Package implements IPackage
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

    /** @var IRecipient */
    private $recipient;

    /** @var null|ISpecialDelivery */
    private $specialDelivery = null;

    /** @var null|IPaymentInfo */
    private $paymentInfo = null;

    /** @var null|IExternalNumber[] */
    private $externalNumbers = [];

    /** @var IPackageService[] */
    private $packageServices = [];

    /** @var IFlag[] */
    private $flags = [];

    /** @var null|IPalletInfo */
    private $palletInfo = null;

    /** @var null|IWeightedPackageInfo */
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
     * @param IRecipient $recipient
     * @param null|ISpecialDelivery $specialDelivery
     * @param null|IPaymentInfo $paymentInfo
     * @param IExternalNumber[] $externalNumbers
     * @param IPackageService[] $packageServices
     * @param IFlag[] $flags
     * @param null|IPalletInfo $palletInfo
     * @param null|IWeightedPackageInfo $weightedPackageInfo
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
        IRecipient $recipient,
        ISpecialDelivery $specialDelivery = null,
        IPaymentInfo $paymentInfo = null,
        array $externalNumbers = [],
        array $packageServices = [],
        array $flags = [],
        IPalletInfo $palletInfo = null,
        IWeightedPackageInfo $weightedPackageInfo = null,
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

        if (in_array($flags, Product::$deliverySaturday) && is_null($palletInfo)) {
            throw new WrongDataException('Package requires Salamek\PplMyApi\Enum\Flag::SATURDAY_DELIVERY to be true or false');
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
     * @param IRecipient $recipient
     */
    public function setRecipient(IRecipient $recipient)
    {
        $this->recipient = $recipient;
    }

    /**
     * @param null|ISpecialDelivery $specialDelivery
     */
    public function setSpecialDelivery(ISpecialDelivery $specialDelivery = null)
    {
        $this->specialDelivery = $specialDelivery;
    }

    /**
     * @param null|IPaymentInfo $paymentInfo
     */
    public function setPaymentInfo(IPaymentInfo $paymentInfo)
    {
        $this->paymentInfo = $paymentInfo;
    }

    /**
     * @param IExternalNumber[] $externalNumbers
     */
    public function setExternalNumbers(array $externalNumbers)
    {
        $this->externalNumbers = $externalNumbers;
    }

    /**
     * @param IPackageService[] $packageServices
     */
    public function setPackageServices(array $packageServices)
    {
        $this->packageServices = $packageServices;
    }

    /**
     * @param IFlag[] $flags
     */
    public function setFlags(array $flags)
    {
        $this->flags = $flags;
    }

    /**
     * @param null|IPalletInfo $palletInfo
     */
    public function setPalletInfo(IPalletInfo $palletInfo = null)
    {
        $this->palletInfo = $palletInfo;
    }

    /**
     * @param null|IWeightedPackageInfo $weightedPackageInfo
     */
    public function setWeightedPackageInfo(IWeightedPackageInfo $weightedPackageInfo)
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
     * @return IRecipient
     */
    public function getRecipient()
    {
        return $this->recipient;
    }

    /**
     * @return null|ISpecialDelivery
     */
    public function getSpecialDelivery()
    {
        return $this->specialDelivery;
    }

    /**
     * @return null|IPaymentInfo
     */
    public function getPaymentInfo()
    {
        return $this->paymentInfo;
    }

    /**
     * @return IExternalNumber[]
     */
    public function getExternalNumbers()
    {
        return $this->externalNumbers;
    }

    /**
     * @return IPackageService[]
     */
    public function getPackageServices()
    {
        return $this->packageServices;
    }

    /**
     * @return IFlag[]
     */
    public function getFlags()
    {
        return $this->flags;
    }

    /**
     * @return IPalletInfo
     */
    public function getPalletInfo()
    {
        return $this->palletInfo;
    }

    /**
     * @return null|IWeightedPackageInfo
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
