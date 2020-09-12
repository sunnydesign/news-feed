<?php

$db = require __DIR__ . '/db.php';

return [
    'id' => 'news-feed',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'modules' => [
        'frontend' => [
            'basePath' => '@app/modules/frontend',
            'class' => 'app\modules\frontend\Module',
            'layout' => '@app/modules/frontend/views/layouts/main',
        ],
        'v1' => [
            'basePath' => '@app/modules/v1',
            'class' => 'app\modules\v1\Module'
        ]
    ],
	'aliases' => [
        '@api' => dirname(dirname(__DIR__)) . '/api',
        '@frontend' => dirname(dirname(__DIR__)) . '/frontend',
    ],
    'components' => [
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => false,
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
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'showScriptName' => false,
            'rules' => [
                // frontend
                '/' => 'frontend/main/index',

                // api
                [
                    'class' => \yii\rest\UrlRule::class,
                    'controller' => ['v1/article'],
                    'prefix' => 'api',
                    'tokens' => [
                        '{id}' => '<id:\\w+>'
                    ],
                    'except' => ['delete', 'create', 'update']
                ],
                [
                    'class' => \yii\rest\UrlRule::class,
                    'controller' => ['v1/category'],
                    'prefix' => 'api',
                    'tokens' => [
                        '{id}' => '<id:\\w+>'
                    ],
                    'except' => ['delete', 'create', 'update']
                ]
            ],
        ],

        'request' => [
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
                'multipart/form-data' => 'yii\web\MultipartFormDataParser'
            ]
        ],
//        'response' => [
//            'formatters' => [
//                \yii\web\Response::FORMAT_JSON => [
//                    'class' => 'yii\web\JsonResponseFormatter',
//                    //'prettyPrint' => YII_DEBUG, // используем "pretty" в режиме отладки
//                    'encodeOptions' => JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE,
//                ],
//            ],
//        ],
        'db' => $db,
    ]
];



