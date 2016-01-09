<?php

$config = [
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '',
        ],
    ],
];

if (!YII_ENV_TEST) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        'allowedIPs' => ['*'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => ['*'],
        'generators' => [
            'advanced-model' => [
                'class' => 'backend\components\gii\model\Generator',
                'templates' => [
                    'default' => '@backend/components/gii/model/default',
                ]
            ],
            'advanced-crud' => [
                'class' => 'backend\components\gii\crud\Generator',
                'templates' => [
                    'default' => '@backend/components/gii/crud/default',
                ]
            ],
            'advanced-module' => [
                'class' => 'backend\components\gii\module\Generator',
                'templates' => [
                    'default' => '@backend/components/gii/module/default',
                ]
            ],
        ],
    ];
}

return $config;
