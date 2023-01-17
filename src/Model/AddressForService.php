<?php

namespace Salamek\PplMyApi\Model;

use Salamek\PplMyApi\Enum\Country;
use Salamek\PplMyApi\Exception\WrongDataException;
use Salamek\PplMyApi\Validators\MaxLengthValidator;
use Salamek\PplMyApi\Enum\AddressForService as AddressForServiceEnum;

class AddressForService implements IAddressForService
{
    /** @var string */
    private $city;

    /** @var null|string */
    private $contact = null;

    /** @var null|string */
    private $country = null;

    /** @var null|string */
    private $email = null;

    /** @var string */
    private $name;

    /** @var null|string */
    private $name2 = null;

    /** @var null|string */
    private $phone = null;

    /** @var string */
    private $street;

    /** @var string */
    private $zipCode;

    /** @var IFlag[] */
    private $flags;

    /** @var string */
    private $serviceAddressType;

    /**
     * @param iFlag[] $flags
     * @throws WrongDataException
     */
    public function __construct(
        string $serviceAddressType,
        string $city,
        string $name,
        string $street,
        string $zipCode,
        string $email = null,
        string $phone = null,
        string $contact = null,
        string $country = Country::CZ,
        string $name2 = null,
        array $flags = []
    ) {
        $this->setServiceAddressType($serviceAddressType);
        $this->setCity($city);
        $this->setName($name);
        $this->setStreet($street);
        $this->setZipCode($zipCode);
        $this->setEmail($email);
        $this->setPhone($phone);
        $this->setContact($contact);
        $this->setCountry($country);
        $this->setName2($name2);
        $this->setFlags($flags);
    }

    /**
     * @inheritdoc
     */
    public function setServiceAddressType(string $serviceAddressType)
    {
        if (!in_array($serviceAddressType, AddressForServiceEnum::$list)) {
            throw new WrongDataException(
                sprintf('$packageProductType has wrong value, only %s are allowed', implode(', ', AddressForServiceEnum::$list))
            );
        }
        $this->serviceAddressType = $serviceAddressType;
    }

    public function setCity(string $city)
    {
        MaxLengthValidator::validate($city, 50);
        $this->city = $city;
    }

    /**
     * @inheritdoc
     */
    public function setContact($contact)
    {
        if (!is_null($contact)) {
            MaxLengthValidator::validate($contact, 30);
        }

        $this->contact = $contact;
    }

    /**
     * @inheritdoc
     */
    public function setCountry($country)
    {
        if (!in_array($country, Country::$list)) {
            throw new WrongDataException(sprintf('Country Code %s is not supported, use one of %s', $country, implode(', ', Country::$list)));
        }
        $this->country = $country;
    }

    /**
     * @inheritdoc
     */
    public function setEmail($email)
    {
        if (!is_null($email)) {
            MaxLengthValidator::validate($email, 100);

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new WrongDataException('$email have invalid value');
            }
        }


        $this->email = $email;
    }

    /**
     * @inheritdoc
     */
    public function setName($name)
    {
        MaxLengthValidator::validate($name, 250);
        $this->name = $name;
    }

    /**
     * @inheritdoc
     */
    public function setName2($name2)
    {
        if (!is_null($name2)) {
            MaxLengthValidator::validate($name2, 250);
        }

        $this->name2 = $name2;
    }

    /**
     * @inheritdoc
     */
    public function setPhone($phone)
    {
        if (!is_null($phone)) {
            MaxLengthValidator::validate($phone, 30);
        }

        $this->phone = $phone;
    }

    /**
     * @inheritdoc
     */
    public function setStreet($street)
    {
        MaxLengthValidator::validate($street, 30);
        $this->street = $street;
    }

    /**
     * @inheritdoc
     */
    public function setZipCode($zipCode)
    {
        MaxLengthValidator::validate($zipCode, 10);
        $this->zipCode = $zipCode;
    }

    /**
     * @param IFlag[] $flags
     */
    public function setFlags($flags)
    {
        $this->flags = $flags;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function getContact(): ?string
    {
        return $this->contact;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getName2(): ?string
    {
        return $this->name2;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function getStreet(): string
    {
        return $this->street;
    }

    public function getZipCode(): string
    {
        return $this->zipCode;
    }

    public function getFlags(): array
    {
        return $this->flags;
    }

    public function getServiceAddressType(): string
    {
        return $this->serviceAddressType;
    }
}