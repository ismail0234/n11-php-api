<?php

namespace IS\PazarYeri\N11\Helper;

Class Database
{

	/**
	 *
	 * @description SQLite Veritabanı Bağlantısı
	 *
	 */
	protected $db = null;

	/**
	 *
	 * @description SQLite Veritabanı Sınıfı Oluşturucu
	 * @param string 
	 *
	 */
	public function __construct()
	{

		$this->checkSQLiteAndPDODriver();

		$SQLitePath =  __DIR__ . '/../Data/';
		if (!file_exists($SQLitePath)) {
			mkdir($SQLitePath, 0777);
		}

		$this->db = new \PDO("sqlite:" . $SQLitePath . 'n11.sqlite');
	    $this->db->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
		$this->checkAndCreateTables();


	}

	/**
	 *
	 * @description SQLite ve PDO sürücülerini kontrol etme
	 *
	 */
	protected function checkSQLiteAndPDODriver()
	{

		$response = \PDO::getAvailableDrivers();
		if (count($response) <= 0 || empty($response)) {
			throw new N11Exception("Sunucunuzda PDO Aktif Olmalıdır.");
		}

		if (!in_array('sqlite', $response)) {
			throw new N11Exception("Sunucunuzda SQLite PDO Sürücüsü Aktif Olmalıdır.");
		}

	}

	/**
	 *
	 * @description SQLite Veritabanı tablolarını kontrol etme ve oluşturma
	 *
	 */
	public function checkAndCreateTables()
	{

		$query = 'CREATE TABLE IF NOT EXISTS `orders` ( 
				`orderid` INTEGER NOT NULL , 
				`status` TINYINT NOT NULL DEFAULT \'0\' , 
				`date` INTEGER NOT NULL , 
				PRIMARY KEY (`orderid`)
			);
		';
		$this->db->query($query);

	}

	/**
	 *
	 * @description Siparişleri SQLite üzerinde tutma
	 *
	 */
	public function addOrder($orderId)
	{

		$prepare = $this->db->prepare('INSERT INTO `orders` (orderid, status, date) VALUES(?, ?, ?)');
		$prepare->execute(array($orderId, 0 , time()));
		return $this->db->lastInsertId();

	}

	/**
	 *
	 * @description Siparişleri SQLite üzerinde kontrol etme
	 *
	 */
	public function selectOrder($orderId)
	{

		$prepare = $this->db->prepare('SELECT * FROM `orders` WHERE orderid = ?');
		$prepare->execute(array($orderId));
		return $prepare->fetch(\PDO::FETCH_OBJ);
	}

	/**
	 *
	 * @description Siparişleri SQLite üzerinde tamamlandı olarak işaretleme
	 *
	 */
	public function finishOrder($orderId)
	{

		$prepare = $this->db->prepare('UPDATE `orders` SET status = ? WHERE orderid = ?');
		return $prepare->execute(array(1 , $orderId));
	}


}