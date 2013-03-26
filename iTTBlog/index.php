<?php

if(isset($_POST['PHPSESSID'])) $_COOKIE['PHPSESSID'] = $_POST['PHPSESSID'];
error_reporting(E_ALL ^ E_NOTICE);

 //应用程序环境，可选：development,test,production,main
defined('APP_ENV') or define('APP_ENV','main');
$yii=dirname(__FILE__).'/../../../yii/framework/yii.php';

if (APP_ENV == 'production') {//生产环境的配置
    defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',1);
} else {//开发环境的配置
    // remove the following lines when in production mode
    defined('YII_DEBUG') or define('YII_DEBUG',true);
    // specify how many levels of call stack should be shown in each log message
    defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);
}
$config=dirname(__FILE__).'/protected/config/'.APP_ENV.'.php';

require_once($yii);
Yii::createWebApplication($config)->run();
?>
