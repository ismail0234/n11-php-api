<?php

namespace IS\PazarYeri\N11;

Class CategoryService
{

	/**
	 *
	 * @description N11 SOAP Kategori Url
	 *
	 */
	public $url = 'https://api.n11.com/ws/CategoryService.wsdl';

	/**
	 *
	 * @description N11 üzerinde tanımlanmış tüm üst seviye kategorileri döndürür.
	 *
	 */
	public function getTopLevelCategories($client)
	{	

		return $client->sendRequest('getTopLevelCategories');

	}

	/**
	 *
	 * @description İstenilen kategori, üst seviye kategori veya diğer seviye kategorilerden olabilir, bu kategorilere ait olan özelliklerin
	 *				ve bu özelliklere ait değerlerin listelenmesi için kullanılan metottur.
	 *
	 */
	public function getCategoryAttributes($client, $categoryId, $pagination = array())
	{	

		return $client->sendRequest('getCategoryAttributes', array('categoryId' => $categoryId, 'pagingData' => $pagination));

	}	

	/**
	 *
	 * @description İstenilen kategori, üst seviye kategori veya diğer seviye kategorilerden olabilir, 
	 * 				bu kategorilere ait olan özelliklerin listelenmesi için kullanılan metoddur.
	 *
	 */
	public function getCategoryAttributesId($client, $categoryId)
	{	

		return $client->sendRequest('getCategoryAttributesId', array('categoryId' => $categoryId));

	}

	/**
	 *
	 * @description Özelliğe sistemimizde verilen id bilgisini (category.attributeList.attribute.id) girdi vererek,
	 *				o özelliğe ait değerleri listeler.
	 *
	 */
	public function getCategoryAttributeValue($client, $attributeId, $pagination = array())
	{	

		return $client->sendRequest('getCategoryAttributeValue', array('categoryProductAttributeId' => $attributeId, 'pagingData' => $pagination));

	}

	/**
	 *
	 * @description Kodu verilen kategorinin birinci seviye üst kategorilerine ulaşmak için bu metot kullanılmalıdır. İkinci seviye üst 
	 *				kategorilere ulaşmak için (Örn. “Deri ayakkabı -> Ayakkabı -> Giysi” kategori ağacında “Giysi “ bilgisi) 
	 *				birinci seviye üst kategorinin (Örn. Ayakkabı) kodu verilerek tekrar servis çağırılmalıdır. 
	 *
	 */
	public function getParentCategory($client, $categoryId)
	{	

		return $client->sendRequest('getParentCategory', array('categoryId' => $categoryId));

	}

	/**
	 *
	 * @description Kodu verilen kategorinin birinci seviye alt kategorilerine ulaşmak için bu metot kullanılmalıdır. İkinci seviye alt 
	 *				kategorilere ulaşmak için (Örn. “Giysi -> Ayakkabı -> Deri ayakkabı” kategori ağacında “Deri ayakkabı” bilgisi) 
	 *				birinci Seviye alt kategorinin (Örn. Ayakkabı) kodu verilerek tekrar servis çağırılmalıdır. 
	 *
	 */
	public function getSubCategories($client, $categoryId)
	{	

		return $client->sendRequest('getSubCategories', array('categoryId' => $categoryId));

	}

}