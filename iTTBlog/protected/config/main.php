<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    'basePath' => dirname(__FILE__) . DIRECTORY_SEPARATOR . '..',
    'name' => 'iTTBlog',
    'defaultController' => 'SiteController',
    // preLoading 'log' component
    'preload' => array('log'),

    // autoLoading model and component classes
    'import' => array(
        'application.models.*',
        'application.components.*',
        'application.components.PHPMailer.*',
        'application.components.jFormer.*',
        'application.components.Stomp.*',
    ),

    'modules' => array(
        // uncomment the following to enable the Gii tool

        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => 'adminGii',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters' => array('127.0.0.1', '::1'),
        ),

    ),

    // application components
    'components' => array(
        'user' => array(
            // 启用基于cookie的认证
            'class' => 'WebUser',
            'allowAutoLogin' => true,
            'loginUrl' => array('site/login'),
        ),

        //Yii::app()->session  可以引用到这里
        /*
        'session' => array(
            'class' => 'system.web.CDbHttpSession', // 标记使用 CDbHttpSession
            'connectionID' => 'db',           // 使用组件中哪个数据库连接
            'sessionTableName'=>'yiiSession', // 表名字
            'autoCreateSessionTable'=>true,   // 自动创建session表
            'timeout'      => 1440,           // 设置闲置多久session超时 (默认是 1440 秒)
        ),
        */
        // uncomment the following to enable URLs in path-format

        'urlManager' => array(
            'urlFormat' => 'path',
            'showScriptName' => false,
            'rules' => array(
                '/' => 'site/index',
                'login' => 'site/login',
                'reg' => 'site/reg',
                'index' => 'site/index',
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ),
        ),


        // uncomment the following to use a MySQL database

        'db' => array(
            'connectionString' => 'mysql:host=localhost;dbname=ittblog',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
        ),

        'errorHandler' => array(
            // use 'site/error' action to display errors
            'errorAction' => 'site/error',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ),
                // uncomment the following to show log messages on web pages
                /*
                    array(
                        'class'=>'CWebLogRoute',
                    ),
                    */
            ),
        ),
    ),

    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'params' => array(
        // this is used in contact page
        'adminEmail' => 'admin@ittblog.com',
        'homeUrl' => 'www.cnblogs.com',
    ),
);