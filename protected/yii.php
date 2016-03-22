<?php
/**
 * Yii bootstrap file.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @link http://www.yiiframework.com/
 * @copyright 2008-2013 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 * @package system
 * @since 1.0
 */

require(dirname(__FILE__).'/../framework/YiiBase.php');

class Yii extends YiiBase {

    /**
     * Creates a Web application instance.
     * @param mixed $config application configuration.
     * If a string, it is treated as the path of the file that contains the configuration;
     * If an array, it is the actual configuration information.
     * Please make sure you specify the {@link CApplication::basePath basePath} property in the configuration,
     * which should point to the directory containing all application logic, template and data.
     * If not, the directory will be defaulted to 'protected'.
     * @return CWebApplication
     */
    public static function createWebApplication($config=null) {
        return self::createApplication('CWebApplication',$config);
    }

    /**
     * Creates a console application instance.
     * @param mixed $config application configuration.
     * If a string, it is treated as the path of the file that contains the configuration;
     * If an array, it is the actual configuration information.
     * Please make sure you specify the {@link CApplication::basePath basePath} property in the configuration,
     * which should point to the directory containing all application logic, template and data.
     * If not, the directory will be defaulted to 'protected'.
     * @return CConsoleApplication
     */
    public static function createConsoleApplication($config=null) {
        return self::createApplication('CConsoleApplication',$config);
    }

    /**
     * Creates an application of the specified class.
     * @param string $class the application class name
     * @param mixed $config application configuration. This parameter will be passed as the parameter
     * to the constructor of the application class.
     * @return mixed the application instance
     */
    public static function createApplication($class,$config=null) {

        !defined("APP_MODE") && define("APP_MODE", get_cfg_var('lianjia.environment'));
        if (APP_MODE == false) {
            throw new Exception("lianjia.environment is not set in php.ini");
        }
        empty($config) && $config = __DIR__ . "/config/" . APP_MODE . ".php";

        if (is_string($config) && file_exists($config)) {
            $config = require($config);
        }

        $module = "";
        $rootPath = dirname(realpath(__DIR__));
        if (PHP_SAPI != "cli") {
            $module = self::_getModule($config["modules"]);
            if ($module == null) {
                throw new Exception("unknown host");
            }
            unset($config["modules"]);
            $moduleConfig = sprintf("%s/modules/%s/config/%s.php", $rootPath, $module, APP_MODE);
            if (is_array($config) && file_exists($moduleConfig)) {
                $config = self::_mergeConfig($config, $moduleConfig);
            }
        } else {
            global $argv;
            unset($config["modules"]);
            $scriptPath = realpath($argv[0]);
            if (strpos($scriptPath, $rootPath . "/modules/") === 0) {
                if (preg_match("#^/modules/([-\w.~]+)/#", substr($scriptPath, strlen($rootPath)), $match)) {
                    $module = $match[1];
                    $moduleConfig = sprintf("%s/modules/%s/config/%s.php", $rootPath, $module, APP_MODE);
                    if (is_array($config) && file_exists($moduleConfig)) {
                        $config = self::_mergeConfig($config, $moduleConfig);
                    }
                }
            }

            unset($config["controllerPath"]);
            unset($config["viewPath"]);
            unset($config["modulePath"]);
        }
        Yii::module($module);
        Yii::setPathOfAlias("ext", sprintf("%s/protected/extensions", $rootPath));
        Yii::setPathOfAlias("module", sprintf("%s/modules/%s/", $rootPath, $module));
        Yii::setPathOfAlias("modules", "{$rootPath}/{$module}");
        $app = parent::createApplication($class, $config);

        if (APP_MODE == "jay" && function_exists("xhprof_enable")) {
            $app->attachEventHandler("onBeginRequest", function() {
                xhprof_enable(XHPROF_FLAGS_NO_BUILTINS);
            });
            $app->attachEventHandler("onEndRequest", function() use ($app) {
                $data = xhprof_disable();   //返回运行数据
                include_once "xhprof_lib/utils/xhprof_runs.php";
                $objXhprofRun = new XHProfRuns_Default(); 
                $run_id = $objXhprofRun->save_run($data, $app->name);
            });
        }
        return $app;
    }

