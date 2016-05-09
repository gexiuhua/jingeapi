<?php
//主程序全局配置
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'language' => 'zh-CN',
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=139.196.14.176;dbname=jingeapi',
            'username' => 'jinge',
            'password' => 'czjinge.mysql123',
            'tablePrefix' => 'j_',
            'enableSchemaCache' => true,
            'schemaCacheDuration' => 600,
            'charset' => 'utf8',
            'attributes' => [
                //PDO::ATTR_PERSISTENT => true
            ],
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'gYhuwmjImVorQ0RvkInVEw9yVUn05eNK',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
//                  'categories' => ['yii\db\*'],
                    'logVars' => [],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
         'cache' => [
             'class' => 'yii\caching\FileCache',
//             'class' => '\yii\caching\MemCache',
//             'keyPrefix' => '',
//             'servers' => [
//                 [
//                     'host' => '127.0.0.1',
//                     'port' => 11211,
//                 ],
//             ],
         ],
    ],
    'modules' => [
        'gii' => [
            'class' => 'yii\gii\Module',
            'allowedIPs' => ['127.0.0.1','::1','112.21.166.40'] // 按需调整这里
        ],
        'v1_2' => [
            'class' => 'app\modules\v1_2\V1_2',
        ],

    ],
];


