<?php

  use IS\PazarYeri\N11\N11Client;

  include "vendor/autoload.php";

  $client = new N11Client();
  $client->setApiKey('xxxxxxxxx-xxxxxxxxx-xxxxxxxxx-xxxxxxxxx-xxxxxxxxx');
  $client->setApiPassword('xxxxxxxxx');

  $category = $client->category->getCategoryAttributes("1000038", array('currentPage' => 0, 'pageSize' => 100));