    protected static function _mergeConfig($oldConfig, $newConfig) {
        if (is_string($newConfig)) {
            $newConfig = require($newConfig);
        }
        $config = $oldConfig;
        $import = $config["import"];
        $components = $config["components"];
        foreach ($newConfig as $key => $value) {
            if ($key == "import") {
                foreach ($value as $item) {
                    $import[] = $item;
                }
            } else if ($key == "components") {
                foreach ($value as $componentName => $componentValue) {
                    $components[$componentName] = $componentValue;
                }
            } else {
                $config[$key] = $value;
            }
        }
        unset($config["import"]);
        unset($config["components"]);
        $config["import"] = $import;
        $config["components"] = $components;
        return $config;
    }

    protected static function _getModule($modules) {

        $host = $_SERVER["HTTP_HOST"];
        $dir = null;
        isset($_COOKIE["__module_dir__"]) && $dir = $_COOKIE["__module_dir__"];
        isset($_GET["__module_dir__"]) && $dir = $_GET["__module_dir__"];

        if (array_key_exists("__module_test__", $_GET)) {
            // DEBUG MODE
            echo "<table border=1><tr><td colspan=2>\$_SERVER[HTTP_HOST]</td><td colspan=2>{$host}</td></tr>";
            echo "<tr><td colspan=2>FORCED DIRECTORY</td><td colspan=2>{$dir}</td>";
            echo "<tr><td>NAME</td><td>REGEX</td><td>DIRECTORY</td><td>MATCH</td></tr>";
            foreach ($modules as $k => $module) {
                $res = preg_match("/^{$module["regex"]}\$/", $host) ? "TRUE" : "FALSE";
                echo "<tr><td><a href=\"?__module_dir__={$module["directory"]}\">{$k}</a></td>";
                echo "<td>{$module["regex"]}</td><td>{$module["directory"]}</td><td>{$res}</td></tr>";
            }
            echo "</table>";
            die();
        }

        if (YII_DEBUG && $dir) {
            isset($_GET["__module_dir__"]) && setcookie("__module_dir__", $dir, 0, "/");
            return $dir;
        }

        foreach ($modules as $k => $module) {
            if (preg_match("/^{$module["regex"]}\$/i", $host)) {
                $dir = $module["directory"];
                break;
            }
        }

        return $dir;

    }

    /**
     * @return InstantLogger message logger
     */
    public static function getLogger()
    {
        static $logger = NULL;
        if (class_exists("InstantLogger")) {
            return $logger ? $logger : $logger = new InstantLogger();
        } else {
            return NULL;
        }
    }

    /**
     * Sets the logger object.
     * @deprecated
     * @param CLogger $logger the logger object.
     * @since 1.1.8
     */
    public static function setLogger($logger)
    {
        throw new CException("cannot set logger in this Yii version");
    }

    /**
     * Writes a trace message.
     * This method will only log a message when the application is in debug mode.
     * @param string $msg message to be logged
     * @param string $category category of the message
     * @see log
     */
    public static function trace($msg,$category='application')
    {
        if(YII_DEBUG)
            self::log($msg,CLogger::LEVEL_TRACE,$category);
    }

    /**
     * Logs a message.
     * Messages logged by this method may be retrieved via {@link CLogger::getLogs}
     * and may be recorded in different media, such as file, email, database, using
     * {@link CLogRouter}.
     * @param string $msg message to be logged
     * @param string $level level of the message (e.g. 'trace', 'warning', 'error'). It is case-insensitive.
     * @param string $category category of the message (e.g. 'system.web'). It is case-insensitive.
     */
    public static function log($msg, $level=InstantLogger::LEVEL_DEBUG, $category='application')
    {
        ($logger = self::getLogger()) && $logger->log($msg, $level, $category);
    }

    public static function logEx($msg, $level=InstantLogger::LEVEL_DEBUG, $category='application', $ext=NULL) {
        ($logger = self::getLogger()) && $logger->log($msg, $level, $category, $ext);
    }

    public static function warning($msg, $ext=NULL, $category='application') {
        self::logEx($msg, InstantLogger::LEVEL_WARN, $category, $ext);
    }

    public static function info($msg, $ext=NULL, $category='application') {
        self::logEx($msg, InstantLogger::LEVEL_INFO, $category, $ext);
    }

    public static function debug($msg, $ext=NULL, $category='application') {
        self::logEx($msg, InstantLogger::LEVEL_DEBUG, $category, $ext);
    }

    public static function fatal($msg, $ext=NULL, $category='application') {
        self::logEx($msg, InstantLogger::LEVEL_ERROR, $category, $ext);
    }

    public static function token() {
        static $token = null;
        return $token ? $token : $token = mt_rand();
    }

    public static function module($set = null) {
        static $module = null;
        if ($module === null && $set) {
            $module = $set;
        }
        return $module;

    }

}
