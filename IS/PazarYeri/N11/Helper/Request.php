<?php

namespace IS\PazarYeri\N11\Helper;
require_once('nusoap.php');

Class Request
{

	/**
	 *
	 * @description N11 Api Key
	 *
	 */
	protected $apiKey;

	/**
	 *
	 * @description N11 Api Şifre
	 *
	 */
	protected $apiPassword;

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
		$this->client = new \nusoap_client($this->serviceUrl,'wsdl');
		$this->client->soap_defencoding = 'UTF-8';
		$this->client->decode_utf8 = false;

		$err = $this->client->getError();

		if ($err) {
			throw new N11Exception("SOAP Oturumu Başarısız");
		}else{
			return true; 
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

		$result = $this->client->call($method, array(array_merge(array('auth' => array('appKey' => $this->apiKey, 'appSecret' => $this->apiPassword)), $data)), '', '', false, true);
		
		if ($this->client->fault) {
			throw new N11Exception($result);
		}else {
			$err = $this->client->getError();
			if ($err) {
				throw new N11Exception($err);
			}else {
				return $result;
			}
		}

	}


}