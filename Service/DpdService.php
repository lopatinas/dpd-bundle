<?php

namespace Lopatinas\DpdBundle\Service;

use Lopatinas\DpdBundle\Exception\DpdException;
use Lopatinas\DpdBundle\Interfaces\DpdSoapInterface;

class DpdService
{
    const API_URL_PROD = 'https://ws.dpd.ru/services/';
    const API_URL_DEV = 'https://wstest.dpd.ru/services/';

    /** @var string */
    private $url;

    /** @var string */
    private $clientId;

    /** @var string */
    private $clientKey;

    private static $methodMap = [
        'getServiceCostByParcels2' => 'calculator2',
        'createOrder' => 'order2',
        'getTerminalsSelfDelivery2' => 'geography2',
        'getParcelShops' => 'geography2',
    ];

    /**
     * @param $isDev
     * @param $clientId
     * @param $clientKey
     */
    public function __construct($isDev, $clientId, $clientKey)
    {
        $this->url = !$isDev ? self::API_URL_PROD : self::API_URL_DEV;
        $this->clientId = $clientId;
        $this->clientKey = $clientKey;
    }

    /**
     * @param $method
     * @param $data
     * @param string $tag
     * @return mixed
     */
    private function doRequest($method, $data = [], $tag = '')
    {
        if (!isset(self::$methodMap[$method])) {
            throw new DpdException(sprintf('Method "%s" not found'), $method);
        }

        /** @var DpdSoapInterface $client */
        $client = new \SoapClient(sprintf('%s%s?wsdl', $this->url, self::$methodMap[$method]));

        $request = [
            'auth' => [
                'clientNumber' => $this->clientId,
                'clientKey' => $this->clientKey,
            ],
        ];

        $data = array_merge($request, $data);
        if (!empty($tag)) {
            $data[$tag] = $data;
        }

        try {
            $result = $client->$method($data);
        } catch (\Exception $e) {
            throw new DpdException($e->getMessage(), $e->getCode(), $e->getPrevious());
        }

        return $result;
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function calculate(array $data)
    {
        return $this->doRequest('getServiceCostByParcels2', $data, 'request');
    }

    /**
     * @param array $data
     * @return mixed
     */
    public function createOrder(array $data)
    {
        return $this->doRequest('createOrder', $data, 'orders');
    }

    /**
     * @return mixed
     */
    public function getSelfDeliveryTerminals()
    {
        return $this->doRequest('getTerminalsSelfDelivery2');
    }

    /**
     * @return mixed
     */
    public function getParcelShops()
    {
        return $this->doRequest('getParcelShops', [], 'request');
    }
}
