<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);
return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'api\controllers',
    'components' => [
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => require(__DIR__ . '/urlrule.php')
        ],
        'view' => [
            'renderers' => [
                'html' => 'yii\smarty\ViewRenderer',
                'options' => [
                    'caching' => 0,
                    'force_compile' => 0
                ]
            ]
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => false,
            'transport' =>[
                'class' =>  'Swift_SmtpTransport',
                'host'  =>  'smtp.ym.163.com',
                'username'  =>  'service@czjinge.com',
                'password'  =>  'jinge5115',
                'port'  =>  '25',
                'encryption'    =>  'tls'
            ],
            'messageConfig' =>  [
                    'charset'   =>  'utf-8',
                    'from'      =>  ['service@czjinge.com'=>'czjingeSoft']
            ],
    
        ],
    ],
    'params' => $params,
];