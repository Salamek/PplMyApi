<?php
/**
 * Copyright (C) 2016 Adam Schubert <adam.schubert@sg1-game.net>.
 */

namespace Salamek\PplMyApi\Model;


use Salamek\PplMyApi\Enum\Depo;
use Salamek\PplMyApi\Enum\Product;
use Salamek\PplMyApi\Exception\WrongDataException;
use Salamek\PplMyApi\Tools;
use Salamek\PplMyApi\Validators\MaxLengthValidator;

class Package implements IPackage
{
    /** @var string */
    private $packageNumber;

    /** @var integer */
    private $packageProductType;

    /** @var string */
    private $note;

    /** @var string|null */
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

    /** @var IPackageSet */
    private $packageSet;

    /** @var ICityRouting */
    private $cityRouting;

    /**
     * Package constructor.
     * @param string $packageNumber Package number (40990019352)
     * @param int $packageProductType Product type
     * @param string $note note
     * @param IRecipient $recipient
     * @param ICityRouting $cityRouting
     * @param ISender $sender
     * @param string $depoCode code of depo, see Enum\Depo.php
     * @param null|ISpecialDelivery $specialDelivery
     * @param null|IPaymentInfo $paymentInfo
     * @param IExternalNumber[] $externalNumbers
     * @param IPackageService[] $packageServices
     * @param IFlag[] $flags
     * @param null|IPalletInfo $palletInfo
     * @param null|IWeightedPackageInfo $weightedPackageInfo
     * @param integer $packageCount
     * @param integer $packagePosition
     * @param null|string $masterPackageNumber
     * @throws WrongDataException
     */
    public function __construct(
        $packageNumber,
        $packageProductType,
        $note,
        $recipient,
        ICityRouting $cityRouting,
        $sender = null,
        $depoCode = null,
        ISpecialDelivery $specialDelivery = null,
        IPaymentInfo $paymentInfo = null,
        array $externalNumbers = [],
        array $packageServices = [],
        array $flags = [],
        IPalletInfo $palletInfo = null,
        IWeightedPackageInfo $weightedPackageInfo = null,
        IPackageSet $packageSet = null
    ) {
        if (in_array($packageProductType, Product::$cashOnDelivery) && is_null($paymentInfo)) {
            throw new WrongDataException('$paymentInfo must be set if product type is CoD');
        }
        
        if ($packageSet === null) {
            // Set default package set if none is provided
            $packageSet = new PackageSet(
                    $packageNumber
            );
        }

        $this->setCityRouting($cityRouting);

        $this->setRecipient($recipient);
        $this->setSender($sender);
        $this->setPackageNumber($packageNumber);
        $this->setPackageProductType($packageProductType);
        $this->setNote($note);
        $this->setDepoCode($depoCode);
        $this->setSpecialDelivery($specialDelivery);
        $this->setPaymentInfo($paymentInfo);
        $this->setExternalNumbers($externalNumbers);
        $this->setPackageServices($packageServices);
        $this->setFlags($flags);
        $this->setPalletInfo($palletInfo);
        $this->setWeightedPackageInfo($weightedPackageInfo);
        $this->setPackageSet($packageSet);

        if (in_array($flags, Product::$deliverySaturday) && is_null($palletInfo)) {
            throw new WrongDataException('Package requires Salamek\PplMyApi\Enum\Flag::SATURDAY_DELIVERY to be true or false');
        }
    }

    /**
     * @param null|string $note
     * @throws WrongDataException
     */
    public function setNote($note = null)
    {
        MaxLengthValidator::validate($note, 300);

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
     * @param string $depoCode
     * @throws WrongDataException
     */
    public function setDepoCode($depoCode)
    {
        if ($depoCode !== null && ! in_array($depoCode, Depo::$list)) {
            throw new WrongDataException(sprintf('$depoCode has wrong value, only %s are allowed', implode(', ', Depo::$list)));
        }
        $this->depoCode = $depoCode;
    }

    /**
     * @param ISender $sender
     */
    public function setSender(ISender $sender = null)
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
    public function setPaymentInfo(IPaymentInfo $paymentInfo = null)
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
    public function setWeightedPackageInfo(IWeightedPackageInfo $weightedPackageInfo = null)
    {
        $this->weightedPackageInfo = $weightedPackageInfo;
    }

    /**
     * @param null|IPackageSet $packageSet
     */
    public function setPackageSet(IPackageSet $packageSet): void
    {
        $this->packageSet = $packageSet;
    }


    /**
     * @param ICityRouting $cityRouting
     */
    public function setCityRouting(ICityRouting $cityRouting)
    {
        $this->cityRouting = $cityRouting;
    }


    /**
     * @return string
     */
    public function getPackageNumber()
    {
        return $this->packageNumber;
    }

    /**
     * @return string
     */
    public function getPackageNumberChecksum()
    {
        $checksum = null;
        $odd = 0;
        $even = 0;
        for ($i = 0; $i < strlen($this->packageNumber); $i++) {
            $n = substr($this->packageNumber, $i, 1);
            if (!($i % 2)) {
                $odd += $n;
            } else {
                $even += $n;
            }
        }
        $odd *= 3;
        $odd += $even;
        $checksum = 10 - substr($odd, -1);
        if ($checksum == 10) $checksum = 0;
        return $checksum;

    }

    /**
     * @return int
     */
    public function getPackageProductType()
    {
        return $this->packageProductType;
    }

    /**
     * @return string
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * @return string|null
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
     * @return IPackageSet
     */
    public function getPackageSet(): IPackageSet
    {
        return $this->packageSet;
    }

    /**
     * @return ICityRouting
     */
    public function getCityRouting()
    {
        return $this->cityRouting;
    }
}
