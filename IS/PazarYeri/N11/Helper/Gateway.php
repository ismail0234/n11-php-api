<?php

namespace IS\PazarYeri\N11\Helper;

use IS\PazarYeri\N11\Exception;

Class GateWay
{

	/**
	 *
	 * @description N11 Api Key
	 *
	 */
	public $apiKey;

	/**
	 *
	 * @description N11 Api Şifre
	 *
	 */
	public $apiPassword;

	/**
	 *
	 * @description SOAP Api için kabul edilen servisler
	 *
	 */
	protected $allowedServices = array( 
		'city'            => 'CityService', 
		'shipmentcompany' => 'ShipmentCompanyService',
		'shipment'        => 'ShipmentService',
		'category'        => 'CategoryService',
		'product'         => 'ProductService',
		'selling'         => 'ProductSellingService',
		'stock'           => 'ProductStockService',
		'order'           => 'OrderService',
		'webhook'         => 'WebHookService',
	);

	/**
	 *
	 * @description SOAP Api servislerinin ilk çağırma için hazırlanması
	 * @param string 
	 * @return service
	 *
	 */
    public function __get($name)
    {

		if (!isset($this->allowedServices[$name])) {
			throw new N11Exception("Geçersiz Yordam!");
		}

		if (isset($this->$name)) {
			return $this->$name;
		}
		
		$this->$name = new BaseCall($this->allowedServices[$name], $this->apiKey, $this->apiPassword);
		return $this->$name;

    }
    
}