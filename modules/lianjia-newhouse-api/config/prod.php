<?php

return array(
    'name' => 'lianjia-api',
    'controllerPath' => __DIR__ . '/../controllers',
    
    'params' => array(
        'static_file_host'   => 'http://staticfile.lianjia.com',
        'dynamic_image_host' => 'http://image2.lianjia.com',
    ),

    // autoloading model and component classes
    'import' => array(
        'module.common.*',
        'module.controllers.*',
        'module.components.*',
        'application.extensions.search.*',
    ),
    // application components
    'components' => array(

        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'FileLogRoute',
                    'levels' => 'info, error, warning, trace',
                    'categories' => 'application.*, system.*, exception.*, bigdata.*',
                    'except' => 'system.CModule',
                    'logPath' => getenv("HOME") . "/var/log",
                    'logFile' => "moapi.log",
                )
            )
        ),

        'fe' => array(
            'class' => 'FrontEnd',
            'feroot' => 'http://cdn.lianjia.com/',
            'imgroot' => 'http://image.lianjia.com/',
            'webroot' => "http://{$_SERVER["HTTP_HOST"]}/",
            'version' => date("Ymd"),
        ),
        'solr' => array(
            'class' => 'Solr',
            'host' => '172.27.4.141',
            'port' => '80',
        ),
        'urlManager' => array(
            'urlFormat' => 'path',
            'showScriptName'=>false,
            'rules' => array(
                '/newhouse/opentip'  => '/maincenter/opentip',//主会场配置
                '/newhouse/brokernewers' => '/broker/brokernewers',
                '/newhouse/verifycoupon'  => '/verifycoupon/verifycoupon',
                '/newhouse/verifyrecords'  => '/verifycoupon/verifyrecords',
                '/newhouse/developerlogin'  => '/verifycoupon/developerlogin',
                '/newhouse/developerlogout'  => '/verifycoupon/developerlogout',
                '/newhouse/checkuserinfo'  => '/verifycoupon/checkuserinfo',
                '/newhouse/pushuserphoneno'  => '/broker/pushuserphoneno',
                '/newhouse/activate'  => '/broker/activate',
                '/newhouse/userphoneno'  => '/broker/userphoneno',
                '/newhouse/brokerlogin'  => '/broker/brokerlogin',
                '/newhouse/brokerlogout' => '/broker/brokerlogout',
                '/newhouse/developerchecklogin'  => '/verifycoupon/developerchecklogin',
                '/newhouse/brokerchecklogin'  => '/broker/brokerchecklogin',
                '/newhouse/favcoupons'  => '/user/favcoupons',
                '/newhouse/favcouponverify'  => '/user/favcouponverify',
                '/newhouse/favcoupondetail'  => '/user/favcoupondetail',
                '/newhouse/favlotterylist'  => '/user/favlotterylist',
                '/newhouse/actlist'  => '/maincenter/actlist',
                '/newhouse/brandlist' => '/maincenter/brandlist',
                '/newhouse/getaddress' => '/didi/getaddress',
                '/newhouse/checkuserstatus' => '/didi/checkuserstatus',
                '/newhouse/requestorder' => '/didi/requestorder',
                '/newhouse/getorderdetail' => '/didi/getorderdetail',
                '/newhouse/gethistory' => '/didi/gethistory',
                '/newhouse/cancelorder' => '/didi/cancelorder',
                '/newhouse/brandinfo'  => '/maincenter/brandinfo',
                '/newhouse/reserve' =>'/coupons/reserve',//预定
                '/newhouse/lotteryinfo'=>'/coupons/lotteryinfo',//开奖信息
                '/newhouse/generateverifycode' =>'/coupons/generateverifycode',//
                '/newhouse/checkverifycode'=>'/coupons/checkverifycode',//
                '/newhouse/couponinfo' =>'/coupons/couponinfo',//
                '/newhouse/resblockact' =>'/maincenter/resblockact',
                '/newhouse/personalinfo' =>'/coupons/personalinfo',//
                '/newhouse/order' =>'/coupons/order',//
                '/newhouse/didicallback' => '/didi/didicallback',
                '/newhouse/condition' => '/module/getcondition',
                '/newhouse/zhuanti' => '/module/getzhuanti',
                '/newhouse/articlelist' => '/module/article'
            ),
        )
    ),
);
