<?php

namespace Sf4\OmnivaBundle\Services;

use Sf4\OmnivaBundle\Services\ShipmentCreator\ItemCreator;
use XMLWriter;

/**
 * Class ShipmentCreator
 * @package Sf4\OmnivaBundle\Services
 */
class ShipmentCreator
{
    /**
     * @var Parcel $parcel
     */
    protected $parcel;

    /**
     * @var XMLWriter $writer
     */
    protected $writer;

    /**
     * @var string|null $partner
     */
    protected $partner;

    /**
     * @var string|null $msgType
     */
    protected $msgType;

    /**
     * @var string $clientCode ;
     */
    protected $clientCode;

    /**
     * ShipmentCreator constructor.
     * @param Parcel $parcel
     */
    public function __construct(Parcel $parcel)
    {
        $this->setParcel($parcel);
        $this->setWriter(new XMLWriter());
    }

    /**
     * Create shipment
     */
    public function createShipment()
    {
        $writer = $this->getWriter();

        $writer->openMemory();

        $writer->startElement('ns1:businessToClientMsgRequest');

        $this->writePartner($writer);

        $writer->startElement('interchange');

        if ($this->getMessageType()) {
            $writer->writeAttribute('msg_type', $this->getMessageType());
        }

        $this->writeHeader($writer);

        $this->writeItems($writer);

        $writer->endElement();

        $writer->endElement();
    }

    /**
     * Get xml writer
     * @return XMLWriter
     */
    public function getWriter(): XMLWriter
    {
        return $this->writer;
    }

    /**
     * Set xml writer
     * @param XMLWriter $writer
     */
    public function setWriter(XMLWriter $writer): void
    {
        $this->writer = $writer;
    }

    /**
     * Write partner
     * @param XMLWriter $writer
     */
    protected function writePartner(XMLWriter $writer)
    {
        if ($this->getPartner()) {
            $writer->writeElement('partner', $this->getPartner());
        }
    }

    /**
     * Get partner
     * @return string|null
     */
    public function getPartner(): ?string
    {
        return $this->partner;
    }

    /**
     * Set partner
     * @param string $partner
     */
    public function setPartner(string $partner): void
    {
        $this->partner = $partner;
    }

    /**
     * Get message type
     * @return string|null
     */
    public function getMessageType(): ?string
    {
        return $this->msgType;
    }

    /**
     * Write header
     * @param XMLWriter $writer
     */
    protected function writeHeader(XMLWriter $writer)
    {
        $writer->startElement('header');
        $writer->writeAttribute('file_id', date("YmdHms"));
        $writer->writeAttribute('sender_cd', $this->getClientCode());
        $writer->endElement();
    }

    /**
     * Get client code
     * @return string
     */
    public function getClientCode(): string
    {
        return $this->clientCode;
    }

    /**
     * Set client code
     * @param string $clientCode
     */
    public function setClientCode(string $clientCode): void
    {
        $this->clientCode = $clientCode;
    }

    /**
     * Write items
     * @param XMLWriter $writer
     */
    protected function writeItems(XMLWriter $writer)
    {
        $writer->startElement('item_list');

        $itemCreator = new ItemCreator($this);
        $itemCreator->writeItem();

        $writer->endElement();
    }

    /**
     * Get parcel
     * @return Parcel
     */
    public function getParcel(): Parcel
    {
        return $this->parcel;
    }

    /**
     * Set parcel
     * @param Parcel $parcel
     */
    public function setParcel(Parcel $parcel): void
    {
        $this->parcel = $parcel;
    }

    /**
     * Set message type
     * @param string|null $msgType
     */
    public function setMessageType(?string $msgType): void
    {
        $this->msgType = $msgType;
    }


}