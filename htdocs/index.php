<?php
define("APP_MODE", get_cfg_var('lianjia.environment'));
APP_MODE == 'test' AND opcache_reset();
$config = require __DIR__ . "/../protected/config/" . APP_MODE . ".php";
require_once __DIR__ . '/../protected/yii.php';
Yii::createWebApplication($config)->run();
