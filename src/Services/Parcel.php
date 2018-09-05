<?php

namespace Sf4\OmnivaBundle\Services;

use ArrayIterator;

/**
 * Class Parcel
 * @package Sf4\OmnivaBundle\Services
 */
class Parcel
{
    /**
     * weight in kilograms
     * @var float $weight
     */
    private $weight;

    /**
     * @var ArrayIterator $services
     */
    private $services;

    /**
     * amount in euros
     * @var float $codAmount
     */
    private $codAmount;

    /**
     * bank account number (IBAN)
     * @var string $bankAccount
     */
    private $bankAccount;

    /**
     * @var string $comment
     */
    private $comment;

    /**
     * @var string $partnerId
     */
    private $partnerId;

    /**
     * @var Address $receiver
     */
    private $receiver;

    /**
     * @var Address $returnee
     */
    private $returnee;

    /**
     * @var Address $sender
     */
    private $sender;

    /**
     * @var string $trackingNumber
     */
    private $trackingNumber;

    /**
     * Parcel constructor.
     */
    public function __construct()
    {
        $this->services = new ArrayIterator();
    }

    /**
     * @return float|null
     */
    public function getWeight(): ?float
    {
        return $this->weight;
    }

    /**
     * in grams
     * @param float $weight
     * @return Parcel
     */
    public function setWeight(float $weight)
    {
        $this->weight = $weight;
        return $this;
    }

    /**
     * @return bool
     */
    public function hasComment(): bool
    {
        return !is_null($this->comment);
    }

    /**
     * @return string|null
     */
    public function getComment(): ?string
    {
        return $this->comment;
    }

    /**
     * @param string $comment
     * @return Parcel
     */
    public function setComment(string $comment): self
    {
        $this->comment = $comment;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getPartnerId(): ?string
    {
        return $this->partnerId;
    }

    /**
     * @param string $partnerId
     * @return Parcel
     */
    public function setPartnerId(string $partnerId): self
    {
        $this->partnerId = $partnerId;
        return $this;
    }

    /**
     * @return float|null
     */
    public function getCodAmount(): ?float
    {
        return $this->codAmount;
    }

    /**
     * @param float $amount
     * @return Parcel
     */
    public function setCodAmount(float $amount): self
    {
        $this->codAmount = $amount;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getBankAccount(): ?string
    {
        return $this->bankAccount;
    }

    /**
     * @param string $number
     * @return Parcel
     */
    public function setBankAccount(string $number): self
    {
        $this->bankAccount = $number;
        return $this;
    }

    /**
     * @return bool
     */
    public function hasServices(): bool
    {
        return $this->services->count() > 0;
    }

    /**
     * @param Service $service
     * @return Parcel
     */
    public function addService(Service $service): self
    {
        $this->services->append($service);
        return $this;
    }

    /**
     * @return ArrayIterator
     */
    public function getServices(): ArrayIterator
    {
        return $this->services;
    }

    /**
     * @return Address|null
     */
    public function getSender(): ?Address
    {
        return $this->sender;
    }

    /**
     * @param Address $sender
     * @return Parcel
     */
    public function setSender(Address $sender): self
    {
        $this->sender = $sender;
        return $this;
    }

    /**
     * @return Address|null
     */
    public function getReceiver(): ?Address
    {
        return $this->receiver;
    }

    /**
     * @param Address $receiver
     * @return Parcel
     */
    public function setReceiver(Address $receiver): self
    {
        $this->receiver = $receiver;
        return $this;
    }

    /**
     * @return Address|null
     */
    public function getReturnee(): ?Address
    {
        return $this->returnee;
    }

    /**
     * @param Address $returnee
     * @return Parcel
     */
    public function setReturnee(Address $returnee): self
    {
        $this->returnee = $returnee;
        return $this;
    }

    /**
     * @return bool
     */
    public function hasTrackingNumber(): bool
    {
        return !is_null($this->trackingNumber);
    }

    /**
     * @return string|null
     */
    public function getTrackingNumber(): ?string
    {
        return $this->trackingNumber;
    }

    /**
     * @param string $number
     * @return Parcel
     */
    public function setTrackingNumber(string $number): self
    {
        $this->trackingNumber = $number;
        return $this;
    }
}