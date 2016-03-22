<?php

require __DIR__ . "/../protected/yii.php";

class Application extends CWebApplication {

    public function processRequest() {
        $currentName = $_SERVER["HTTP_HOST"];
        $rowSeoRobots = SeoRobots::model()->findAll(
            array( 'order' => '`weight` desc', )
        );
        foreach ($rowSeoRobots as $doc) {
            $tmp = $doc->host_name;
            if(UrlHelper::wildcharMatch($tmp, $currentName)){
                header("Content-Type: text/plain");
                echo $doc->text;
                return;
            }
        }
        throw new CHttpException(404);
    }
}

Yii::createApplication("Application")->run();
