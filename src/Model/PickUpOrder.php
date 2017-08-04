<?php
/**
 * Copyright (C) 2016 Adam Schubert <adam.schubert@sg1-game.net>.
 */

namespace Salamek\PplMyApi\Model;


use Salamek\PplMyApi\Exception\WrongDataException;

class PickUpOrder
{
    /** @var string */
    protected $orderReferenceId;

    /** @var null|string */
    protected $customerReference = null;

    /** @var integer */
    protected $countPackages;

    /** @var null|string */
    protected $note = null;

    /** @var null|string */
    protected $email = null;

    /** @var \DateTimeInterface */
    protected $sendDate;

    /** @var null|\DateTimeInterface */
    protected $sendTimeFrom = null;

    /** @var null|\DateTimeInterface */
    protected $sendTimeTo = null;

    /** @var Sender */
    protected $sender;

    /**
     * PickUpOrder constructor.
     * @param string $orderReferenceId
     * @param null|string $customerReference
     * @param int $countPackages
     * @param null|string $note
     * @param null|string $email
     * @param \DateTimeInterface $sendDate
     * @param \DateTimeInterface|null $sendTimeFrom
     * @param \DateTimeInterface|null $sendTimeTo
     * @param Sender $sender
     */
    public function __construct($orderReferenceId, $customerReference, $countPackages, $note, $email, \DateTimeInterface $sendDate, $sendTimeFrom, $sendTimeTo, Sender $sender)
    {
        $this->setOrderReferenceId($orderReferenceId);
        $this->setCustomerReference($customerReference);
        $this->setCountPackages($countPackages);
        $this->setNote($note);
        $this->setEmail($email);
        $this->setSendDate($sendDate);
        $this->setSendTimeFrom($sendTimeFrom);
        $this->setSendTimeTo($sendTimeTo);
        $this->setSender($sender);
    }


    /**
     * @param string $orderReferenceId
     * @throws WrongDataException
     */
    public function setOrderReferenceId($orderReferenceId)
    {
        if (mb_strlen($orderReferenceId) > 100) {
            throw new WrongDataException('$orderReferenceId is longer than 100 characters');
        }

        $this->orderReferenceId = $orderReferenceId;
    }

    /**
     * @param null|string $customerReference
     * @throws WrongDataException
     */
    public function setCustomerReference($customerReference)
    {
        if (mb_strlen($customerReference) > 40) {
            throw new WrongDataException('$customerReference is longer than 40 characters');
        }

        $this->customerReference = $customerReference;
    }

    /**
     * @param int $countPackages
     */
    public function setCountPackages($countPackages)
    {
        $this->countPackages = $countPackages;
    }

    /**
     * @param null|string $note
     * @throws WrongDataException
     */
    public function setNote($note)
    {
        if (mb_strlen($note) > 300) {
            throw new WrongDataException('$note is longer than 300 characters');
        }

        $this->note = $note;
    }

    /**
     * @param null|string $email
     * @throws WrongDataException
     */
    public function setEmail($email)
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
     * @param \DateTimeInterface $sendDate
     */
    public function setSendDate(\DateTimeInterface $sendDate)
    {
        $this->sendDate = $sendDate;
    }

    /**
     * @param \DateTimeInterface|null $sendTimeFrom
     */
    public function setSendTimeFrom(\DateTimeInterface $sendTimeFrom)
    {
        $this->sendTimeFrom = $sendTimeFrom;
    }

    /**
     * @param \DateTimeInterface|null $sendTimeTo
     */
    public function setSendTimeTo(\DateTimeInterface $sendTimeTo)
    {
        $this->sendTimeTo = $sendTimeTo;
    }

    /**
     * @param Sender $sender
     */
    public function setSender(Sender $sender)
    {
        $this->sender = $sender;
    }

    /**
     * @return string
     */
    public function getOrderReferenceId()
    {
        return $this->orderReferenceId;
    }

    /**
     * @return null|string
     */
    public function getCustomerReference()
    {
        return $this->customerReference;
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
    public function getNote()
    {
        return $this->note;
    }

    /**
     * @return null|string
     */
    public function getEmail()
    {
        return $this->email;
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
     * @return Sender
     */
    public function getSender()
    {
        return $this->sender;
    }
}
