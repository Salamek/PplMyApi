<?php
/**
 * Copyright (C) 2016 Adam Schubert <adam.schubert@sg1-game.net>.
 */

namespace Salamek\PplMyApi\Model;


use Salamek\PplMyApi\Enum\Currency;
use Salamek\PplMyApi\Exception\WrongDataException;

class PaymentInfo implements IPaymentInfo
{
    /** @var null|string */
    private $bankAccount = null;

    /** @var null|string */
    private $bankCode = null;

    /** @var null|string */
    private $cashOnDeliveryCurrency = null;

    /** @var null|float */
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
     * @param float $cashOnDeliveryPrice
     * @param string $cashOnDeliveryCurrency
     * @param int $cashOnDeliveryVariableSymbol
     * @param null|string $insuranceCurrency
     * @param int|null $insurancePrice
     * @param null|string $bankAccount
     * @param null|string $bankCode
     * @param null|string $iban
     * @param null|string $specificSymbol
     * @param null|string $swift
     */
    public function __construct(
        float $cashOnDeliveryPrice,
        string $cashOnDeliveryCurrency,
        int $cashOnDeliveryVariableSymbol,
        string $insuranceCurrency = null,
        int $insurancePrice = null,
        string $bankAccount = null,
        string $bankCode = null,
        string $iban = null,
        string $specificSymbol = null,
        string $swift = null
    ) {
        $this->setBankAccount($bankAccount);
        $this->setBankCode($bankCode);
        $this->setCashOnDeliveryCurrency($cashOnDeliveryCurrency);
        $this->setCashOnDeliveryPrice($cashOnDeliveryPrice);
        $this->setCashOnDeliveryVariableSymbol($cashOnDeliveryVariableSymbol);
        $this->setIban($iban);
        $this->setInsuranceCurrency($insuranceCurrency);
        $this->setInsurancePrice($insurancePrice);
        $this->setSpecificSymbol($specificSymbol);
        $this->setSwift($swift);
    }


    /**
     * @param string|null $bankAccount
     */
    public function setBankAccount(string $bankAccount = null): void
    {
        $this->bankAccount = $bankAccount;
    }

    /**
     * @param string|null $bankCode
     * @todo add bank code check
     */
    public function setBankCode(string $bankCode = null): void
    {
        $this->bankCode = $bankCode;
    }

    /**
     * @param string $cashOnDeliveryCurrency
     * @throws WrongDataException
     */
    public function setCashOnDeliveryCurrency(string $cashOnDeliveryCurrency): void
    {
        if (!in_array($cashOnDeliveryCurrency, Currency::$list)) {
            throw new WrongDataException(sprintf('Currency Code %s is not supported, use one of %s', $cashOnDeliveryCurrency, implode(', ', Currency::$list)));
        }

        $this->cashOnDeliveryCurrency = $cashOnDeliveryCurrency;
    }

    /**
     * @param float $cashOnDeliveryPrice
     */
    public function setCashOnDeliveryPrice(float $cashOnDeliveryPrice): void
    {
        $this->cashOnDeliveryPrice = $cashOnDeliveryPrice;
    }

    /**
     * @param int $cashOnDeliveryVariableSymbol
     */
    public function setCashOnDeliveryVariableSymbol(int $cashOnDeliveryVariableSymbol): void
    {
        $this->cashOnDeliveryVariableSymbol = $cashOnDeliveryVariableSymbol;
    }

    /**
     * @param null|string $iban
     */
    public function setIban(string $iban = null): void
    {
        $this->iban = $iban;
    }

    /**
     * @param null|string $insuranceCurrency
     * @throws WrongDataException
     */
    public function setInsuranceCurrency(string $insuranceCurrency = null): void
    {
        if (!is_null($insuranceCurrency) && !in_array($insuranceCurrency, Currency::$list)) {
            throw new WrongDataException(sprintf('Currency Code %s is not supported, use one of %s', $insuranceCurrency, implode(', ', Currency::$list)));
        }
        $this->insuranceCurrency = $insuranceCurrency;
    }

    /**
     * @param int|null $insurancePrice
     */
    public function setInsurancePrice(int $insurancePrice = null): void
    {
        $this->insurancePrice = $insurancePrice;
    }

    /**
     * @param null|string $specificSymbol
     */
    public function setSpecificSymbol(string $specificSymbol = null): void
    {
        $this->specificSymbol = $specificSymbol;
    }

    /**
     * @param null|string $swift
     */
    public function setSwift(string $swift = null): void
    {
        $this->swift = $swift;
    }

    /**
     * @return null|string
     */
    public function getBankAccount(): ?string
    {
        return $this->bankAccount;
    }

    /**
     * @return null|string
     */
    public function getBankCode(): ?string
    {
        return $this->bankCode;
    }

    /**
     * @return string
     */
    public function getCashOnDeliveryCurrency(): string
    {
        return $this->cashOnDeliveryCurrency;
    }

    /**
     * @return float
     */
    public function getCashOnDeliveryPrice(): float
    {
        return $this->cashOnDeliveryPrice;
    }

    /**
     * @return int
     */
    public function getCashOnDeliveryVariableSymbol(): int
    {
        return $this->cashOnDeliveryVariableSymbol;
    }

    /**
     * @return null|string
     */
    public function getIban(): ?string
    {
        return $this->iban;
    }

    /**
     * @return null|string
     */
    public function getInsuranceCurrency(): ?string
    {
        return $this->insuranceCurrency;
    }

    /**
     * @return int|null
     */
    public function getInsurancePrice(): ?int
    {
        return $this->insurancePrice;
    }

    /**
     * @return null|string
     */
    public function getSpecificSymbol(): ?string
    {
        return $this->specificSymbol;
    }

    /**
     * @return null|string
     */
    public function getSwift(): ?string
    {
        return $this->swift;
    }
}
