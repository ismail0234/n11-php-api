[![Latest Stable Version](https://poser.pugx.org/ismail0234/n11-php-api/v/stable)](https://packagist.org/packages/ismail0234/n11-php-api)
[![Total Downloads](https://poser.pugx.org/ismail0234/n11-php-api/downloads)](https://packagist.org/packages/ismail0234/n11-php-api)
[![License](https://poser.pugx.org/ismail0234/n11-php-api/license)](https://packagist.org/packages/ismail0234/n11-php-api)

# N11 PHP Api

N11 için yazılmış olan gelişmiş bir php apisi.

### Change Log
- See [ChangeLog](https://github.com/ismail0234/n11-php-api/blob/master/CHANGELOG.md)

### License
- See [ChangeLog](https://github.com/ismail0234/n11-php-api/blob/master/LICENSE)


## Kurulum

Kurulum için composer kullanmanız gerekmektedir. Composer'a sahip değilseniz windows için [Buradan](https://getcomposer.org/) indirebilirsiniz.

```php

composer require ismail0234/n11-php-api

```

## Kullanım

```php

include "vendor/autoload.php";

use IS\PazarYeri\N11\N11Client;

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
 * @param int Şehir Id
 *
 */
$client->city->getCity(34);

/**
 *
 * @description Plaka kodu verilen şehre ait ilçelerinin listelenmesi için kullanılır.
 * @param int Şehir Id
 *
 */
$client->city->getDistrict(34);

/**
 *
 * @description İlçe kodu verilen semt/mahallelerin listelenmesi için kullanılır.
 * @param int İlçe Id
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
 * @param string Şablon Adı
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
 * @param int Kategori Id
 * @param array Sayfalama - İsteğe Bağlı
 *
 */
$client->category->getCategoryAttributes(1002841, array('currentPage' => 1, 'pageSize' => 20));

/**
 *
 * @description İstenilen kategori, üst seviye kategori veya diğer seviye kategorilerden olabilir, 
 * 				bu kategorilere ait olan özelliklerin listelenmesi için kullanılan metoddur.
 * @param int Kategori Id
 *
 */
$client->category->getCategoryAttributesId(1002841);

/**
 *
 * @description Özelliğe sistemimizde verilen id bilgisini (category.attributeList.attribute.id) girdi vererek,
 *				o özelliğe ait değerleri listeler.
 * @param int Kategori Id
 * @param array Sayfalama - İsteğe Bağlı
 *
 */
$client->category->getCategoryAttributeValue(354080997, array('currentPage' => 0, 'pageSize' => 20);

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
$client->product->getProductList(array('currentPage' => 0, 'pageSize' => 20);
```