<?php
use \yii\web\Request;
$baseUrl = str_replace('/frontend/web', '', (new Request)->getBaseUrl());
$params = array_merge(
	require __DIR__ . '/../../common/config/params.php',
	require __DIR__ . '/../../common/config/params-local.php',
	require __DIR__ . '/params.php',
	require __DIR__ . '/params-local.php'
);

return [
	'id' => 'app-frontend',
	'basePath' => dirname(__DIR__),
	'bootstrap' => ['log'],
	'controllerNamespace' => 'frontend\controllers',
	'components' => [
		'request' => [
			'baseUrl' => $baseUrl,
			'enableCsrfValidation' => false,
		],

		'user' => [
			'identityClass' => 'common\models\User',
			'enableAutoLogin' => true,
			//'identityCookie' => ['name' => '_identity-frontend', 'httpOnly' => true],
		],

		'session' => [

			'name' => 'pcru',
		],
		'log' => [
			'traceLevel' => YII_DEBUG ? 3 : 0,
			'targets' => [
				[
					'class' => 'yii\log\FileTarget',
					'levels' => ['error', 'warning'],
				],
			],
		],
		'errorHandler' => [
			'errorAction' => 'site/error',
		],
		'urlManager' => [
			'showScriptName' => false,   
			'enablePrettyUrl' => false,   
			'enableStrictParsing' => false,
			'rules' => array(
				'' => 'site/index',
				'<controller:\w+>/<id:\d+>' => '<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
				'<controller:\w+>/<action:\w+>' => '<controller>/<action>',
			),
		],
		'urlManagerBackend' => [
			'class' => 'yii\web\urlManager',
			// 'baseUrl' => '/pcru-activity/backend',
			'enablePrettyUrl' => false,
			'showScriptName' => false
		],
		'urlManagerFrontend' => [
			'class' => 'yii\web\urlManager',
			// 'baseUrl' => '/pcru-activity/',
			'enablePrettyUrl' => false,
			'showScriptName' => false,
		],
		'errorHandler' => [
			'errorAction' => 'site/error',
		],

		'image' => [  
			'class' => 'yii\image\ImageDriver',
		'driver' => 'GD',  //GD or Imagick
	],

		/*
		'urlManager' => [
			'enablePrettyUrl' => true,
			'showScriptName' => false,
			'rules' => [
			],
		],
		*/
	],
	'params' => $params,
];
