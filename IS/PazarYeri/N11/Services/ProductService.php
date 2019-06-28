<?php

namespace IS\PazarYeri\N11;

Class ProductService
{

	/**
	 *
	 * @description N11 SOAP Ürün Url
	 *
	 */
	public $url = 'https://api.n11.com/ws/ProductService.wsdl';

	/**
	 *
	 * @description N11 ürün ID sini kullanarak sistemde kayıtlı olan ürünün bilgilerini getirir.
	 *
	 */
	public function getProductByProductId($client, $productId)
	{	

		return $client->sendRequest('getProductByProductId', array('productId' => $productId));

	}
	
	/**
	 *
	 * @description Mağaza ürün kodunu kullanarak sistemde kayıtlı olan ürünün bilgilerini getirir.
	 *
	 */
	public function getProductBySellerCode($client, $sellerCode)
	{	

		return $client->sendRequest('getProductBySellerCode', array('sellerCode' => $sellerCode));

	}	

	/**
	 *
	 * @description N11 Üzerindeki ürünleri listelemek için kullanılır.
	 *
	 */
	public function getProductList($client, $pagination = array())
	{	

		return $client->sendRequest('getProductList', array('pagingData' => $pagination));

	}

	/**
	 *
	 * @description Mağaza ürünlerini aramak için kullanılır.
	 * @note Henüz tamamlanmadı
	 *
	 */
	/*public function searchProducts($client, $data = array())
	{	

		$searchData = array();
		if (isset($data['pagingData'])) {
			$searchData['pagingData'] = $data['pagingData'];
		}

		if (isset($data['productSearch'])) {
			$searchData['productSearch'] = $data['productSearch'];
		}

		if (isset($data['approvalStatus'])) {
			$searchData['approvalStatus'] = $data['approvalStatus'];
		}

		return $client->sendRequest('searchProducts', $searchData);

	}*/

}