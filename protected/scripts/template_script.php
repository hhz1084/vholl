<?php
error_reporting(E_ERROR);
ini_set('memory_limit', '2048M');
set_time_limit(0);
(get_cfg_var('lianjia.environment') == "dev") && define("YII_DEBUG", true);
require __DIR__ . "/../yii.php";

class Application extends CConsoleApplication {
    public function processRequest() {

        
    }            
}

Yii::createApplication("Application")->run();
    
