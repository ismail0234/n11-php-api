<?php

namespace IS\PazarYeri\N11\Services;

Class ProductStockService
{

	/**
	 *
	 * @description N11 SOAP Ürün Url
	 *
	 */
	public $url = 'https://api.n11.com/ws/ProductStockService.wsdl';

	/**
	 *
	 * @description Sistemde kayıtlı olan ürünün N11 ürün ID si ile ürün stok bilgilerini getiren metottur. 
	 * 				Cevap içinde stok durumunun “version” bilgisi de vardır, ürün stoklarında değişme olduysa 
	 *				bu versiyon bilgisi artacaktır, çağrı yapan taraf versiyon bilgisini kontrol ederek N11 e 
	 *				verilen stok bilgilerinde değişim olup olmadığını anlayabilir.
	 *
	 */
	public function getProductStockByProductId($client, $productId)
	{	

		return $client->sendRequest('GetProductStockByProductId', array('productId' => $productId));

	}	
	
}


