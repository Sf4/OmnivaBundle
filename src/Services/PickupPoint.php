<?php

namespace Sf4\OmnivaBundle\Services;


/**
 * Class PickupPoint
 * @package Sf4\OmnivaBundle\Services
 */
class PickupPoint
{

    const TYPE_TERMINAL = 0;
    const TYPE_POST_OFFICE = 1;

    /**
     * @var int|null $type
     */
    private $type;

    /**
     * @var string $identifier
     */
    private $identifier;

    /**
     * PickupPoint constructor.
     * @param string $identifier
     */
    public function __construct(string $identifier)
    {
        $this->identifier = $identifier;
    }

    /**
     * Get identifier
     * @return string
     */
    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    /**
     * Set identifier
     * @param string $identifier
     * @return PickupPoint
     */
    public function setIdentifier(string $identifier): self
    {
        $this->identifier = $identifier;
        return $this;
    }

    /**
     * Is post office
     * @return bool
     */
    public function isPostOffice(): bool
    {
        $this->guardAgainstEmptyType();
        return $this->getType() === self::TYPE_POST_OFFICE;
    }

    /**
     * Guard against empty type
     */
    private function guardAgainstEmptyType(): void
    {
        if ($this->getType() === null) {
            throw new \RuntimeException('No type has been provided');
        }
    }

    /**
     * Get type
     * @return int|null
     */
    public function getType(): ?int
    {
        return $this->type;
    }

    /**
     * Set type
     * @param int $type
     * @return PickupPoint
     */
    public function setType(int $type): self
    {
        if (!in_array($type, [self::TYPE_TERMINAL, self::TYPE_POST_OFFICE])) {
            throw new \InvalidArgumentException('Unsupported type');
        }

        $this->type = $type;
        return $this;
    }

    /**
     * Is terminal
     * @return bool
     */
    public function isTerminal(): bool
    {
        $this->guardAgainstEmptyType();
        return $this->getType() === self::TYPE_TERMINAL;
    }
}