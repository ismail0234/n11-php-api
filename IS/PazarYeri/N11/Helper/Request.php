<?php

namespace IS\PazarYeri\N11\Helper;

Class Request
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
	 * @description SOAP Service Url
	 *
	 */
	protected $serviceUrl;

	/**
	 *
	 * @description N11 SOAP Oturumu
	 *
	 */
	protected $client = false;

	/**
	 *
	 * @description Service Url Depolama için.
	 * @param string 
	 *
	 */
	public function __construct($serviceUrl, $apiKey, $apiPassword)
	{

		$this->apiKey      = $apiKey;
		$this->apiPassword = $apiPassword;
		$this->serviceUrl  = $serviceUrl;

	}

	/**
	 *
	 * @description SOAP Oturumunu Başlatma
	 * @param string 
	 * @return SoapClient 
	 *
	 */
	public function connectSoap()
	{

		try {
			$this->client = new \SoapClient($this->serviceUrl, array("trace" => 1, "exception" => false, 'cache_wsdl' => WSDL_CACHE_NONE));
			return true; 
		} catch (\Exception $e) {
			throw new N11Exception("SOAP Oturumu Başarısız");
		}

	}

	/**
	 *
	 * @description SOAP İstek Gönderme
	 * @param string 
	 * @return SoapClient 
	 *
	 */
	public function sendRequest($method, $data = array())
	{

		if (isset($data['auth'])) {
			unset($data['auth']);
		}

		return $this->client->$method(array_merge(array('auth' => array('appKey' => $this->apiKey, 'appSecret' => $this->apiPassword)), $data));

	}


}