<?php

namespace IS\PazarYeri\N11\Services;

Class ShipmentCompanyService
{

	/**
	 *
	 * @description N11 SOAP Kargo Şirketi Url
	 *
	 */
	public $url = 'https://api.n11.com/ws/ShipmentCompanyService.wsdl';

	/**
	 *
	 * @description N11 Üzerinde tanımlı olan tüm kargo şirketlerini listeler
	 *
	 */
	public function getShipmentCompanies($client)
	{	

		return $client->sendRequest('GetShipmentCompanies');

	}

}