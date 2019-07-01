<?php 

namespace IS\PazarYeri\N11\Services;

use IS\PazarYeri\N11\Helper;

Class WebHookService extends Helper\Database
{

	/**
	 *
	 * @description SOAP Api url
	 * @param string 
	 *
	 */
	public $url = 'https://api.n11.com/ws/OrderService.wsdl';

	/**
	 *
	 * @description N11 Üzerinde yeni siparişlerin sorgulanacağı aralık (saniye)
	 * @param int 
	 *
	 */
	protected $requestTime = 180;

	/**
	 *
	 * @description Son yapılan istek zamanı
	 * @param int 
	 *
	 */
	protected $requestEndTime;

	/**
	 *
	 * @description İlk başlama zamanı
	 * @param int 
	 *
	 */
	protected $startedTime;

	/**
	 *
	 * @description orderConsume çalıştırıldığında eski siparişler kontrol edilsinmi?
	 * @param bool 
	 *
	 */
	protected $orderOldConsume = true;


	/**
	 *
	 * @description Sipariş listesinden kaç adet sipariş getirileceği.
	 * @param bool 
	 *
	 */
	protected $orderMaxResult = 50;

	/**
	 *
	 * @description OrderService sınıfının bir örneği
	 * @param class 
	 *
	 */
	protected $order;

	/**
	 *
	 * @description WebHookService Sınıfını Başlatma
	 *
	 */
	public function __construct()
	{

		$this->startedTime    = time();
		$this->requestEndTime = time();
		$this->order = new OrderService();
		parent::__construct();

	}

	/**
	 *
	 * @description N11 Üzerindeki Yeni Siparişleri Tüketme
	 *
	 */
	public function orderConsume($client, $work)
	{	

		while (true) 
		{
			
			if (time() >= $this->requestEndTime) {
				$this->requestEndTime = time() + $this->requestTime;

				foreach ($this->getOrderList($client) as $order) {

					$dborder = $this->selectOrder($order->id);
					if (isset($dborder->orderid)) {
						continue;
					}

					$this->addOrder($order->id);
					
					if (is_array($work)) {
						call_user_func_array(array($work[0], $work[1]), array($this->order->orderDetail($client, $order->id)));
					}else{
						$work($this->order->orderDetail($client, $order->id));
					}

					$this->finishOrder($order->id);

				}

			}

			sleep(1);
		}

	}

	/**
	 *
	 * @description N11 Üzerindeki siparişlerin kriterlere göre getirilmesi
	 * @param Request Class 
	 * @return array 
	 *
	 */
	protected function getOrderList($client)
	{

		$orders = $this->order->orderList($client, $this->getOrderSettings());
		if (!isset($orders->result)) {
			throw new N11Exception("Sipariş Listesi Alınamadı.");
		}

		if ($orders->result->status != "success") {
			throw new N11Exception("Sipariş Listesi Alınamadı. Hata => " . $orders->result->errorMessage);
		}

		return $orders->orderList->order;
	}

	/**
	 *
	 * @description Sipariş listesi kriterleri 
	 *
	 */
	protected function getOrderSettings()
	{	

		$oldPeriod = array();
		if (!$this->orderOldConsume) {
			$oldPeriod['startDate'] = date('d/m/Y H:i:s', $this->startedTime);
			$oldPeriod['endDate']   = date('d/m/Y H:i:s', time() + $this->requestTime + 15);
		}

		return array(
			'period'     => $oldPeriod,
			'pagingData' => array(
				'currentPage' => 0,
				'pageSize'    => $this->orderMaxResult
			)
		);

	}

	/**
	 *
	 * @description N11 Siparişlerinin en kadar hızlı tüketileceği.
	 * @param string  
	 *
	 */
	public function setRequestMode($mode)
	{

		switch ($mode) 
		{
			case 'slow'  : $this->requestTime = 300; break;
			case 'fast'  : $this->requestTime = 60; break;
			case 'vfast' : $this->requestTime = 30; break;
			case 'medium': 
			default:
				$this->requestTime = 180;
			break;
		}

	}

	/**
	 *
	 * @description N11 Sipariş listesinde kaç adet siparişin getirileceği
	 * @param string 
	 *
	 */
	public function setResultMode($mode)
	{

		switch ($mode) 
		{
			case 'vmax'  	: $this->orderMaxResult = 100; break;
			case 'max' 		: $this->orderMaxResult = 75; break;
			case 'min'		: $this->orderMaxResult = 30; break;
			case 'medium'	: 
			default:
				$this->orderMaxResult = 50;
			break;
		}

	}

	/**
	 *
	 * @description N11 Siparişlerinde eski eklenmeyen siparişler kontrol edilecekmi
	 * @param string 
	 *
	 */
	public function setOldConsumeMode($mode)
	{

		$this->orderOldConsume = $mode == true ? true : false;

	}

}