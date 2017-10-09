<?php
/**
 * Copyright (C) 2016 Adam Schubert <adam.schubert@sg1-game.net>.
 */

namespace Salamek\PplMyApi\Model;


use Salamek\PplMyApi\Enum\Product;
use Salamek\PplMyApi\Exception\WrongDataException;

class Order
{
    /** @var integer */
    private $countPackages;

    /** @var null|string */
    private $customerReference = null;

    /** @var null|string */
    private $email = null;

    /** @var null|string */
    private $note = null;

    /** @var string */
    private $orderReferenceId;

    /** @var integer */
    private $packageProductType;

    /** @var  \DateTimeInterface */
    private $sendDate;

    /** @var  null|\DateTimeInterface */
    private $sendTimeFrom = null;

    /** @var null|\DateTimeInterface */
    private $sendTimeTo = null;

    /** @var ISender */
    private $sender;

    /** @var Recipient */
    private $recipient;

    /**
     * OrderIn constructor.
     * @param $countPack
     * @param $orderReferenceId
     * @param $packProductType
     * @param \DateTimeInterface $sendDate
     * @param ISender $sender
     * @param Recipient $recipient
     * @param null $customerReference
     * @param null $email
     * @param null $note
     * @param \DateTimeInterface|null $sendTimeFrom
     * @param \DateTimeInterface|null $sendTimeTo
     */
    public function __construct(
        $countPack,
        $orderReferenceId,
        $packProductType,
        \DateTimeInterface $sendDate,
        ISender $sender,
        Recipient $recipient,
        $customerReference = null,
        $email = null,
        $note = null,
        \DateTimeInterface $sendTimeFrom = null,
        \DateTimeInterface $sendTimeTo = null
    ) {
        $this->setCountPackages($countPack);
        $this->setOrderReferenceId($orderReferenceId);
        $this->setPackageProductType($packProductType);
        $this->setSendDate($sendDate);
        $this->setSender($sender);
        $this->setRecipient($recipient);
        $this->setCustomerReference($customerReference);
        $this->setEmail($email);
        $this->setNote($note);
        $this->setSendTimeFrom($sendTimeFrom);
        $this->setSendTimeTo($sendTimeTo);
    }

    /**
     * @param $countPackages
     * @throws WrongDataException
     */
    public function setCountPackages($countPackages)
    {
        if ($countPackages < 1) {
            throw new WrongDataException('$countPack must be bigger than 0');
        }

        $this->countPackages = $countPackages;
    }

    /**
     * @param null|string $customerReference
     * @throws WrongDataException
     */
    public function setCustomerReference($customerReference = null)
    {
        if (mb_strlen($customerReference) > 40) {
            throw new WrongDataException('$customerReference is longer than 40 characters');
        }

        $this->customerReference = $customerReference;
    }

    /**
     * @param null|string $email
     * @throws WrongDataException
     */
    public function setEmail($email = null)
    {
        if (mb_strlen($email) > 100) {
            throw new WrongDataException('$email is longer than 100 characters');
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new WrongDataException('$email have invalid value');
        }

        $this->email = $email;
    }

    /**
     * @param null|string $note
     * @throws WrongDataException
     */
    public function setNote($note = null)
    {
        if (mb_strlen($note) > 100) {
            throw new WrongDataException('$note is longer than 300 characters');
        }

        $this->note = $note;
    }

    /**
     * @param $orderReferenceId
     * @throws WrongDataException
     */
    public function setOrderReferenceId($orderReferenceId)
    {
        if (mb_strlen($orderReferenceId) > 100) {
            throw new WrongDataException('$orderReferenceId is longer than 300 characters');
        }

        $this->orderReferenceId = $orderReferenceId;
    }

    /**
     * @param $packageProductType
     * @throws WrongDataException
     */
    public function setPackageProductType($packageProductType)
    {
        if (!in_array($packageProductType, Product::$list)) {
            throw new WrongDataException(sprintf('$packProductType has wrong value, only %s are allowed', implode(', ', Product::$list)));
        }
        $this->packageProductType = $packageProductType;
    }

    /**
     * @param \DateTimeInterface $sendDate
     */
    public function setSendDate(\DateTimeInterface $sendDate)
    {
        $this->sendDate = $sendDate;
    }

    /**
     * @param \DateTimeInterface|null $sendTimeFrom
     */
    public function setSendTimeFrom(\DateTimeInterface $sendTimeFrom = null)
    {
        $this->sendTimeFrom = $sendTimeFrom;
    }

    /**
     * @param \DateTimeInterface|null $sendTimeTo
     */
    public function setSendTimeTo(\DateTimeInterface $sendTimeTo = null)
    {
        $this->sendTimeTo = $sendTimeTo;
    }

    /**
     * @param ISender $sender
     */
    public function setSender(ISender $sender)
    {
        $this->sender = $sender;
    }

    /**
     * @param Recipient $recipient
     */
    public function setRecipient(Recipient $recipient)
    {
        $this->recipient = $recipient;
    }

    /**
     * @return int
     */
    public function getCountPackages()
    {
        return $this->countPackages;
    }

    /**
     * @return null|string
     */
    public function getCustomerReference()
    {
        return $this->customerReference;
    }

    /**
     * @return null|string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return null|string
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * @return string
     */
    public function getOrderReferenceId()
    {
        return $this->orderReferenceId;
    }

    /**
     * @return int
     */
    public function getPackageProductType()
    {
        return $this->packageProductType;
    }

    /**
     * @return \DateTimeInterface
     */
    public function getSendDate()
    {
        return $this->sendDate;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getSendTimeFrom()
    {
        return $this->sendTimeFrom;
    }

    /**
     * @return \DateTimeInterface|null
     */
    public function getSendTimeTo()
    {
        return $this->sendTimeTo;
    }

    /**
     * @return ISender
     */
    public function getSender()
    {
        return $this->sender;
    }

    /**
     * @return Recipient
     */
    public function getRecipient()
    {
        return $this->recipient;
    }
}
