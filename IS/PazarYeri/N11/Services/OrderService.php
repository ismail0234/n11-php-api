<?php

namespace IS\PazarYeri\N11\Services;

Class OrderService
{

	/**
	 *
	 * @description N11 SOAP Ürün Url
	 *
	 */
	public $url = 'https://api.n11.com/ws/OrderService.wsdl';

	/**
	 *
	 * @description Bu metot sipariş ile ilgili özet bilgileri listelemek için kullanılır.
	 *
	 */
	public function orderList($client, $data = array())
	{

		$query = array(
			'searchData' => array(
				'productId'         => '',
				'status'            => '',
				'buyerName'         => '',
				'orderNumber'       => '',
				'productSellerCode' => '',
				'recipient'         => '',
				'period'            => '',
				'sortForUpdateDate' => '',
			)
		);
		if (isset($data['productId'])) {
			$query['searchData']['productId'] = $data['productId'];
		}

		if (isset($data['status']) && in_array($data['status'], array('New', 'Approved', 'Rejected', 'Shipped', 'Delivered', 'Completed', 'Claimed', 'LATE_SHIPMENT'))) {
			$query['searchData']['status'] = $data['status'];
		}

		if (isset($data['buyerName'])) {
			$query['searchData']['buyerName'] = $data['buyerName'];
		}

		if (isset($data['orderNumber'])) {
			$query['searchData']['orderNumber'] = $data['orderNumber'];
		}

		if (isset($data['productSellerCode'])) {
			$query['searchData']['productSellerCode'] = $data['productSellerCode'];
		}

		if (isset($data['recipient'])) {
			$query['searchData']['recipient'] = $data['recipient'];
		}

		if (isset($data['period'])) {
			$query['searchData']['period'] = $data['period'];
		}

		if (isset($data['sortForUpdateDate'])) {
			$query['searchData']['sortForUpdateDate'] = $data['sortForUpdateDate'];
		}

		if (isset($data['pagingData'])) {
			$query['pagingData'] = $data['pagingData'];
		}

		return $client->sendRequest('orderList', $query);

	}

	/**
	 *
	 * @description Sipariş N11 ID bilgisi kullanarak sipariş detaylarını almak için kullanılır,
	 *				sipariş N11 ID bilgisine orderList metotlarıyla ulaşılabilir.
	 *
	 */
	public function orderDetail($client, $Id)
	{

		return $client->sendRequest('orderDetail', array('orderRequest' => array('id' => $Id)));

	}


	/**
	 *
	 * @description Bu metot siparişi onaylamak için kullanılır.
	 *
	 */
	public function orderAccept($client, $n11Id)
	{

		$query = array(
			'orderItem' => array(
				'id'         => $n11Id
			)
		);

		return $client->sendRequest('OrderItemAccept', $query);
}

/**
 *
 * @description Bu metot siparişi onaylamak için kullanılır.
 *
 */
public function orderReject($client, $data = array())
{

	$query = array(
		'orderItemList' => array(
			'orderItem' => array(
				'id'         => ""
			)
		),
		'rejectReason' => "",
		'rejectReasonType' => ""
	);


	if (isset($data['orderItemId'])) {
		$query['orderItemList']['orderItem']['id'] = $data['orderItemId'];
	}

	if (isset($data['rejectReason'])) {
		$query['rejectReason'] = $data['rejectReason'];
	}

	if (isset($data['rejectReasonType'])) {
		$query['rejectReasonType'] = $data['rejectReasonType'];
	}else {
		$query['rejectReasonType'] = "OTHER";
	}

	return $client->sendRequest('OrderItemReject', $query);
}
