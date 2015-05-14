<?php

return array(
    'basePath' => dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
    'name' => 'Экскурсии',
    'defaultController' => 'index',
    'language' => 'ru',
    'preload' => array(
        'log'
    ),
    'import' => array(
        'application.models.*',
        'application.controllers.*',
        'application.components.*',
        'application.helpers.*',
    ),
    'modules' => array(
        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => 'password',
            'ipFilters' => array('127.0.0.1','::1'),
            'generatorPaths' => array(
                'bootstrap.gii'
            ),
        )
    ),
    'components' => array(
        'user' => array(
            'allowAutoLogin' => true,
            'loginUrl' => '/index/login',
            'returnUrl' => '/'
        ),
        'urlManager' => array(
            'urlFormat' => 'path',
            'showScriptName' => false,
            'rules' => array(),
        ),
        'db' => array(
            'connectionString' => 'mysql:host=localhost;dbname=new_tours',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => '123456',
            'charset' => 'utf8',
        ),
		'authManager' => array(
            'class'	=> 'CDbAuthManager',
            'connectionID' => 'db',
        ),
        'errorHandler' => array(
            'errorAction' => '/error',
        ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'error, warning',
                ),
            ),
        ),
		'image' => array(
			'class' => 'application.extensions.image.CImageComponent',
            'driver' => 'GD',
		)
    ),
    'params' => array(
        'yandexMapsAPI' => ''
    ),
);
