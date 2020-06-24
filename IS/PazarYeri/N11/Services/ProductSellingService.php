<?php

namespace IS\PazarYeri\N11\Services;

Class ProductSellingService
{

	/**
	 *
	 * @description N11 SOAP Ürün Url
	 *
	 */
	public $url = 'https://api.n11.com/ws/ProductSellingService.wsdl';

	/**
	 *
	 * @description Satışta olan ürünün n11 ürün ID si kullanılarak satışa kapatılması için kullanılır.
	 *
	 */
	public function stopSellingProductByProductId($client, $productId)
	{	

		return $client->sendRequest('StopSellingProductByProductId', array('productId' => $productId));

	}	

	/**
	 *
	 * @description Satışta olmayan bir ürünün N11 ürün ID si kullanılarak satışa başlanması için kullanılır.  
	 *
	 */
	public function startSellingProductBySellerCode($client, $productSellerCode)
	{	

		return $client->sendRequest('StartSellingProductBySellerCode', array('productSellerCode' => $productSellerCode));

	}

	/**
	 *
	 * @description Satışta olmayan bir ürünün N11 ürün ID si kullanılarak satışa başlanması için kullanılır.
	 *
	 */
	public function startSellingProductByProductId($client, $productId)
	{	

		return $client->sendRequest('StartSellingProductByProductId', array('productId' => $productId));

	}

	/**
	 *
	 * @description Satışta olan ürünün mağaza ürün kodu kullanılarak satışının durdurulması için kullanılır.
	 *
	 */
	public function stopSellingProductBySellerCode($client, $productSellerCode)
	{	

		return $client->sendRequest('StopSellingProductBySellerCode', array('productSellerCode' => $productSellerCode));

	}
	
}