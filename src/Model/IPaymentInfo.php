<?php
/**
 * Copyright (C) 2016 Adam Schubert <adam.schubert@sg1-game.net>.
 */

namespace Salamek\PplMyApi\Model;


use Salamek\PplMyApi\Exception\WrongDataException;

/**
 * Interface IPaymentInfo
 * @package Salamek\PplMyApi\Model
 */
interface IPaymentInfo
{
    /**
     * @param null|string $bankAccount
     */
    public function setBankAccount($bankAccount);

    /**
     * @param null|string $bankCode
     * @todo add bank code check
     */
    public function setBankCode($bankCode);

    /**
     * @param null|string $cashOnDeliveryCurrency
     * @throws WrongDataException
     */
    public function setCashOnDeliveryCurrency($cashOnDeliveryCurrency);

    /**
     * @param int|null $cashOnDeliveryPrice
     */
    public function setCashOnDeliveryPrice($cashOnDeliveryPrice);

    /**
     * @param int|null $cashOnDeliveryVariableSymbol
     */
    public function setCashOnDeliveryVariableSymbol($cashOnDeliveryVariableSymbol);

    /**
     * @param null|string $iban
     */
    public function setIban($iban);

    /**
     * @param null|string $insuranceCurrency
     * @throws WrongDataException
     */
    public function setInsuranceCurrency($insuranceCurrency);

    /**
     * @param int|null $insurancePrice
     */
    public function setInsurancePrice($insurancePrice);

    /**
     * @param null|string $specificSymbol
     */
    public function setSpecificSymbol($specificSymbol);

    /**
     * @param null|string $swift
     */
    public function setSwift($swift);

    /**
     * @return null|string
     */
    public function getBankAccount();

    /**
     * @return null|string
     */
    public function getBankCode();

    /**
     * @return null|string
     */
    public function getCashOnDeliveryCurrency();

    /**
     * @return int|null
     */
    public function getCashOnDeliveryPrice();

    /**
     * @return int|null
     */
    public function getCashOnDeliveryVariableSymbol();

    /**
     * @return null|string
     */
    public function getIban();

    /**
     * @return null|string
     */
    public function getInsuranceCurrency();

    /**
     * @return int|null
     */
    public function getInsurancePrice();

    /**
     * @return null|string
     */
    public function getSpecificSymbol();

    /**
     * @return null|string
     */
    public function getSwift();
}
