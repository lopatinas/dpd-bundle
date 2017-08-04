<?php

namespace Lopatinas\DpdBundle\Service;

use Lopatinas\DpdBundle\Exception\DpdException;
use Lopatinas\DpdBundle\Interfaces\DpdSoapInterface;

class DpdService
{
    const API_URL_PROD = 'http://ws.dpd.ru/services/';
    const API_URL_DEV = 'http://wstest.dpd.ru/services/';

    /** @var string */
    private $url;

    /** @var string */
    private $clientId;

    /** @var string */
    private $clientKey;

    private static $methodMap = [
        'getServiceCostByParcels2' => 'calculator2'
    ];

    /**
     * @param $isDev
     * @param $clientId
     * @param $clientKey
     */
    public function setAuthData($isDev, $clientId, $clientKey)
    {
        $this->url = !$isDev ? self::API_URL_PROD : self::API_URL_DEV;
        $this->clientId = $clientId;
        $this->clientKey = $clientKey;
    }

    private function doRequest($method, $data)
    {
        if (!isset(self::$methodMap[$method])) {
            throw new DpdException(sprintf('Method "%s" not found'), $method);
        }

        /** @var DpdSoapInterface $client */
        $client = new \SoapClient($this->url . self::$methodMap[$method] . '?wsdl');
        $request = [
            'auth' => [
                'clientNumber' => $this->clientId,
                'clientKey' => $this->clientKey,
            ],
        ];
        return $client->$method(array_merge($data, $request));
    }

    public function calculate(array $data)
    {
        return $this->doRequest('getServiceCostByParcels2', $data);
    }
}
