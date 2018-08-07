<?php

namespace Sf4\OmnivaBundle\Services\ShipmentCreator;

use Sf4\OmnivaBundle\Services\Address;
use Sf4\OmnivaBundle\Services\Parcel;
use Sf4\OmnivaBundle\Services\PickupPoint;
use Sf4\OmnivaBundle\Services\Service;
use Sf4\OmnivaBundle\Services\ShipmentCreator;
use XMLWriter;

/**
 * Class ItemCreator
 * @package Sf4\OmnivaBundle\Services\ShipmentCreator
 */
class ItemCreator
{
    /**
     * @var ShipmentCreator $shipmentCreator
     */
    protected $shipmentCreator;

    /**
     * ItemCreator constructor.
     * @param ShipmentCreator $shipmentCreator
     */
    public function __construct(ShipmentCreator $shipmentCreator)
    {
        $this->setShipmentCreator($shipmentCreator);
    }

    /**
     * Write item
     */
    public function writeItem()
    {
        $parcel = $this->getShipmentCreator()->getParcel();
        $writer = $this->getShipmentCreator()->getWriter();
        $receiver = $parcel->getReceiver();
        $pickupPoint = $receiver->getPickupPoint();

        $writer->startElement('item');

        $this->writeServices($writer, $parcel, $pickupPoint);
        $this->writeMeasures($writer, $parcel);
        $this->writeAmount($writer, $parcel);
        $this->writeComment($writer, $parcel);
        $this->writePartnerId($writer, $parcel);
        $this->writeReceiverAddressee($writer, $parcel, $pickupPoint);
        $this->writeReturnAddressee($writer, $parcel);
        $this->writeOnLoadAddressee($writer, $parcel);

        $writer->endElement();
    }

    /**
     * Get shipment creator
     * @return ShipmentCreator
     */
    public function getShipmentCreator(): ShipmentCreator
    {
        return $this->shipmentCreator;
    }

    /**
     * Set shipment creator
     * @param ShipmentCreator $shipmentCreator
     */
    public function setShipmentCreator(ShipmentCreator $shipmentCreator): void
    {
        $this->shipmentCreator = $shipmentCreator;
    }

    /**
     * Write services
     * @param XMLWriter $writer
     * @param Parcel $parcel
     * @param mixed $pickupPoint
     */
    protected function writeServices(XMLWriter $writer, Parcel $parcel, $pickupPoint)
    {
        $deliveryServiceCode = $this->getDeliveryServiceCode($pickupPoint);
        $writer->writeAttribute('service', $deliveryServiceCode->getValue());

        if ($parcel->hasServices()) {
            $writer->startElement('add_service');
            foreach ($parcel->getServices() as $service) {
                $writer->startElement('option');
                $writer->writeAttribute('code', $service->getValue());
                $writer->endElement();
            }
            $writer->endElement();
        }
    }

    /**
     * Get delivery service code
     * @param $pickupPoint mixed
     * @return Service
     */
    protected function getDeliveryServiceCode($pickupPoint): Service
    {
        $parcel = $this->getShipmentCreator()->getParcel();
        $receiver = $parcel->getReceiver();

        if ($pickupPoint instanceof PickupPoint) {
            if ($pickupPoint->isPostOffice()) {
                $deliveryServiceCode = Service::POST_OFFICE();
            } else if ($pickupPoint->isTerminal()) {
                $deliveryServiceCode = Service::TERMINAL();
            } else {
                throw new \RuntimeException('Wrong PickupPoint provided');
            }
        } else {
            if (in_array($receiver->getCountryCode(), ['LT', 'LV'])) {
                $deliveryServiceCode = Service::COURIER_LT_LV();
            } else {
                $deliveryServiceCode = Service::COURIER();
            }
        }

        return $deliveryServiceCode;
    }

    /**
     * Write Measures
     * @param XMLWriter $writer
     * @param Parcel $parcel
     */
    protected function writeMeasures(XMLWriter $writer, Parcel $parcel)
    {
        $writer->startElement('measures');
        $writer->writeAttribute('weight', $parcel->getWeight());
        $writer->endElement();
    }

    /**
     * Write amount
     * @param XMLWriter $writer
     * @param Parcel $parcel
     */
    protected function writeAmount(XMLWriter $writer, Parcel $parcel)
    {
        if ($parcel->getCodAmount()) {
            $writer->startElement('monetary_values');

            $writer->startElement('values');
            $writer->writeAttribute('code', 'item_value');
            $writer->writeAttribute('amount', $parcel->getCodAmount());
            $writer->endElement();

            $writer->endElement();

            $writer->writeElement('account', $parcel->getBankAccount());
        }
    }

    /**
     * Write comment
     * @param XMLWriter $writer
     * @param Parcel $parcel
     */
    protected function writeComment(XMLWriter $writer, Parcel $parcel)
    {
        if ($parcel->hasComment()) {
            $writer->writeElement('comment', $parcel->getComment());
        }
    }

    /**
     * Write partner id
     * @param XMLWriter $writer
     * @param Parcel $parcel
     */
    protected function writePartnerId(XMLWriter $writer, Parcel $parcel)
    {
        $writer->writeElement('partnerId', $parcel->getPartnerId());
    }

    /**
     * Write receiver addressee
     * @param XMLWriter $writer
     * @param Parcel $parcel
     * @param $pickupPoint
     */
    protected function writeReceiverAddressee(XMLWriter $writer, Parcel $parcel, $pickupPoint)
    {
        $writer->startElement('receiverAddressee');

        $this->writeAddress($writer, $parcel->getReceiver());

        $writer->endElement();
    }

    /**
     * Write return addressee
     * @param XMLWriter $writer
     * @param Parcel $parcel
     */
    protected function writeReturnAddressee(XMLWriter $writer, Parcel $parcel)
    {
        $writer->startElement('returnAddressee');

        $this->writeAddress($writer, $parcel->getReturnee());

        $writer->endElement();
    }

    protected function writeAddress(XMLWriter $writer, Address $address)
    {
        $writer->writeElement('person_name', $address->getName());
        $writer->writeElement('phone', $address->getPhone());

        if ($address->hasEmail()) {
            $writer->writeElement('email', $address->getEmail());
        }

        $writer->startElement('address');
        $writer->writeAttribute('postcode', $address->getPostCode());
        $writer->writeAttribute('deliverypoint', $address->getCity());
        $writer->writeAttribute('street', $address->getStreet());
        $writer->writeAttribute('country', $address->getCountryCode());
        $writer->endElement();
    }

    /**
     * Write on load addressee
     * @param XMLWriter $writer
     * @param Parcel $parcel
     */
    protected function writeOnLoadAddressee(XMLWriter $writer, Parcel $parcel)
    {
        $writer->startElement('onloadAddressee');

        $this->writeAddress($writer, $parcel->getSender());

        $writer->endElement();
    }

}