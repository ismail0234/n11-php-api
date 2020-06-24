<?php

namespace IS\PazarYeri\N11\Services;

Class ShipmentService
{

	/**
	 *
	 * @description N11 SOAP Teslimat Şablonu Servisi
	 *
	 */
	public $url = 'https://api.n11.com/ws/ShipmentService.wsdl';

	/**
	 *
	 * @description Oluşturulan teslimat şablonu bilgilerini listelemek için kullanılan metoddur.
	 *
	 */
	public function getShipmentTemplateList($client)
	{	

		return $client->sendRequest('GetShipmentTemplateList');

	}	

	/**
	 *
	 * @description Teslimat şablon ismi ile aratılan şablonun bilgilerini döndürür.
	 *
	 */
	public function getShipmentTemplate($client, $name)
	{	

		return $client->sendRequest('GetShipmentTemplate', array('name' => $name));

	}

	/**
	 *
	 * @description Teslimat şablonu kargonun nasıl gideceğine dair oluşturulan bir şablondur.
	 *				Siparişlerde kullanılacak olan teslimat şablonu özellikleriyle birlikte bu servis aracılığı  ile oluşturulur. 
	 *
	 */
	public function createOrUpdateShipmentTemplate($client, $data)
	{	

		return array();//$client->sendRequest('createOrUpdateShipmentTemplate', array('shipment' => $data));

	}

}