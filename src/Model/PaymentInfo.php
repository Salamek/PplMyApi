<?php
/**
 * Copyright (C) 2016 Adam Schubert <adam.schubert@sg1-game.net>.
 */

namespace Salamek\PplMyApi\Model;


use Salamek\PplMyApi\Enum\Currency;
use Salamek\PplMyApi\Exception\WrongDataException;

class PaymentInfo
{
    /** @var null|string */
    private $bankAccount = null;

    /** @var null|string */
    private $bankCode = null;

    /** @var null|string */
    private $cashOnDeliveryCurrency = null;

    /** @var null|integer */
    private $cashOnDeliveryPrice = null;

    /** @var null|integer */
    private $cashOnDeliveryVariableSymbol = null;

    /** @var null|string */
    private $iban = null;

    /** @var null|string */
    private $insuranceCurrency = null;

    /** @var null|integer */
    private $insurancePrice = null;

    /** @var null|string */
    private $specificSymbol = null;

    /** @var null|string */
    private $swift = null;

    /**
     * PaymentInfo constructor.
     * @param int|null $cashOnDeliveryPrice
     * @param null|string $cashOnDeliveryCurrency
     * @param int|null $cashOnDeliveryVariableSymbol
     * @param null|string $insuranceCurrency
     * @param int|null $insurancePrice
     * @param null|string $bankAccount
     * @param null|string $bankCode
     * @param null|string $iban
     * @param null|string $specificSymbol
     * @param null|string $swift
     */
    public function __construct(
        $cashOnDeliveryPrice,
        $cashOnDeliveryCurrency,
        $cashOnDeliveryVariableSymbol,
        $insuranceCurrency = null,
        $insurancePrice = null,
        $bankAccount = null,
        $bankCode = null,
        $iban = null,
        $specificSymbol = null,
        $swift = null
    ) {
        $this->bankAccount = $bankAccount;
        $this->bankCode = $bankCode;
        $this->cashOnDeliveryCurrency = $cashOnDeliveryCurrency;
        $this->cashOnDeliveryPrice = $cashOnDeliveryPrice;
        $this->cashOnDeliveryVariableSymbol = $cashOnDeliveryVariableSymbol;
        $this->iban = $iban;
        $this->insuranceCurrency = $insuranceCurrency;
        $this->insurancePrice = $insurancePrice;
        $this->specificSymbol = $specificSymbol;
        $this->swift = $swift;
    }


    /**
     * @param null|string $bankAccount
     */
    public function setBankAccount($bankAccount)
    {
        $this->bankAccount = $bankAccount;
    }

    /**
     * @param null|string $bankCode
     * @todo add bank code check
     */
    public function setBankCode($bankCode)
    {
        $this->bankCode = $bankCode;
    }

    /**
     * @param null|string $cashOnDeliveryCurrency
     * @throws WrongDataException
     */
    public function setCashOnDeliveryCurrency($cashOnDeliveryCurrency)
    {
        if (!in_array($cashOnDeliveryCurrency, Currency::$list)) {
            throw new WrongDataException(sprintf('Currency Code %s is not supported, use one of %s', $cashOnDeliveryCurrency, implode(', ', Currency::$list)));
        }

        $this->cashOnDeliveryCurrency = $cashOnDeliveryCurrency;
    }

    /**
     * @param int|null $cashOnDeliveryPrice
     */
    public function setCashOnDeliveryPrice($cashOnDeliveryPrice)
    {
        $this->cashOnDeliveryPrice = $cashOnDeliveryPrice;
    }

    /**
     * @param int|null $cashOnDeliveryVariableSymbol
     */
    public function setCashOnDeliveryVariableSymbol($cashOnDeliveryVariableSymbol)
    {
        $this->cashOnDeliveryVariableSymbol = $cashOnDeliveryVariableSymbol;
    }

    /**
     * @param null|string $iban
     */
    public function setIban($iban)
    {
        $this->iban = $iban;
    }

    /**
     * @param null|string $insuranceCurrency
     * @throws WrongDataException
     */
    public function setInsuranceCurrency($insuranceCurrency)
    {
        if (!in_array($insuranceCurrency, Currency::$list)) {
            throw new WrongDataException(sprintf('Currency Code %s is not supported, use one of %s', $insuranceCurrency, implode(', ', Currency::$list)));
        }
        $this->insuranceCurrency = $insuranceCurrency;
    }

    /**
     * @param int|null $insurancePrice
     */
    public function setInsurancePrice($insurancePrice)
    {
        $this->insurancePrice = $insurancePrice;
    }

    /**
     * @param null|string $specificSymbol
     */
    public function setSpecificSymbol($specificSymbol)
    {
        $this->specificSymbol = $specificSymbol;
    }

    /**
     * @param null|string $swift
     */
    public function setSwift($swift)
    {
        $this->swift = $swift;
    }

    /**
     * @return null|string
     */
    public function getBankAccount()
    {
        return $this->bankAccount;
    }

    /**
     * @return null|string
     */
    public function getBankCode()
    {
        return $this->bankCode;
    }

    /**
     * @return null|string
     */
    public function getCashOnDeliveryCurrency()
    {
        return $this->cashOnDeliveryCurrency;
    }

    /**
     * @return int|null
     */
    public function getCashOnDeliveryPrice()
    {
        return $this->cashOnDeliveryPrice;
    }

    /**
     * @return int|null
     */
    public function getCashOnDeliveryVariableSymbol()
    {
        return $this->cashOnDeliveryVariableSymbol;
    }

    /**
     * @return null|string
     */
    public function getIban()
    {
        return $this->iban;
    }

    /**
     * @return null|string
     */
    public function getInsuranceCurrency()
    {
        return $this->insuranceCurrency;
    }

    /**
     * @return int|null
     */
    public function getInsurancePrice()
    {
        return $this->insurancePrice;
    }

    /**
     * @return null|string
     */
    public function getSpecificSymbol()
    {
        return $this->specificSymbol;
    }

    /**
     * @return null|string
     */
    public function getSwift()
    {
        return $this->swift;
    }


}