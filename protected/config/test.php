<?php

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENABLE_ERROR_HANDLER') or define('YII_ENABLE_ERROR_HANDLER',false);

return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'lianjia-framework',
    'runtimePath' => getenv("HOME") . DIRECTORY_SEPARATOR . 'var',

    'modules' => array(
        'lianjia-newhouse-api' => array(
            'regex' => '(172\.30\.16\.[0-9]+?)|(testnewhapi\.lianjia\.com)|(newhouseapi\.lianjia\.com)(?::\d+)?',
            'directory' => 'lianjia-newhouse-api'
        ),
    ),

    // autoloading model and component classes
    'import' => array(
        'application.components.*',
        'application.tables.newhouse.*',
        'application.tables.hdic.*',
        'application.utils.*',
        'application.data.Constants',
    ),
    // application components
    'components' => array(
        /*'db-newhouse' => array(
            'class' => 'CDbConnection',
            'connectionString' => 'mysql:host=10.10.6.30;port=6701;dbname=lianjia_newhouse',
            'emulatePrepare' => true,
            'username' => 'newh',
            'password' => 'bbcec310261e4345',
            'charset' => 'utf8',
            'enableParamLogging' => true,
        ),*/
        'db-newhouse' => array(
            'class' => 'CDbConnection',
            'connectionString' => 'mysql:host=172.30.16.235;port=3306;dbname=lianjia_newhouse',
            'emulatePrepare' => true,
            'username' => 'newhouse',
            'password' => 'newhouse',
            'charset' => 'utf8',
            'enableParamLogging' => true,
        ),
        'db-hdic' => array(
            'class' => 'CDbConnection',
            'connectionString' => 'mysql:host=172.16.6.183:6521;dbname=hdic',
            'emulatePrepare' => true,
            'username' => 'phpmyadmin',
            'password' => 'w2e#-s1f!^)()',
            'charset' => 'utf8',
            'enableParamLogging' => true,
        ),
        'retrievalSug' => array(
            'class' => 'ext.ERetrievalSuggest',
            'urls' => array(
                'http://172.16.3.139:8131/',
            ),
            'serviceId' => '100',
            'serviceVersion' => '1',
        ),
        'da' => array(
            'class' => 'ext.EDA',
            'urls' => array(
                'http://172.16.3.135:8181/',
                'http://172.16.3.137:8181/',
            ),
            'serviceVersion' => '1',
        ),
        'search' => array(
            'class' => 'ext.search.ESearch',
            'serviceVersion' => '1',
            'urls' => array(
                //'http://172.16.3.139:8021/',
                //'http://172.16.3.141:8021/',
                'http://10.10.8.109',
            ),
        ),
        'bda' => array(
            'class' => 'ext.EBigDataAnalysis',
            'urls' => array(
                'http://172.16.5.24:8090/api/v1/',
            ),
            'accessToken' => 'lianjiaweb',
        ),
        'redis' => array(
            'class' => 'CRedisCache',
            'hostname' => '172.30.13.76',
            'port' => '6379',
            'timeout' => '4',
            'keyPrefix' => '',
            'hashKey' => false,
            'serializer' => false,
        ),
        'cache' => array(
            'class' => 'CRedisCache',
            'hostname' => '127.0.0.1',
            'port' => '6379',
            'timeout' => '1',
            'keyPrefix' => '',
            'hashKey' => false,
            'database'=>1,
            'serializer' => null,

        ),
        'yac'   => array(
            'class' => 'YacCache',
            'keyPrefix' => '',
            'hashKey' => true,
        ),
        'redisProxy'   => array(
            'class' => 'RedisProxy',
            'host' => '127.0.0.1',
            'port' => '6379',
        ),
        'viewRenderer' => array(
            'class' => 'application.extensions.ESmartyViewRenderer',
            'fileExtension' => '.tpl',
            'pluginsDir' => 'application.utils.smartyPlugins',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'FileLogRoute',
                    'levels' => 'trace, info, error, warning, debug',
                    //'levels' => 'info, error, warning',
                    'categories' => 'application.*, system.*, exception.*, bigdata.*',
                    'except' => 'system.CModule',
                    'logPath' => getenv("HOME") . "/var/log",
                ),

                array(
                    'class' => 'GoLogRoute',
                    'levels' => 'trace, info, error, warning, debug',
                    'categories' => 'application.*, system.*, exception.*, bigdata.*',
                    'except' => 'system.CModule',
                    'logHost' => "172.30.16.41:8092",
                    'logPath' => getenv("HOME") . "/var/log",
                ),

            )
        ),
        'request' => array(
            'class' => 'HttpRequest',
            'cities' => array(
                '110000' => array( 'host' => 'testbj.lianjia.com', 'name' => '北京', ),
                '120000' => array( 'host' => 'testtj.lianjia.com', 'name' => '天津', ),
                '310000' => array( 'host' => 'testsh.lianjia.com', 'name' => '上海', ),
                '510100' => array( 'host' => 'testcd.lianjia.com', 'name' => '成都', ),
                '320100' => array( 'host' => 'testnj.lianjia.com', 'name' => '南京', ),
                '330100' => array( 'host' => 'testhz.lianjia.com', 'name' => '杭州', ),
                '370200' => array( 'host' => 'testqd.lianjia.com', 'name' => '青岛', ),
                '210200' => array( 'host' => 'testdl.lianjia.com', 'name' => '大连', ),
                '320500' => array( 'host' => 'testsu.lianjia.com', 'name' => '苏州', ),
                '500000' => array( 'host' => 'testsu.lianjia.com', 'name' => '重庆', ),
                '440300' => array( 'host' => 'testsu.lianjia.com', 'name' => '深圳', ),
                '420100' => array( 'host' => 'testsu.lianjia.com', 'name' => '武汉', ),
                '610100' => array( 'host' => 'testsu.lianjia.com', 'name' => '西安', ),
                '430100' => array( 'host' => 'testsu.lianjia.com', 'name' => '长沙', ),
                '370101' => array( 'host' => 'testjn.lianjia.com', 'name' => '济南', ),
                '130100' => array( 'host' => 'testsjz.lianjia.com', 'name' => '石家庄' ),
            ),
        ),
        'remotefs' => array(
            'class' => 'ext.ES3',
            'downloadEndPoint' => '172.16.3.147:8001',  // nginx watermark
            'uploadEndPoint' => '172.16.3.147',  // radosgw
            'awsAccessKey' => 'TTPOKSFJL88XW6ADE5UQ',  // lianjia-net
            'awsSecretKey' => 'EKCfzUQ6FP+EXYRXgrrLjyoIoI0mxn1Y+b6BJJt+',
         ),
        'user' => array(
            'class' => 'WebUser',
            'registerUrl' => 'http://172.30.11.77:8088/register/resources/lianjia/register.html',
            'loginUrl' => 'http://172.30.11.77:8088/cas/login',
            'validateUrl' => 'http://172.30.11.77:8088/cas/serviceValidate',
            'logoutUrl' => 'http://172.30.11.77:8088/cas/logout',
        ),
        'sms' => array(
            'class' => 'Sms',
            'group' => 'newhouse',
            'token' => 'bzFrlyGjl4etZC1RGkv30onY6WD5uLqi',
            'url_prefix' => 'http://sms.lianjia.com/lianjia/sms',
        ),
        'errorHandler' => array(
            'class' => 'ErrorHandler',
        ),
        'email' => array(
            'class'     => 'application.extensions.EEmail',
            'host'      => 'mail.lianjia.com',
            'username'  => 'noreply@lianjia.com',
            'password'  => '123456',
            'fromname'  => '链家邮件提醒',
        ),
        'ts' => array(
            'class' => 'ext.ETrafficSampling',
            'host' => '10.10.8.29',
            'port' => '8007',
            'space' => 'lianjia-web',
            'serviceId' => '2',
            'serviceVersion' => '1',
            'timeout' => 0.01,
        ),
        /*'uc' => array(
            'class' => 'ext.EUserCenter',
            'urls' => array(
                'http://172.16.5.59:8080/',
                'http://172.16.5.220:8080/',
            ),
        ),*/
        'uc' => array(
            'class' => 'ext.EUserCenter',
            'urls' => array(
                'http://172.30.11.77:8080/uc/',
            ),
        ),
        'recharge' => array(
            'class'  => 'Recharge',
            'appkey' => 'ac74627c875ee1b053b035c400d04384',
            'openid' => 'JHb438f935bf8235497535cada556c0403',
        ),
        'distributeLock' => array(
            'class'     =>  'DistributeLock',
            'timeout'   =>  5,
            'expire'    =>  3,
            'wait_interval' => 200,
        ),
        'hdic' => array(
            'class' =>  'Hdic',
            //'url' =>    'http://172.30.11.200:8100',
            'urls' =>    array(
                //'http://172.16.5.24:8100',
                //'http://172.16.5.25:8100',
                //'http://10.10.5.123',
                'http://10.10.8.39:9000',
                //'http://10.10.8.40:9000', 
                'http://10.10.8.51:9000',
                'http://10.10.8.52:9000',
            ) 
        ),
        "session" => array(
            'class' => 'ext.ESession',
            'urls' => array(
                'http://172.30.13.76:8880/' 
            ),
            'source' => 'newhouse',
            'signature' => '6f1740fb4c702996199b6b146abbda04',
        ),
    ),
    'preload' => array(
        'log'
    )
);
