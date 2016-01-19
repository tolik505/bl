<?php
use \metalguardian\fileProcessor\helpers\FPM;

return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'modules' => [
        'fileProcessor' => [
            'class' => '\metalguardian\fileProcessor\Module',
            'imageSections' => [
                /*'module' => [
                    'size' => [
                        'action' => 'frame',
                        'width' => 400,
                        'height' => 200,
                        'startX' => 100,
                        'startY' => 100,
                    ],
                ],*/
                'admin' => [
                    'file' => [
                        'action' => FPM::ACTION_THUMBNAIL,
                        'width' => 100,
                        'height' => 100,
                    ]
                ],
                'article' => [
                    'title' => [
                        'action' => FPM::ACTION_ADAPTIVE_THUMBNAIL,
                        'width' => 848,
                        'height' => 350,
                    ],
                    'thumb' => [
                        'action' => FPM::ACTION_ADAPTIVE_THUMBNAIL,
                        'width' => 65,
                        'height' => 65,
                    ]
                ]
            ],
        ],
    ],
    'components' => [
        'user' => [
            'class' => 'yii\web\User',
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
        'formatter' => [
            'timeZone' => 'UTC',
            'timeFormat' => IntlDateFormatter::LONG,
            'dateFormat' => IntlDateFormatter::LONG,
        ],
        'i18n' => [
            'class' => 'Zelenin\yii\modules\I18n\components\I18N',
            'languages' => function () {
                return \common\helpers\LanguageHelper::getApplicationLanguages();
            },
        ],
        'urlManager' => [
            'class' => '\common\components\UrlManager',
            'showScriptName' => false,
            'enableStrictParsing' => true,
            'rules' => require(__DIR__ . '/url-rules.php'),
        ],
    ],
    'sourceLanguage' => 'xx',
    'language' => 'ru',
];
