<?php

use yii\web\UrlNormalizer;

$config = [
    'id' => 'tabler-qualification-project',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'errorHandler' => [
            'errorAction' => 'site/error',
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
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'enableStrictParsing' => true,
            'normalizer' => [
                'class' => UrlNormalizer::class,
                'action' => UrlNormalizer::ACTION_REDIRECT_TEMPORARY,
            ],
            'showScriptName' => false,
            'rules' => [
                    'GET v1/posts' => 'v1/posts/index',
                    'GET v1/posts/<id:[a-z0-9]+>' => 'v1/posts/view',
            ],
        ],
        'response' => [
            'format' => yii\web\Response::FORMAT_JSON,
            'charset' => 'UTF-8',
            'on beforeSend' => function ($event) {
                \app\components\ResponseFormatter::handle($event);
            },

        ],
        'mongodb' => [
            'class' => '\yii\mongodb\Connection',
            'dsn' => 'mongodb://localhost:27017/tbdb',
        ],
    ],
    'modules' => [
        'v1' => [
            'class' => 'app\modules\v1\Module',
        ],
    ],
    'params' => [],
];

return $config;
