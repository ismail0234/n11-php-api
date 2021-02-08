<?php

namespace IS\PazarYeri\N11\Services;

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

		return $client->sendRequest('GetProductByProductId', array('productId' => $productId));

	}
	
	/**
	 *
	 * @description Mağaza ürün kodunu kullanarak sistemde kayıtlı olan ürünün bilgilerini getirir.
	 *
	 */
	public function getProductBySellerCode($client, $sellerCode)
	{	

		return $client->sendRequest('GetProductBySellerCode', array('sellerCode' => $sellerCode));

	}	

	/**
	 *
	 * @description N11 Üzerindeki ürünleri listelemek için kullanılır.
	 *
	 */
	public function getProductList($client, $pagination = array())
	{	

		return $client->sendRequest('GetProductList', array('pagingData' => $pagination));

	}
	
	/**
	 *
	 * @description Mağaza'ya yeni ürün eklemek için kullanılır
	 *
	 */

	public function SaveProduct($client, $product = array()) {
		return $client->sendRequest('SaveProduct', array('product' => $product));
		
	}


	/**
	 *
	 * @description Kayıtlı olan bir ürünü N11 Id si kullanarak silmek için kullanılır.
	 *
	 */
	public function deleteProductById($client, $productId)
	{	

		return $client->sendRequest('DeleteProductById', array('productId' => $productId));

	}

	/**
	 *
	 * @description Kayıtlı olan bir ürünü mağaza ürün kodu kullanılarak silmek için kullanılır.
	 *
	 */
	public function deleteProductBySellerCode($client, $productSellerCode)
	{	

		return $client->sendRequest('DeleteProductBySellerCode', array('productSellerCode' => $productSellerCode));

	}	

	/**
	 *
	 * @description Kayıtlı olan bir ürünü mağaza ürün kodu kullanılarak silmek için kullanılır.
	 * @note Henüz tamamlanmadı
	 *
	 */
	/*public function productApprovalStatus($client)
	{	

		return $client->sendRequest('productApprovalStatus');

	}*/

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
