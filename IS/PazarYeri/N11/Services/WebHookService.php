<?php 

namespace IS\PazarYeri\N11\Services;

use IS\PazarYeri\N11\Helper\Database;
use IS\PazarYeri\N11\Helper\N11Exception;

Class WebHookService extends Database
{

	/**
	 *
	 * SOAP Api url
	 *
	 * @author Ismail Satilmis <ismaiil_0234@hotmail.com>
	 * @var string 
	 *
	 */
	public $url = 'https://api.n11.com/ws/OrderService.wsdl';

	/**
	 *
	 * N11 Üzerinde yeni siparişlerin sorgulanacağı aralık (saniye)
	 *
	 * @author Ismail Satilmis <ismaiil_0234@hotmail.com>
	 * @var int 
	 *
	 */
	protected $requestTime = 180;

	/**
	 *
	 * Son yapılan istek zamanı
	 *
	 * @author Ismail Satilmis <ismaiil_0234@hotmail.com>
	 * @var int 
	 *
	 */
	protected $requestEndTime;

	/**
	 *
	 * İlk başlama zamanı
	 *
	 * @author Ismail Satilmis <ismaiil_0234@hotmail.com>
	 * @var int 
	 *
	 */
	protected $startedTime;

	/**
	 *
	 * Sipariş listesinden kaç adet sipariş getirileceği.
	 *
	 * @author Ismail Satilmis <ismaiil_0234@hotmail.com>
	 * @var bool 
	 *
	 */
	protected $orderMaxResult = 50;

	/**
	 *
	 * OrderService sınıfının bir örneği
	 *
	 * @author Ismail Satilmis <ismaiil_0234@hotmail.com>
	 * @var class 
	 *
	 */
	protected $order;

	/**
	 *
	 * N11 sipariş ayarları tutulur.
	 *
	 * @author Ismail Satilmis <ismaiil_0234@hotmail.com>
	 * @var object $setting
	 *
	 */
	protected $setting;

	/**
	 *
	 * Son sipariş id numarası
	 *
	 * @author Ismail Satilmis <ismaiil_0234@hotmail.com>
	 * @var int 
	 *
	 */
	protected $lastOrderId;

	/**
	 *
	 * Mevcut geçerli sayfa numarası
	 *
	 * @author Ismail Satilmis <ismaiil_0234@hotmail.com>
	 * @var int 
	 *
	 */
	protected $pageId;

	/**
	 *
	 * WebHookService Sınıfını Başlatma
	 *
	 * @author Ismail Satilmis <ismaiil_0234@hotmail.com>
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
	 * N11 Üzerindeki Yeni Siparişleri Tüketme
	 *
	 * @author Ismail Satilmis <ismaiil_0234@hotmail.com>
	 * @param class $client
	 * @param function $work
	 *
	 */
	public function orderConsume($client, $work)
	{	

		while (true) 
		{
			
			if (time() >= $this->requestEndTime) {
				$this->requestEndTime = time() + $this->requestTime;
				$this->setting        = $this->selectSettings();

				foreach ($this->getPagination($client) as $pageId) {

					foreach ($this->getOrderList($client, $pageId) as $order) {

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
						$this->updateOrder($order->id);
					}

					$this->updatePageId($pageId);
				}

			}

			sleep(1);
		}

	}

	/**
	 *
	 * Geçerli taranacak sayfaların listesini döndürür.
	 *
	 * @author Ismail Satilmis <ismaiil_0234@hotmail.com>
	 * @param int 	 $pageId
	 * @param object $orders
	 * @param object $orderList
	 * @return array 
	 *
	 */
	protected function getPageData($pageId, $orders, $orderList)
	{	

		// max sayfa eklenecek 1'den 5'e kadar gibi
		$limit = $orders->pagingData->pageCount - 1 - $pageId;
		if ($limit <= 0) {
			$limit = 0;
		}

		$limit += $pageId;

		$pages = array();
		for ($i = $pageId; $i <= $limit; $i++) { 
			array_push($pages, $i);
		}
		
		return $pages;
	}

	/**
	 *
	 * N11 Siparişlerinin gerçek sayfalanma numarasını alır.
	 *
	 * @author Ismail Satilmis <ismaiil_0234@hotmail.com>
	 * @param object $orders
	 * @param int $pageId
	 * @param int $productId
	 * @return array 
	 *
	 */
	protected function getRealPageId($client, $orders, $pageId, $productId)
	{

		/* seçilen sayfa içinde var ise */
		$list = $this->getOrderFormat($orders);
		if (in_array($productId, $list)) {
			return $this->getPageData($pageId, $orders, $list);
		}

		/* seçilen sayfanın içindeki iki değer içinde */
		$maxOrder = count($list) - 1;
		for ($i = 0; $i < $maxOrder; $i++) { 
			if ($productId > $list[$i] && $productId < $list[$i + 1]) {
				return $this->getPageData($pageId, $orders, $list);
			}
		}

		$first = current($list);
		$last  = end($list);

		/* ürün id 2 sayfa arasında ise (20 ve 21 arası gibi) */
		if ($this->lastOrderId != null && $productId > $this->lastOrderId && $productId < $first) {
			return $this->getPageData($pageId, $orders, $list);
		}

		/* seçilen sayfanın ilk değeri yok ise veya ürün idsi son değerden küçük ise önceki sayfayı tara */
		if (!$first || $productId < $first) {
			$pageId--;
		}

		/* seçilen sayfanın son değeri var ve ürün idsi son değerden büyük ise sonraki sayfayı tara */
		if ($last && $productId > $last){
			$pageId++;
		}

		$this->lastOrderId = $last;

		/* sayfa 0'dan küçük ise */
		if ($pageId < 0) {
			return $this->getPageData(0, $orders, $list);
		}

		/* seçilen sayfanın ilk değeri var ise ve şuanki sayfa max sayfadan büyük ve eşit ise */
		if ($first && $pageId >= $orders->pagingData->pageCount) {
			return $this->getPageData($orders->pagingData->pageCount <= 0 ? 0 : $orders->pagingData->pageCount - 1, $orders, $list);
		}

		return $this->getRealPageId($client, $this->order->orderList($client, $this->getOrderSettings($pageId)), $pageId, $this->setting->lastOrderId);
	}

	/**
	 *
	 * Siparişleri sadece id olarak bir diziye atar
	 *
	 * @author Ismail Satilmis <ismaiil_0234@hotmail.com>
	 * @param array $orders
	 * @return array 
	 *
	 */
	protected function getOrderFormat($orders)
	{

		if (!isset($orders->orderList->order)) {
			return array();
		}

		$orderList = array($orders->orderList->order);
		if (is_array($orders->orderList->order)) {
			$orderList = $orders->orderList->order;
		}

		return array_column($orderList , 'id', NULL);
	}

	/**
	 *
	 * N11 Üzerindeki siparişlerin kriterlere göre getirilmesi
	 *
	 * @author Ismail Satilmis <ismaiil_0234@hotmail.com>
	 * @param Class $client 
	 * @return array 
	 *
	 */
	protected function getOrderList($client, $pageId)
	{

		$orders = $this->order->orderList($client, $this->getOrderSettings($pageId));
		if (!isset($orders->result)) {
			throw new N11Exception("Sipariş Listesi Alınamadı.");
		}

		if ($orders->result->status != "success") {
			throw new N11Exception("Sipariş Listesi Alınamadı. Hata => " . $orders->result->errorMessage);
		}

		$orderList = $orders->orderList->order;
		if (is_object($orders->orderList->order)) {
			$orderList = array($orders->orderList->order);
		}

		return $orderList;
	}

	/**
	 *
	 * N11 Siparişlerinin alınacağı sayfaların listesi
	 *
	 * @author Ismail Satilmis <ismaiil_0234@hotmail.com>
	 * @param Class $client
	 * @return array 
	 *
	 */
	protected function getPagination($client)
	{

		$this->lastOrderId = null;
		return $this->getRealPageId($client, $this->order->orderList($client, $this->getOrderSettings($this->setting->pageId)), $this->setting->pageId, $this->setting->lastOrderId);

	}

	/**
	 *
	 * Sipariş listesi kriterleri 
	 *
	 * @author Ismail Satilmis <ismaiil_0234@hotmail.com>
	 * @param int $pageId
	 * @return array
	 *
	 */
	protected function getOrderSettings($pageId)
	{	

		return array(
			'period'     => array(),
			'pagingData' => array(
				'currentPage' => $pageId,
				'pageSize'    => $this->orderMaxResult
			)
		);

	}

	/**
	 *
	 * N11 Siparişlerinin en kadar hızlı tüketileceği.
	 *
	 * @author Ismail Satilmis <ismaiil_0234@hotmail.com>
	 * @param Class $client
	 * @param string $mode  
	 *
	 */
	public function setRequestMode($client, $mode)
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
	 * N11 Sipariş listesinde kaç adet siparişin getirileceği
	 *
	 * @author Ismail Satilmis <ismaiil_0234@hotmail.com>
	 * @param Class $client
	 * @param string $mode 
	 *
	 */
	public function setResultMode($client, $mode)
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

}
