<?php
/**
 * Copyright (C) 2016 Adam Schubert <adam.schubert@sg1-game.net>.
 */

namespace Salamek\PplMyApi\Model;


use Salamek\PplMyApi\Exception\WrongDataException;

/**
 * Interface IPackage
 * @package Salamek\PplMyApi\Model
 */
interface IPackage
{
    /**
     * @param $seriesNumberId
     * @throws WrongDataException
     */
    public function setSeriesNumberId($seriesNumberId);

    /**
     * @param null|string $note
     * @throws WrongDataException
     */
    public function setNote($note = null);

    /**
     * @param $packageProductType
     * @throws WrongDataException
     */
    public function setPackageProductType($packageProductType);

    /**
     * @param string $packageNumber
     */
    public function setPackageNumber($packageNumber);

    /**
     * @param float $weight
     */
    public function setWeight($weight);

    /**
     * @param string $depoCode
     * @throws WrongDataException
     */
    public function setDepoCode($depoCode);

    /**
     * @param ISender $sender
     */
    public function setSender(ISender $sender);

    /**
     * @param IRecipient $recipient
     */
    public function setRecipient(IRecipient $recipient);

    /**
     * @param null|ISpecialDelivery $specialDelivery
     */
    public function setSpecialDelivery(ISpecialDelivery $specialDelivery = null);

    /**
     * @param null|IPaymentInfo $paymentInfo
     */
    public function setPaymentInfo(IPaymentInfo $paymentInfo);

    /**
     * @param IExternalNumber[] $externalNumbers
     */
    public function setExternalNumbers(array $externalNumbers);

    /**
     * @param IPackageService[] $packageServices
     */
    public function setPackageServices(array $packageServices);

    /**
     * @param IFlag[] $flags
     */
    public function setFlags(array $flags);

    /**
     * @param null|IPalletInfo $palletInfo
     */
    public function setPalletInfo(IPalletInfo $palletInfo = null);

    /**
     * @param null|IWeightedPackageInfo $weightedPackageInfo
     */
    public function setWeightedPackageInfo(IWeightedPackageInfo $weightedPackageInfo);

    /**
     * @param int $packageCount
     */
    public function setPackageCount($packageCount);

    /**
     * @param int $packagePosition
     */
    public function setPackagePosition($packagePosition);

    /**
     * @return string
     */
    public function getPackageNumber();

    /**
     * @return int
     */
    public function getPackageProductType();

    /**
     * @return float
     */
    public function getWeight();

    /**
     * @return string
     */
    public function getNote();

    /**
     * @return string
     */
    public function getDepoCode();

    /**
     * @return ISender
     */
    public function getSender();

    /**
     * @return IRecipient
     */
    public function getRecipient();

    /**
     * @return null|ISpecialDelivery
     */
    public function getSpecialDelivery();

    /**
     * @return null|IPaymentInfo
     */
    public function getPaymentInfo();

    /**
     * @return IExternalNumber[]
     */
    public function getExternalNumbers();

    /**
     * @return IPackageService[]
     */
    public function getPackageServices();

    /**
     * @return IFlag[]
     */
    public function getFlags();

    /**
     * @return IPalletInfo
     */
    public function getPalletInfo();

    /**
     * @return null|IWeightedPackageInfo
     */
    public function getWeightedPackageInfo();

    /**
     * @return int
     */
    public function getSeriesNumberId();

    /**
     * @return int
     */
    public function getPackageCount();

    /**
     * @return int
     */
    public function getPackagePosition();
}
