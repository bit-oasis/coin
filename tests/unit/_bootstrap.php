<?php
// Here you can initialize variables that will be available to your tests

use Codeception\Util\Autoload;

require_once __DIR__ . '/../../vendor/autoload.php';

date_default_timezone_set('UTC');
$_SERVER['REMOTE_ADDR'] = '127.0.0.1';

Autoload::addNamespace('', __DIR__);
