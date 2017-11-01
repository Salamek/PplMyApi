<?php
/**
 * Copyright (C) 2016 Adam Schubert <adam.schubert@sg1-game.net>.
 */

namespace Salamek\PplMyApi\Model;


use Salamek\PplMyApi\Exception\WrongDataException;

interface IPickUpOrder
{

    /**
     * @param string $orderReferenceId
     * @throws WrongDataException
     */
    public function setOrderReferenceId($orderReferenceId);

    /**
     * @param null|string $customerReference
     * @throws WrongDataException
     */
    public function setCustomerReference($customerReference);

    /**
     * @param int $countPackages
     */
    public function setCountPackages($countPackages);

    /**
     * @param null|string $note
     * @throws WrongDataException
     */
    public function setNote($note);

    /**
     * @param null|string $email
     * @throws WrongDataException
     */
    public function setEmail($email);

    /**
     * @param \DateTimeInterface $sendDate
     */
    public function setSendDate(\DateTimeInterface $sendDate);

    /**
     * @param \DateTimeInterface|null $sendTimeFrom
     */
    public function setSendTimeFrom(\DateTimeInterface $sendTimeFrom);

    /**
     * @param \DateTimeInterface|null $sendTimeTo
     */
    public function setSendTimeTo(\DateTimeInterface $sendTimeTo);

    /**
     * @param ISender $sender
     */
    public function setSender(ISender $sender);

    /**
     * @return string
     */
    public function getOrderReferenceId();

    /**
     * @return null|string
     */
    public function getCustomerReference();

    /**
     * @return int
     */
    public function getCountPackages();

    /**
     * @return null|string
     */
    public function getNote();

    /**
     * @return null|string
     */
    public function getEmail();

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
}
