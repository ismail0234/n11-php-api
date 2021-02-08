[![Latest Stable Version](https://poser.pugx.org/ismail0234/n11-php-api/v/stable)](https://packagist.org/packages/ismail0234/n11-php-api)
[![Total Downloads](https://poser.pugx.org/ismail0234/n11-php-api/downloads)](https://packagist.org/packages/ismail0234/n11-php-api)
[![License](https://poser.pugx.org/ismail0234/n11-php-api/license)](https://packagist.org/packages/ismail0234/n11-php-api)

# N11 PHP API

Bu API n11 için yazılmıştır. N11 için yazılmış olan gelişmiş bir php entegrasyon API'si. Ekstra olarak n11 üzerinde mağazanıza gelen siparişleri websitenize aktaracak bir fonksiyonda mevcuttur.

## Bağış Yapın

Yaptığım işlerden memnun iseniz, daha iyi ve daha çok iş çıkartmam için beni destekleyebilirsiniz;

## Discord

Discord sunucumuza katılmak isterseniz hepinizi bekleriz; https://discord.gg/botbenson

## Katkı Çağrısı (Katkıda Bulunanlar)

Çok fazla vaktim olmadığından N11'in bütün API fonksiyonları tamamlanmamıştır. Eksik fonksiyonları isterseniz tamamlayarak **pull request** gönderebilirsiniz veya istediğiniz fonksiyonun eklenmesi için **issue** açabilirsiniz. 

<!-- ALL-CONTRIBUTORS-LIST:START - Do not remove or modify this section -->
<!-- prettier-ignore-start -->
<!-- markdownlint-disable -->

<!-- markdownlint-enable -->
<!-- prettier-ignore-end -->
<!-- ALL-CONTRIBUTORS-LIST:END -->

### Change Log
- See [ChangeLog](https://github.com/ismail0234/n11-php-api/blob/master/CHANGELOG.md)

### License
- See [ChangeLog](https://github.com/ismail0234/n11-php-api/blob/master/LICENSE)

## Hızlı Bakış
 * [Kurulum](#kurulum)
 * [Kullanım](#kullanım)
 * [Şehir Servisleri (CityService)](#şehir-servisleri-cityservice)
 * [Kargo Şirketi Servisleri (ShipmentCompanyService)](#kargo-şirketi-servisleri-shipmentcompanyservice)
 * [Kategori Servisi (CategoryService)](#kategori-servisi-categoryservice)
 * [Ürün Servisi (ProductService)](#ürün-servisi-productservice)
 * [Ürün Satış Durumu Servisi (ProductSellingService)](#ürün-satış-durumu-servisi-productsellingservice)
 * [Ürün Stok Servisi (ProductStockService)](#ürün-stok-servisi-productstockservice)
 * [Sipariş Servisi (Order Service)](#sipariş-servisi-order-service)
 * [N11 Sipariş Bildirimi WebHook (N11 Order WebHook Beta)](#n11-sipariş-bildirimi-webhook-n11-order-webhook-beta)

## Kurulum

Kurulum için composer kullanmanız gerekmektedir. Composer'a sahip değilseniz windows için [Buradan](https://getcomposer.org/) indirebilirsiniz.

```php

composer require ismail0234/n11-php-api

```

## Kullanım

```php

use IS\PazarYeri\N11\N11Client;

include "vendor/autoload.php";

$client = new N11Client();
$client->setApiKey('xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx');
$client->setApiPassword('xxxxxxxxxxxxxxxx');
```

### Şehir Servisleri (CityService)

```php

/**
 *
 * @description N11 Üzerindeki bütün şehirlerin listesini döndürür.
 *
 */
$client->city->getCities();

/**
 *
 * @description Şehir hakkında birkaç bilgi döndürür.
 * @param int Şehir Id - Zorunlu
 *
 */
$client->city->getCity(34);

/**
 *
 * @description Plaka kodu verilen şehre ait ilçelerinin listelenmesi için kullanılır.
 * @param int Şehir Id - Zorunlu
 *
 */
$client->city->getDistrict(34);

/**
 *
 * @description İlçe kodu verilen semt/mahallelerin listelenmesi için kullanılır.
 * @param int İlçe Id - Zorunlu
 *
 */
$client->city->getNeighborhoods(22569);
```

### Kargo Şirketi Servisleri (ShipmentCompanyService)

```php

/**
 *
 * @description N11 Üzerinde tanımlı olan tüm kargo şirketlerini listeler
 *
 */
$client->shipmentcompany->getShipmentCompanies();
```

### Teslimat Şablonu Servisi (ShipmentService)

```php

/**
 *
 * @description Oluşturulan teslimat şablonu bilgilerini listelemek için kullanılan metoddur.
 *
 */
$client->shipment->getShipmentTemplateList();

/**
 *
 * @description Teslimat şablon ismi ile aratılan şablonun bilgilerini döndürür.
 * @param string Şablon Adı - Zorunlu
 *
 */
$client->shipment->getShipmentTemplate('Ücretsiz Kargo');
```

### Kategori Servisi (CategoryService)

```php

/**
 *
 * @description N11 üzerinde tanımlanmış tüm üst seviye kategorileri döndürür.
 *
 */
$client->category->getTopLevelCategories();

/**
 *
 * @description İstenilen kategori, üst seviye kategori veya diğer seviye kategorilerden olabilir, bu kategorilere ait olan özelliklerin
 *				ve bu özelliklere ait değerlerin listelenmesi için kullanılan metottur.
 * @param int Kategori Id - Zorunlu
 * @param array Sayfalama - İsteğe Bağlı
 *
 */
$client->category->getCategoryAttributes(1002841, array('currentPage' => 1, 'pageSize' => 20));

/**
 *
 * @description İstenilen kategori, üst seviye kategori veya diğer seviye kategorilerden olabilir, 
 * 				bu kategorilere ait olan özelliklerin listelenmesi için kullanılan metoddur.
 * @param int Kategori Id - Zorunlu
 *
 */
$client->category->getCategoryAttributesId(1002841);

/**
 *
 * @description Özelliğe sistemimizde verilen id bilgisini (category.attributeList.attribute.id) girdi vererek,
 *				o özelliğe ait değerleri listeler.
 * @param int Kategori Id - Zorunlu
 * @param array Sayfalama - İsteğe Bağlı
 *
 */
$client->category->getCategoryAttributeValue(354080997, array('currentPage' => 0, 'pageSize' => 20));

/**
 *
 * @description Kodu verilen kategorinin birinci seviye üst kategorilerine ulaşmak için bu metot kullanılmalıdır. İkinci seviye üst 
 *				kategorilere ulaşmak için (Örn. “Deri ayakkabı -> Ayakkabı -> Giysi” kategori ağacında “Giysi “ bilgisi) 
 *				birinci seviye üst kategorinin (Örn. Ayakkabı) kodu verilerek tekrar servis çağırılmalıdır. 
 *
 */
$client->category->getParentCategory(1000717);

/**
 *
 * @description Kodu verilen kategorinin birinci seviye alt kategorilerine ulaşmak için bu metot kullanılmalıdır. İkinci seviye alt 
 *				kategorilere ulaşmak için (Örn. “Giysi -> Ayakkabı -> Deri ayakkabı” kategori ağacında “Deri ayakkabı” bilgisi) 
 *				birinci Seviye alt kategorinin (Örn. Ayakkabı) kodu verilerek tekrar servis çağırılmalıdır. 
 *
 */
$client->category->getSubCategories(1002841);
```

### Ürün Servisi (ProductService)

```php

/**
 *
 * @description N11 ürün ID sini kullanarak sistemde kayıtlı olan ürünün bilgilerini getirir.
 *
 */
$client->product->getProductByProductId(359620750);

/**
 *
 * @description Mağaza ürün kodunu kullanarak sistemde kayıtlı olan ürünün bilgilerini getirir.
 *
 */
$client->product->getProductBySellerCode('IS-20014');

/**
 *
 * @description N11 Üzerindeki ürünleri listelemek için kullanılır.
 * @param array Sayfalama - İsteğe Bağlı 
 *
 */
$client->product->getProductList(array('currentPage' => 0, 'pageSize' => 20));

/**
 *
 * @description Mağazaya yeni ürün eklemek için kullanılır.
 * @param array eklenecek ürün bilgileri - Zorunlu
 *
 */
$client->product->SaveProduct(
					array(
						'productSellerCode' => 'TF23094823',
						'title' => 'Mavi Toparlayıcı Efekt Skinny Pantolon',
						'subtitle' => 'Curabitur blandit consequat libero, ac suscipit leo luctusrfggfgf',
						'description' => 'Curabitur blandit consequat libero, ac suscipit leo luctus eget. Etiam condimentum augue at quam sagittis bibendum. Quisque vitae malesuada urna. Proi',
						'domestic' => 'false',
						'category' => array(
							'id' => '1002201'
						),
						'specialProductInfoList' => array(
							'specialProductInfo' => array(
								'key' => '?',
								'value' => '?',
							)
						),
						'price' => '185.00',
						'currencyType' => '1',
						'images' => array(
							'image' => array(
								array(
									'url' => 'https://contents.mediadecathlon.com/p1058366/k20d731c11ef86aad6039daa20fb66dc3/1058366_default.jpg',
									'order' => '1',
								),
								array(
									'url' => 'https://contents.mediadecathlon.com/p1058366/k20d731c11ef86aad6039daa20fb66dc3/1058366_default.jpg',
									'order' => '2',
								),
								array(
									'url' => 'https://contents.mediadecathlon.com/p1058366/k20d731c11ef86aad6039daa20fb66dc3/1058366_default.jpg',
									'order' => '3',
								),
								array(
									'url' => 'https://contents.mediadecathlon.com/p1058366/k20d731c11ef86aad6039daa20fb66dc3/1058366_default.jpg',
									'order' => '4',
								),
								array(
									'url' => 'https://contents.mediadecathlon.com/p1058366/k20d731c11ef86aad6039daa20fb66dc3/1058366_default.jpg',
									'order' => '5',
								),
								array(
									'url' => 'https://contents.mediadecathlon.com/p1058366/k20d731c11ef86aad6039daa20fb66dc3/1058366_default.jpg',
									'order' => '6',
								)
							)
						),
						'approvalStatus' => '1',
						'attribute' => array(),
						'saleStartDate' => '',
						'saleEndDate' => '',
						'productionDate' => '',
						'expirationDate' => '',
						'productCondition' => 1,
						'preparingDay' => 3,
						'discount' => array(
							'startDate' => '',
							'endDate' => '',
							'type' => '',
							'value' => '',
						),
						'shipmentTemplate' => 'termos',
						'stockItems' => array(
							'stockItem' => array(
								array(
									'bundle' => 'false',
									'mpn' => '112',
									'gtin' => '0190198066473',
									'oem' => '',
									'quantity' => '855',
									'n11CatalogId' => '',
									'sellerStockCode' => '112',
									'optionPrice' => '185.00',
									'attributes' => array(
										'attribute' => array(
											array(
												'name' => 'Sezon',
												'value' => '2013 Sonbahar-Kış'
											),
											array(
												'name' => 'Cinsiyet',
												'value' => 'Erkek',
											),
											array(
												'name' => 'Beden',
												'value' => '145',
											),
											array(
												'name' => 'Desen',
												'value' => 'Nakışlı',
											),
											array(
												'name' => 'Ürün_Detayı',
												'value' => 'Kapüşonlu',
											),
											array(
												'name' => 'İçerik',
												'value' => 'Brode,Brokar,İnterlok',
											),
											array(
												'name' => 'Marka',
												'value' => 'Esteem',
											),
											array(
												'name' => 'Renk',
												'value' => 'Gri',
											)
										)
									)
								)
							)
						),
						'unitInfo' => array(
							'unitType' => '',
							'unitWeight' => ''
						),
						'maxPurchaseQuantity' => '122',
						'groupAttribute' => '',
						'groupItemCode' => '',
						'itemName' => ''
					)
				);

/**
 *
 * @description Kayıtlı olan bir ürünü N11 Id si kullanarak silmek için kullanılır.
 * @param int N11 Ürün Id - Zorunlu
 *
 */
$client->product->deleteProductById(1234567890);

/**
 *
 * @description Kayıtlı olan bir ürünü mağaza ürün kodu kullanılarak silmek için kullanılır.
 * @param string N11 Ürünün Mağazadaki Ürün Kodu - Zorunlu
 *
 */
$client->product->deleteProductBySellerCode(1234567890);
```

### Ürün Satış Durumu Servisi (ProductSellingService)

```php

/**
 *
 * @description Satışta olan ürünün n11 ürün ID si kullanılarak satışa kapatılması için kullanılır.
 * @param int N11 Ürün Id - Zorunlu
 *
 */
$client->selling->stopSellingProductByProductId(1234567890);	

/**
 *
 * @description Satışta olmayan bir ürünün N11 ürün ID si kullanılarak satışa başlanması için kullanılır.  
 * @param string N11 Ürün Mağaza Id - Zorunlu
 *
 */
$client->selling->startSellingProductBySellerCode('IS-20014');

/**
 *
 * @description Satışta olmayan bir ürünün N11 ürün ID si kullanılarak satışa başlanması için kullanılır.
 * @param int N11 Ürün Id - Zorunlu
 *
 */
$client->selling->startSellingProductByProductId(1234567890);

/**
 *
 * @description Satışta olan ürünün mağaza ürün kodu kullanılarak satışının durdurulması için kullanılır.
 * @param string N11 Ürün Mağaza Id - Zorunlu
 *
 */
$client->selling->stopSellingProductBySellerCode('IS-20014');
```

### Ürün Stok Servisi (ProductStockService)

```php

/**
 *
 * @description Sistemde kayıtlı olan ürünün N11 ürün ID si ile ürün stok bilgilerini getiren metottur. 
 * 				Cevap içinde stok durumunun “version” bilgisi de vardır, ürün stoklarında değişme olduysa 
 *				bu versiyon bilgisi artacaktır, çağrı yapan taraf versiyon bilgisini kontrol ederek N11 e 
 *				verilen stok bilgilerinde değişim olup olmadığını anlayabilir.
 * @param int N11 Ürün Id - Zorunlu
 *
 */
$client->stock->getProductStockByProductId(1234567890);
```

### Sipariş Servisi (Order Service)

```php

/**
 *
 * @description Bu metot sipariş ile ilgili özet bilgileri listelemek için kullanılır.
 * @note İsteğe bağlı olarak dizideki alanların istenilen bölümleri eklenmeyebilir veya dizi hiç gönderilmeyebilir.
 * @param array Arama Sorgusu - İsteğe Bağlı
 *
 */
$client->order->orderList(
	array(
		// Ürün ID Numarası
		'productId'         => 1234567890,
		// Sipariş Durumu   => New, Approved, Rejected, Shipped, Delivered, Completed, Claimed, LATE_SHIPMENT
		'status'            => 'New',
		// Alıcı Adı 
		'buyerName'         => 'ismail',
		// Sipariş Numarası
		'orderNumber'       => 1234567890,
		// Ürün Mağaza Kodu
		'productSellerCode' => 'IS-20014',
		// Teslim alacak kişinin adı
		'recipient'         => 'ismail',
		// Sipariş oluşturma tarihi başlangıç
		'period'            => array(
			// Başlangıç Tarihi => d/m/Y H:i:s
			'startDate' => '28/06/2019',
			// Bitiş Tarihi => d/m/Y H:i:s
			'endDate'   => '01/07/2019'
		),
		// Güncellenen Siparişleri Listeler
		'sortForUpdateDate' => false,
		// Sayfalama
		'pagingData' => array(
			// Şuanki Sayfa
			'currentPage' => 0,
			// Gösterilecek nesne
			'pageSize'    => 20
		)

	)
);

/**
 *
 * @description Sipariş N11 ID bilgisi kullanarak sipariş detaylarını almak için kullanılır, 
 *				sipariş N11 ID bilgisine orderList metotlarıyla ulaşılabilir.
 * @param int Sipariş ID Numarası - Zorunlu
 *
 */
$client->order->orderDetail(123456789);
```

### N11 Sipariş Bildirimi WebHook (N11 Order WebHook) BETA

N11 Tarafından sipariş bildirimleri için bir webhook verilmediği için bu işlemi yapmak isteyenler kişiler için yazılmış olan bir webhook dur. Webhook'u kullanabilmeniz için sunucunuzda **sqlite** pdo driver kurulu olması gerekmektedir.

**Not:** Oluşturacağınız bu dosyayı linux tarafında arkaplanda sürekli çalışır halde kalması gerekmektedir. Bunu yapmak için **tmux** veya **servis yazarak** kullanabilirsiniz. **Cronjob ile kullanmayınız!**

_**Bu Webhook'un henüz beta aşamasında olduğunu unutmayın!**_



```php

include "vendor/autoload.php";

use IS\PazarYeri\N11\N11Client;

$client = new N11Client();
$client->setApiKey('xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx');
$client->setApiPassword('xxxxxxxxxxxxxxxx');

/**
 *
 * @description Webhook istek hızı
 * @param string 
 * 	  'slow'   => 300 saniye,
 *	  'medium' => 180 saniye (default/taviye edilen),
 * 	  'fast'   => 60 saniye
 * 	  'vfast'  => 30 saniye
 * 	   
 */
$client->webhook->setRequestMode('medium');

/**
 *
 * @description N11 sonuçlarında kaç siparişin getirileceği
 * @param string 
 * 	  'vmax'     => 100 adet,
 *	  'max'      => 75 adet,
 * 	  'medium'   => 50 adet (default/taviye edilen),
 * 	  'min'      => 30 adet
 * 	   
 */
$client->webhook->setResultMode('medium');

/**
 *
 * @description Sipariş bildirimlerinde geçmiş siparişler kontrol edilsinmi?
 * @param bool  
 * 	  true     => Evet (default/Tavsiye edilen),
 *	  false    => Hayır,
 * 	   
 */
// Uyarı! Bu fonksiyon versiyon 1.1.0'dan itibaren kaldırılmıştır.
// $client->webhook->setOldConsumeMode(true);

/* Anonymous function ile siparişleri almak */
$client->webhook->orderConsume(function($order){
	
	echo "Sipariş Bilgileri";
	echo "<pre>";
	print_r($order);
	echo "</pre>";
	
});

/* Class ile siparişleri almak */

Class N11Orders
{
	
	public function consume($order)
	{

		echo "Sipariş Bilgileri";
		echo "<pre>";
		print_r($order);
		echo "</pre>";	

	}

}

$client->webhook->orderConsume(array(new N11Orders(), 'consume'));

```
