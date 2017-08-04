<?php
namespace Lopatinas\DpdBundle\Interfaces;

interface DpdSoapInterface
{

    /**
     * Endpoint: geography2?wsdl
     *
     * Parameters: {
     *   {name: request[auth][clientNumber], type: string, required: true},
     *   {name: request[auth][clientKey], type: string, required: true},
     *   {name: request[countryCode], type: string, required: false}
     * }
     *
     * Response: {
     *   {name: city[cityId], type: int},
     *   {name: city[countryCode], type: string},
     *   {name: city[countryName], type: string},
     *   {name: city[regionCode], type: string},
     *   {name: city[regionName], type: string},
     *   {name: city[cityCode], type: string},
     *   {name: city[cityName], type: string},
     *   {name: city[abbreviation], type: string},
     *   {name: city[indexMin], type: string},
     *   {name: city[indexMax], type: string}
     * }
     *
     * Description:
     *   Получить список городов с возможностью доставки с наложенным платежом
     *
     * @param array $requestData
     * @return array
     */
    public function getCitiesCashPay($requestData);

    /**
     * Endpoint: geography2?wsdl
     *
     * Parameters: {
     *   {name: request[auth][clientNumber], type: string, required: true},
     *   {name: request[auth][clientKey], type: string, required: true},
     *   {name: request[countryCode], type: string, required: false},
     *   {name: request[regionCode], type: string, required: false},
     *   {name: request[cityCode], type: string, required: false},
     *   {name: request[cityName], type: string, required: false}
     * }
     *
     * Response: {
     *   {name: parcelShop[code], type: string},
     *   {name: parcelShop[parcelShopType], type: string, values: [П, ПВП]},
     *   {name: parcelShop[state], type: string, values: [open, full]},
     *   {name: parcelShop[address][countryCode], type: string},
     *   {name: parcelShop[address][regionCode], type: string},
     *   {name: parcelShop[address][regionName], type: string},
     *   {name: parcelShop[address][cityCode], type: string},
     *   {name: parcelShop[address][cityName], type: string},
     *   {name: parcelShop[address][street], type: string},
     *   {name: parcelShop[address][streetAbbr], type: string},
     *   {name: parcelShop[address][houseNo], type: string},
     *   {name: parcelShop[address][building], type: string},
     *   {name: parcelShop[address][structure], type: string},
     *   {name: parcelShop[address][ownership], type: string},
     *   {name: parcelShop[geoCoordinates][latitude], type: float},
     *   {name: parcelShop[geoCoordinates][longitude], type: float},
     *   {name: parcelShop[limits][maxShipmentWeight], unit: кг, type: float},
     *   {name: parcelShop[limits][maxWeight], unit: кг, type: float},
     *   {name: parcelShop[limits][maxLength], unit: см, type: float},
     *   {name: parcelShop[limits][maxWidth], unit: см, type: float},
     *   {name: parcelShop[limits][MaxHeight], unit: см, type: float},
     *   {name: parcelShop[schedule][operation], type: string, values: [SelfPickup, SelfDelivery]},
     *   {name: parcelShop[schedule][timetable][weekDays], type: string},
     *   {name: parcelShop[schedule][timetable][workTime], type: string}
     * }
     *
     * Description:
     *   Получить список пунктов приема/выдачи посылок, имеющих ограничения по габаритам и весу,
     *   с указанием режима работы пункта и доступностью выполнения самопривоза/самовывоза.
     *   При работе с методом необходимо проводить получение информации по списку подразделений ежедневно.
     *
     * @param array $requestData
     * @return array
     */
    public function getParcelShops($requestData);

    /**
     * Endpoint: geography2?wsdl
     *
     * Parameters: {
     *   {name: request[auth][clientNumber], type: string, required: true},
     *   {name: request[auth][clientKey], type: string, required: true},
     *   {name: request[countryCode], type: string, required: false},
     *   {name: request[regionCode], type: string, required: false},
     *   {name: request[cityCode], type: string, required: false},
     *   {name: request[cityName], type: string, required: false}
     * }
     *
     * Response: {
     *   {name: terminal[terminalCode], type: string},
     *   {name: terminal[terminalName], type: string},
     *   {name: terminal[address][countryCode], type: string},
     *   {name: terminal[address][regionCode], type: string},
     *   {name: terminal[address][regionName], type: string},
     *   {name: terminal[address][cityCode], type: string},
     *   {name: terminal[address][cityName], type: string},
     *   {name: terminal[address][street], type: string},
     *   {name: terminal[address][streetAbbr], type: string},
     *   {name: terminal[address][houseNo], type: string},
     *   {name: terminal[address][building], type: string},
     *   {name: terminal[address][structure], type: string},
     *   {name: terminal[address][ownership], type: string},
     *   {name: terminal[geoCoordinates][latitude], type: float},
     *   {name: terminal[geoCoordinates][longitude], type: float},
     *   {name: terminal[schedule][operation], type: string, values: [SelfPickup, SelfDelivery]},
     *   {name: terminal[schedule][timetable][weekDays], type: string},
     *   {name: terminal[schedule][timetable][workTime], type: string}
     * }
     *
     * Description:
     *   Получить список подразделений DPD, не имеющих ограничений по габаритам и весу посылок приема/выдачи
     *
     * @param array $requestData
     * @return array
     */
    public function getTerminalsSelfDelivery2($requestData);

    /**
     * Endpoint: calculator2?wsdl
     *
     * Description:
     *   Оценка стоимости доставки по посылкам
     *
     * @param $requestData
     * @return mixed
     */
    public function getServiceCostByParcels2($requestData);
}
