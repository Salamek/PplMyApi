<?php
/**
 * Copyright (C) 2016 Adam Schubert <adam.schubert@sg1-game.net>.
 */

namespace Salamek\PplMyApi\Model;


use Salamek\PplMyApi\Enum\Product;
use Salamek\PplMyApi\Exception\WrongDataException;

interface IOrder
{
    /**
     * @param $countPackages
     * @throws WrongDataException
     */
    public function setCountPackages($countPackages);

    /**
     * @param null|string $customerReference
     * @throws WrongDataException
     */
    public function setCustomerReference($customerReference = null);

    /**
     * @param null|string $email
     * @throws WrongDataException
     */
    public function setEmail($email = null);

    /**
     * @param null|string $note
     * @throws WrongDataException
     */
    public function setNote($note = null);

    /**
     * @param $orderReferenceId
     * @throws WrongDataException
     */
    public function setOrderReferenceId($orderReferenceId);

    /**
     * @param $packageProductType
     * @throws WrongDataException
     */
    public function setPackageProductType($packageProductType);

    /**
     * @param \DateTimeInterface $sendDate
     */
    public function setSendDate(\DateTimeInterface $sendDate);

    /**
     * @param \DateTimeInterface|null $sendTimeFrom
     */
    public function setSendTimeFrom(\DateTimeInterface $sendTimeFrom = null);

    /**
     * @param \DateTimeInterface|null $sendTimeTo
     */
    public function setSendTimeTo(\DateTimeInterface $sendTimeTo = null);

    /**
     * @param ISender $sender
     */
    public function setSender(ISender $sender);

    /**
     * @param IRecipient $recipient
     */
    public function setRecipient(IRecipient $recipient);

    /**
     * @return int
     */
    public function getCountPackages();

    /**
     * @return null|string
     */
    public function getCustomerReference();

    /**
     * @return null|string
     */
    public function getEmail();

    /**
     * @return null|string
     */
    public function getNote();

    /**
     * @return string
     */
    public function getOrderReferenceId();

    /**
     * @return int
     */
    public function getPackageProductType();

    /**
     * @return \DateTimeInterface
     */
    public function getSendDate();

    /**
     * @return \DateTimeInterface|null
     */
    public function getSendTimeFrom();

    /**
     * @return \DateTimeInterface|null
     */
    public function getSendTimeTo();

    /**
     * @return ISender
     */
    public function getSender();

    /**
     * @return IRecipient
     */
    public function getRecipient();
}
