<?php

namespace Salamek\PplMyApi\Model;

use Salamek\PplMyApi\Exception\WrongDataException;

/**
 * Interface ISender
 * @package Salamek\MyApi
 */
interface ISender
{
    /**
     * @param $city string
     * @throws WrongDataException
     */
    public function setCity($city);

    /**
     * @param $contact string
     * @throws WrongDataException
     */
    public function setContact($contact);

    /**
     * @param $country string
     * @throws WrongDataException
     */
    public function setCountry($country);

    /**
     * @param $email string
     * @throws WrongDataException
     */
    public function setEmail($email);

    /**
     * @param $name string
     * @throws WrongDataException
     */
    public function setName($name);

    /**
     * @param $name2 string
     * @throws WrongDataException
     */
    public function setName2($name2);

    /**
     * @param $phone string
     * @throws WrongDataException
     */
    public function setPhone($phone);

    /**
     * @param $street string
     * @throws WrongDataException
     */
    public function setStreet($street);

    /**
     * @param $zipCode string
     * @throws WrongDataException
     */
    public function setZipCode($zipCode);

    /**
     * @return null|string
     */
    public function getCity();

    /**
     * @return null|string
     */
    public function getContact();

    /**
     * @return null|string
     */
    public function getCountry();

    /**
     * @return null|string
     */
    public function getEmail();

    /**
     * @return null|string
     */
    public function getName();

    /**
     * @return null|string
     */
    public function getName2();

    /**
     * @return null|string
     */
    public function getPhone();

    /**
     * @return null|string
     */
    public function getStreet();

    /**
     * @return null|string
     */
    public function getZipCode();
}
