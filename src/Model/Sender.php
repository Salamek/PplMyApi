<?php
/**
 * Copyright (C) 2016 Adam Schubert <adam.schubert@sg1-game.net>.
 */

namespace Salamek\PplMyApi\Model;

use Salamek\PplMyApi\Enum\Country;
use Salamek\PplMyApi\Exception\WrongDataException;

/**
 * Class Sender
 * @package Salamek\MyApi
 */
class Sender
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

    /**
     * Sender constructor.
     * @param $city
     * @param $name
     * @param $street
     * @param $zipCode
     * @param null $email
     * @param null $phone
     * @param null $contact
     * @param null $country
     * @param null $name2
     */
    public function __construct($city, $name, $street, $zipCode, $email = null, $phone = null, $contact = null, $country = null, $name2 = null)
    {
        $this->setCity($city);
        $this->setName($name);
        $this->setStreet($street);
        $this->setZipCode($zipCode);
        $this->setEmail($email);
        $this->setPhone($phone);
        $this->setContact($contact);
        $this->setCountry($country);
        $this->setName2($name2);
    }

    /**
     * @param $city string
     * @throws WrongDataException
     */
    public function setCity($city)
    {
        if (strlen($city) > 50) {
            throw new WrongDataException('$city is longer then 50 characters');
        }
        $this->city = $city;
    }

    /**
     * @param $contact string
     * @throws WrongDataException
     */
    public function setContact($contact)
    {
        if (!is_null($contact)) {
            if (strlen($contact) > 30) {
                throw new WrongDataException('$contact is longer then 30 characters');
            }
        }

        $this->contact = $contact;
    }

    /**
     * @param $country string
     * @throws WrongDataException
     */
    public function setCountry($country)
    {
        if (!in_array($country, Country::$list)) {
            throw new WrongDataException(sprintf('Country Code %s is not supported, use one of %s', $country, implode(', ', Country::$list)));
        }
        $this->country = $country;
    }

    /**
     * @param $email string
     * @throws WrongDataException
     */
    public function setEmail($email)
    {
        if (!is_null($email)) {
            if (strlen($email) > 100) {
                throw new WrongDataException('$email is longer then 100 characters');
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                throw new WrongDataException('$email have invalid value');
            }
        }


        $this->email = $email;
    }

    /**
     * @param $name string
     * @throws WrongDataException
     */
    public function setName($name)
    {
        if (strlen($name) > 250) {
            throw new WrongDataException('$name is longer then 250 characters');
        }
        $this->name = $name;
    }

    /**
     * @param $name2 string
     * @throws WrongDataException
     */
    public function setName2($name2)
    {
        if (!is_null($name2)) {
            if (strlen($name2) > 250) {
                throw new WrongDataException('$name2 is longer then 250 characters');
            }
        }

        $this->name2 = $name2;
    }

    /**
     * @param $phone string
     * @throws WrongDataException
     */
    public function setPhone($phone)
    {
        if (!is_null($phone)) {
            if (strlen($phone) > 30) {
                throw new WrongDataException('$phone is longer then 30 characters');
            }
        }

        $this->phone = $phone;
    }

    /**
     * @param $street string
     * @throws WrongDataException
     */
    public function setStreet($street)
    {
        if (strlen($street) > 30) {
            throw new WrongDataException('$street is longer then 30 characters');
        }
        $this->street = $street;
    }

    /**
     * @param $zipCode string
     * @throws WrongDataException
     */
    public function setZipCode($zipCode)
    {
        if (strlen($zipCode) > 10) {
            throw new WrongDataException('$zipCode is longer then 10 characters');
        }
        $this->zipCode = $zipCode;
    }

    /**
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @return null|string
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * @return null|string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * @return null|string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return null|string
     */
    public function getName2()
    {
        return $this->name2;
    }

    /**
     * @return null|string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @return string
     */
    public function getStreet()
    {
        return $this->street;
    }

    /**
     * @return string
     */
    public function getZipCode()
    {
        return $this->zipCode;
    }
}