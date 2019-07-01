<?php

namespace IS\PazarYeri\N11\Helper;


Class BaseCall
{

	/**
	 *
	 * @description SOAP Servis sınıfının örneği
	 *
	 */
	protected $service = null;

	/**
	 *
	 * @description SOAP İstek Sınıfının örneği
	 *
	 */
	protected $request = null;

	/**
	 *
	 * @description N11 SOAP Oturum Durumu
	 *
	 */
	protected $clientStatus = false;

	/**
	 *
	 * @description SOAP Api servislerinin ilk çağırma için hazırlanması
	 * @param string 
	 * @return service
	 *
	 */
	public function __construct($serviceName, $apiKey, $apiPassword)
	{

		$soapServiceName = "IS\PazarYeri\N11\Services\\" . $serviceName;
		$this->service = new $soapServiceName();
		$this->request = new Request($this->service->url , $apiKey, $apiPassword);

	}

	/**
	 *
	 * @description Gelen Tüm fonksiyon isteklerini ilgili servislere iletme
	 * @param string 
	 * @param array 
	 * @return string 
	 *
	 */
	public function __call($methodName, $arguments)
	{

		if(!$this->clientStatus) {
			$this->clientStatus = $this->request->connectSoap();
		}

		if (!method_exists($this->service, $methodName)) {
			throw new N11Exception("Method Bulunamadı");
		}
		
		return call_user_func_array(array($this->service, $methodName), array_merge(array($this->request), $arguments));

	}

}