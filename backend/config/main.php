<?php
use \yii\web\Request;
$baseUrl = str_replace('/web', '', (new Request)->getBaseUrl());
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params.php',
    require __DIR__ . '/params-local.php'
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [],
    'components' => [
        'request' => [
            'baseUrl' => $baseUrl,
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            //'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
     'session' => [
            // this is the name of the session cookie used for login on the backend
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
            'errorAction' => ['../'],
        ],
        'urlManager' => [
            'showScriptName' => false,   // Disable index.php
            'enablePrettyUrl' => true,   // Disable r= routes
            'enableStrictParsing' => false,
            'rules' => array(
                '' => 'site/index',
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
            ),
        ],
        'urlManagerFrontend' => [
         'class' => 'yii\web\urlManager',
         'baseUrl' => '/pcru-activity/',
         'enablePrettyUrl' => true,
         'showScriptName' => false,
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
