<?php
/**
 * Copyright (C) 2016 Adam Schubert <adam.schubert@sg1-game.net>.
 */

namespace Salamek\PplMyApi\Model;


use Salamek\PplMyApi\Exception\WrongDataException;
use Salamek\PplMyApi\Validators\MaxLengthValidator;

class PickUpOrder implements IPickUpOrder
{
    /** @var string */
    private $orderReferenceId;

    /** @var null|string */
    private $customerReference = null;

    /** @var integer */
    private $countPackages;

    /** @var null|string */
    private $note = null;

    /** @var null|string */
    private $email = null;

    /** @var \DateTimeInterface */
    private $sendDate;

    /** @var null|\DateTimeInterface */
    private $sendTimeFrom = null;

    /** @var null|\DateTimeInterface */
    private $sendTimeTo = null;

    /** @var ISender */
    private $sender;

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
     * @param ISender $sender
     */
    public function __construct($orderReferenceId, $customerReference, $countPackages, $note, $email, \DateTimeInterface $sendDate, \DateTimeInterface $sendTimeFrom, \DateTimeInterface $sendTimeTo, ISender $sender)
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
        MaxLengthValidator::validate($orderReferenceId, 100);
        $this->orderReferenceId = $orderReferenceId;
    }

    /**
     * @param null|string $customerReference
     * @throws WrongDataException
     */
    public function setCustomerReference($customerReference)
    {
        MaxLengthValidator::validate($customerReference, 40);
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
        MaxLengthValidator::validate($note, 300);
        $this->note = $note;
    }

    /**
     * @param null|string $email
     * @throws WrongDataException
     */
    public function setEmail($email)
    {
        MaxLengthValidator::validate($email, 100);

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
     * @param ISender $sender
     */
    public function setSender(ISender $sender)
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
     * @return ISender
     */
    public function getSender()
    {
        return $this->sender;
    }
}
