<?php
/**
 * Copyright (C) 2016 Adam Schubert <adam.schubert@sg1-game.net>.
 */

namespace Salamek\PplMyApi\Model;

class RoutedPackage extends Package
{
    /** @var string */
    private $routeCode;

    /** @var string */
    private $routeDepoCode;

    /** @var bool */
    private $routeDepoHighlighted;

    /**
     * Package constructor.
     * @param string $packageNumber Package number (40990019352)
     * @param int $packageProductType Product type
     * @param float $weight weight
     * @param string $note note
     * @param string $depoCode code of depo, see Enum\Depo.php
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
     * @param bool $forceOwnPackageNumber
     * @param string $routeCode
     * @param string $routeDepoCode
     * @param bool $routeDepoHighlighted
     * @throws WrongDataException
     */
    public function __construct(
        $packageNumber,
        $packageProductType,
        $weight,
        $note,
        $depoCode,
        $recipient,
        $sender = null,
        ISpecialDelivery $specialDelivery = null,
        IPaymentInfo $paymentInfo = null,
        array $externalNumbers = [],
        array $packageServices = [],
        array $flags = [],
        IPalletInfo $palletInfo = null,
        IWeightedPackageInfo $weightedPackageInfo = null,
        $packageCount = 1,
        $packagePosition = 1,
        $forceOwnPackageNumber = false,
        $routeCode,
        $routeDepoCode,
        $routeDepoHighlighted
    ) {
        parent::__construct($packageNumber, $packageProductType, $weight, $note, $depoCode, $recipient, $sender, $specialDelivery, $paymentInfo, $externalNumbers,$packageServices,$flags,$palletInfo,$weightedPackageInfo,$packageCount,$packagePosition,$forceOwnPackageNumber);
        $this->routeCode=$routeCode;
        $this->routeDepoCode=$routeDepoCode;
        $this->routeDepoHighlighted=$routeDepoHighlighted;
    }
    
    function getRouteCode() {
        return $this->routeCode;
    }

    function getRouteDepoCode() {
        return $this->routeDepoCode;
    }

    function getRouteDepoHighlighted() {
        return $this->routeDepoHighlighted;
    }



}
