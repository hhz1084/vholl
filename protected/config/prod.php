<?php

defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENABLE_ERROR_HANDLER') or define('YII_ENABLE_ERROR_HANDLER',false);

return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'lianjia-framework',
    'runtimePath' => getenv("HOME") . DIRECTORY_SEPARATOR . 'var',

    'modules' => array(
        'lianjia-newhouse-api' => array(
            'regex' => '(119\.254\.70\.179)|(10\.10\.8\.106)|(newhouseapi\.lianjia\.com)(?::\d+)?',
            'directory' => 'lianjia-newhouse-api'
        ),
    ),

    // autoloading model and component classes
    'import' => array(
        'application.components.*',
        'application.tables.hdic.*',
        'application.tables.newhouse.*',
        'application.utils.*',
        'application.data.Constants',
    ),
    // application components
    'components' => array(
        'db-newhouse' => array(
            'class' => 'CDbConnection',
            'connectionString' => 'mysql:host=10.10.6.30;port=6701;dbname=lianjia_newhouse',
            'emulatePrepare' => true,
            'username' => 'newh',
            'password' => 'bbcec310261e4344',
            'charset' => 'utf8',
            'enableParamLogging' => true,
        ),
        'db-hdic' => array(
            'class' => 'CDbConnection',
            'connectionString' => 'mysql:host=172.16.6.153;port=6521;dbname=hdic',
            'emulatePrepare' => true,
            'username' => 'web_w',
            'password' => '34c666e5a108471598b8120d6a140f34',
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
        'uc' => array(
            'class' => 'ext.EUserCenter',
            'urls' => array(
                'http://172.16.5.59:8080/',
                'http://172.16.5.220:8080/',
            ),
        ),
        'redisProxy'   => array(
            'class' => 'RedisProxy',
            'host' => '10.10.8.17',
            'port' => '6379',
        ),
        'redis' => array(
            'class' => 'CRedisCache',
            'hostname' => '172.16.3.103',
            'port' => '6379',
            'timeout' => '4',
            'keyPrefix' => '',
            'hashKey' => false,
            'serializer' => false,
        ),
        'cache' => array(
            'class' => 'CRedisCache',
            'hostname' => '10.10.8.17',
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
                    'categories' => 'application.*, system.*, exception.*, bigdata.*',
                    'except' => 'system.CModule',
                    'logPath' => getenv("HOME") . "/var/log",
                )
            )
        ),
        'request' => array(
            'class' => 'HttpRequest',
            'cities' => array(
                '110000' => array( 'host' => 'bj.lianjia.com', 'name' => '北京', ),
                '120000' => array( 'host' => 'tj.lianjia.com', 'name' => '天津', ),
                '310000' => array( 'host' => 'sh.lianjia.com', 'name' => '上海', ),
                '510100' => array( 'host' => 'cd.lianjia.com', 'name' => '成都', ),
                '320100' => array( 'host' => 'nj.lianjia.com', 'name' => '南京', ),
                '330100' => array( 'host' => 'hz.lianjia.com', 'name' => '杭州', ),
                '370200' => array( 'host' => 'qd.lianjia.com', 'name' => '青岛', ),
                '210200' => array( 'host' => 'dl.lianjia.com', 'name' => '大连', ),
                '320500' => array( 'host' => 'su.lianjia.com', 'name' => '苏州', ),
                '500000' => array( 'host' => 'cq.lianjia.com', 'name' => '重庆', ),
                '440300' => array( 'host' => 'sz.lianjia.com', 'name' => '深圳', ),
                '420100' => array( 'host' => 'wh.lianjia.com', 'name' => '武汉', ),
                '610100' => array( 'host' => 'xa.lianjia.com', 'name' => '西安', ),
                '430100' => array( 'host' => 'cs.lianjia.com', 'name' => '长沙', ),
                '370101' => array( 'host' => 'jn.lianjia.com', 'name' => '济南', ),
                '130100' => array( 'host' => 'sjz.lianjia.com', 'name' => '石家庄' ),
            ),
        ),
        'remotefs' => array(
            'class' => 'ext.ES3',
            'downloadEndPoint' => 'image2.lianjia.com',
            'uploadEndPoint' => array(
                '10.10.9.12', // jx-lj-tfs00
                '10.10.9.13', // jx-lj-tfs01
            ),
            'awsAccessKey' => '2WEXO1380CDRB76JDQXS',
            'awsSecretKey' => 'lDMjBMFBHyynCLjZrBRF0l+QiPIVPu4Y+cA1FkYN',
         ),
        'user' => array(
            'class' => 'WebUser',
            'registerUrl' => 'http://passport.lianjia.com/register/resources/lianjia/register.html',
            'loginUrl' => 'https://passport.lianjia.com/cas/login',
            'logoutUrl' => 'http://passport.lianjia.com/cas/logout',
            'validateUrl' => 'http://172.16.4.172:8088/cas/serviceValidate',
        ),
        'sms' => array(
            'class' => 'ext.ESms',
            'user' => '10xun-lianjia1',
            'password' => 'lianjia@)!$2014',
            'urls' => array(
                'http://port.joycloud.mobi:81/WebServices/SMS/send_smsserver.ashx?',
            ),
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
        'sms' => array(
            'class' => 'Sms',
            'group' => 'newhouse',
            'token' => 'bzFrlyGjl4etZC1RGkv30onY6WD5uLqi',
            'url_prefix' => 'http://sms.lianjia.com/lianjia/sms',
        ),
        'hdic' => array(
            'class' => 'Hdic',
            'urls' => array(
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
                'http://10.10.8.42:8880/',
                'http://10.10.8.43:8880/' 
            ),
            'source' => 'newhouse',
            'signature' => '6f1740fb4c702996199b6b146abbda04',
        ),
    ),
    'preload' => array(
        'log'
    )
);
