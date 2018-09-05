<?php

namespace Sf4\OmnivaBundle\Services;


/**
 * Class Address
 * @package Sf4\OmnivaBundle\Services
 */
class Address
{
    /**
     * name & surname
     * @var string $name
     */
    private $name;

    /**
     * @var string $phone
     */
    private $phone;

    /**
     * @var string $email
     */
    private $email;

    /**
     * country code (ISO code 2 letters)
     * @var string $country
     */
    private $country;

    /**
     * @var string $terminal
     */
    private $terminal;

    /**
     * @var string $city
     */
    private $city;

    /**
     * @var string $street
     */
    private $street;

    /**
     * @var string $postcode
     */
    private $postcode;

    /**
     * @var PickupPoint $pickupPoint
     */
    private $pickupPoint;

    /**
     * Get name
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set name
     * @param string $name
     * @return Address
     */
    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get phone
     * @return null|string
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }

    /**
     * Set phone
     * @param null|string $phone
     * @return Address
     */
    public function setPhone(?string $phone): self
    {
        $this->phone = $phone;
        return $this;
    }

    /**
     * Get email
     * @return string|null
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * Set email
     * @param string $email
     * @return Address
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;
        return $this;
    }

    /**
     * Has email
     * @return bool
     */
    public function hasEmail(): bool
    {
        return is_string($this->email);
    }

    /**
     * Set country code
     * @param string $code
     * @return Address
     */
    public function setCountryCode(string $code): self
    {
        $this->country = $code;
        return $this;
    }

    /**
     * Get country code
     * @return string|null
     */
    public function getCountryCode(): ?string
    {
        return $this->country;
    }

    /**
     * Has terminal
     * @return bool
     */
    public function hasTerminal(): bool
    {
        trigger_error('This method will removed 1.0. Use hasPickupPoint() instead.', E_USER_DEPRECATED);
        return is_string($this->terminal);
    }

    /**
     * Get terminal
     * @return null|string
     */
    public function getTerminal(): ?string
    {
        trigger_error('This method will removed 1.0. Use getPickupPoint() instead.', E_USER_DEPRECATED);
        return $this->terminal;
    }

    /**
     * Set terminal
     * @param string $terminal
     * @return Address
     */
    public function setTerminal(string $terminal): self
    {
        trigger_error('This method will removed 1.0. Use setPickupPoint() instead.', E_USER_DEPRECATED);
        $this->terminal = $terminal;
        return $this;
    }

    /**
     * Get city
     * @return string|null
     */
    public function getCity(): ?string
    {
        return $this->city;
    }

    /**
     * Set city
     * @param string $city
     * @return Address
     */
    public function setCity(string $city): self
    {
        $this->city = $city;
        return $this;
    }

    /**
     * Get street
     * @return string|null
     */
    public function getStreet(): ?string
    {
        return $this->street;
    }

    /**
     * Set street
     * @param string $street
     * @return Address
     */
    public function setStreet(string $street): self
    {
        $this->street = $street;
        return $this;
    }

    /**
     * Get post code
     * @return string|null
     */
    public function getPostCode(): ?string
    {
        return $this->postcode;
    }

    /**
     * Set post code
     * @param string $code
     * @return Address
     */
    public function setPostCode(string $code): self
    {
        $this->postcode = $code;
        return $this;
    }

    /**
     * Get pickup point
     * @return null|PickupPoint
     */
    public function getPickupPoint(): ?PickupPoint
    {
        return $this->pickupPoint;
    }

    /**
     * Set pickup point
     * @param PickupPoint $point
     * @return $this
     */
    public function setPickupPoint(PickupPoint $point)
    {
        $this->pickupPoint = $point;
        return $this;
    }
}