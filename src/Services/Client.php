<?php

namespace Sf4\OmnivaBundle\Services;

use SoapClient;
use SoapVar;
use GuzzleHttp\Client as HttpClient;

/**
 * Class Client
 * @package Sf4\OmnivaBundle\Services
 */
class Client
{
    CONST WSDL_URL = 'https://edixml.post.ee/epmx/services/messagesService.wsdl';

    /**
     * @var string $username
     */
    private $username;

    /**
     * @var string $password
     */
    private $password;

    /**
     * @var SoapClient $soapClient
     */
    private $soapClient;

    /**
     * @var HttpClient $httpClient;
     */
    private $httpClient;

    /**
     * Client constructor.
     * @param string $username
     * @param string $password
     */
    public function __construct(string $username, string $password)
    {
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * Create shipment
     * @param Parcel $parcel
     * @param string $clientCode
     * @param string $partnerId
     * @param string|null $messageType
     * @return mixed
     */
    public function createShipment(Parcel $parcel, string $clientCode, string $partnerId, string $messageType = null)
    {
        $shipmentCreator = new ShipmentCreator($parcel);
        $shipmentCreator->setClientCode($clientCode);
        $shipmentCreator->setPartner($partnerId);
        $shipmentCreator->setMessageType($messageType);
        $shipmentCreator->createShipment();
        $writer = $shipmentCreator->getWriter();

        return $this->getSoapClient()->businessToClientMsg(
            new SoapVar($writer->outputMemory(), XSD_ANYXML)
        );
    }

    /**
     * Get pickup points
     * @return array
     */
    public function getPickupPoints(): array
    {
        $response = $this->getHttpClient()->request('GET', 'https://www.omniva.ee/locations.csv');

        $content = (string)$response->getBody();

        $pickupPoints = [];
        $file = fopen('php://temp','r+');
        fwrite($file, $content);
        rewind($file); //rewind to process CSV
        while (($row = fgetcsv($file, 0, ';')) !== FALSE) {
            $pickupPoints[] = $row;
        }

        // remove first item because it has only titles
        unset($pickupPoints[0]);

        return $pickupPoints;
    }

    /**
     * Get soap client
     * @return SoapClient
     */
    public function getSoapClient(): SoapClient
    {
        if (!$this->soapClient instanceof SoapClient) {
            $this->soapClient = new SoapClient(
                static::WSDL_URL,
                [
                    'login' => $this->username,
                    'password' => $this->password,
                    'trace' => true,
                    'exceptions' => true
                ]
            );
        }

        return $this->soapClient;
    }

    /**
     * Get http client
     * @return HttpClient
     */
    public function getHttpClient(): HttpClient
    {
        if (!$this->httpClient instanceof HttpClient) {
            $this->httpClient = new HttpClient();
        }

        return $this->httpClient;
    }
}