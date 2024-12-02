<?php

namespace IS\PazarYeri\N11\Services;

use IS\PazarYeri\N11\Helper\Request;

class SellerInvoiceService
{

    /**
     *
     * @description N11 SOAP Ürün Url
     *
     */
    public $url = 'https://api.n11.com/ws/SellerInvoiceService.wsdl';


    /**
     * @description Sipariş ile ilgili, çalıştığınız fatura servisinden
     *              elde ettiğiniz link şeklindeki faturalarızı, ilgili siparişe kaydetmek için kullanılır.
     *              PDF, PNG, JPEG, JPG, HTML formatlarında HTTPS protokolü ile gönderilmelidir.
     *              Maksimum link uzunluğu 2048 karakterdir.
     *
     * @param Request $client
     * @param array{
     *      orderNumber: string,
     *      url: string
     * } $data
     * @return mixed
     */
    public function saveLinkSellerInvoice(Request $client, array $data)
    {
        return $client->sendRequest('saveLinkSellerInvoice', $data);
    }


}