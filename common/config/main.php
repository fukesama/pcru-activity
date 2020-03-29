<?php
return [
	'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
	'language' => 'th',
	'timeZone' => 'Asia/Bangkok',
	'aliases' => [
		'@bower' => '@vendor/bower-asset',
		'@npm'   => '@vendor/npm-asset',
	],
	'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
	'components' => [
		'Func' => [
			'class' => 'common\components\Func',
		],
		'cache' => [
			'class' => 'yii\caching\FileCache',
		],
		'session' => [
			'name' => 'pcru',
		],
		'user' => [
			'identityClass' => 'frontend\models\User',
			'enableAutoLogin' => false,
		],
		// 'encrypter'=>[
		// 	'class'=>'\nickcv\encrypter\components\Encrypter',
		// 	'globalPassword'=>'PCRUAc',
		// 	'iv'=>'E5EE64C4F3CD4E61EE4433363A1EF',
		// 	'useBase64Encoding'=>true,
		// 	'use256BitesEncoding'=>false,
		// ],

		'formatter' => [
			'class'=> 'yii\i18n\Formatter',
			'nullDisplay'=> '',
			'dateFormat' => 'php:d-M-Y',
			'datetimeFormat' => 'php:d-M-Y H:i:s',
			'timeFormat' => 'php:H:i:s',
			'timeZone' => 'Asia/Bangkok',
		],
		'localtime'=>array(
            'class'=>'Asia/Bangkok',
        ),


	],
	'modules' => [
		'gridview' => ['class' => 'kartik\grid\Module'],
		'gii' => [
			'class' => 'yii\gii\Module',
			'allowedIPs' => ['127.0.0.1', '::1', '192.168.1.*', '192.168.1.59'],
			'generators' => [
				'crud' => [
					'class' => 'yii\gii\generators\crud\Generator',
					'templates' => [
						'material_dashboard' => dirname(dirname(__DIR__)).'\\material_dashboard\\generators\\crud/default',
					]
				]
			],
		],
		'encrypter' => 'nickcv\encrypter\Module',
	],
];
