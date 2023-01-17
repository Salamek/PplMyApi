<?php

namespace Salamek\PplMyApi\Model;

use Salamek\PplMyApi\Exception\WrongDataException;

/**
 * Interface ISender
 * @package Salamek\MyApi
 */
interface IAddressForService
{
    /**
     * @throws WrongDataException
     */
    public function setCity(string $city);

    /**
     * @throws WrongDataException
     */
    public function setContact(string $contact);

    /**
     * @throws WrongDataException
     */
    public function setCountry(string $country);

    /**
     * @throws WrongDataException
     */
    public function setEmail(string $email);

    /**
     * @throws WrongDataException
     */
    public function setName(string $name);

    /**
     * @throws WrongDataException
     */
    public function setName2(string $name2);

    /**
     * @throws WrongDataException
     */
    public function setPhone(string $phone);

    /**
     * @throws WrongDataException
     */
    public function setStreet(string $street);

    /**
     * @throws WrongDataException
     */
    public function setZipCode(string $zipCode);

    /**
     * @param IFlag[] $flags
     */
    public function setFlags(array $flags);

    /**
     * @throws WrongDataException
     */
    public function setServiceAddressType(string $serviceAddressType);

    public function getCity(): ?string;

    public function getContact(): ?string;

    public function getCountry(): ?string;

    public function getEmail(): ?string;

    public function getName(): ?string;

    public function getName2(): ?string;

    public function getPhone(): ?string;

    public function getStreet(): ?string;

    public function getZipCode(): ?string;

    public function getFlags(): array;

    public function getServiceAddressType(): string;
}
