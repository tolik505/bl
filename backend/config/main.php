<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'name' => 'Project',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log', 'config', 'fileProcessor'],
    'modules' => [
        'admin' => [
            'class' => '\backend\modules\admin\Module',
        ],
        'menu' => [
            'class' => 'backend\modules\menu\Module',
        ],
        'configuration' => [
            'class' => 'backend\modules\configuration\Module',
        ],
        'i18n' => [
            'class' => 'Zelenin\yii\modules\I18n\Module',
        ],
        'language' => [
            'class' => 'backend\modules\language\Module',
        ],
        'meta' => [
            'class' => 'notgosu\yii2\modules\metaTag\Module',
        ],
        'redirects' => [
            'class' => 'backend\modules\redirects\Module',
        ],
        'seo' => [
            'class' => 'backend\modules\seo\Module',
        ],
        'imagesUpload' => [
            'class' => 'backend\modules\imagesUpload\ImagesUploadModule',
        ],
        'article' => [
            'class' => 'backend\modules\article\ArticleModule',
        ],
        'sport' => [
            'class' => 'backend\modules\sport\SportModule',
        ],
        'schedule' => [
            'class' => 'backend\modules\schedule\ScheduleModule',
        ],
        'banner' => [
            'class' => 'backend\modules\banner\BannerModule',
        ],
        'faq' => [
            'class' => 'backend\modules\faq\FaqModule',
        ],
        'about' => [
            'class' => 'backend\modules\about\AboutModule',
        ],
    ],
    'components' => [
        'config' => [
            'class' => '\common\components\ConfigurationComponent',
        ],
        'user' => [
            'loginUrl' => ['/admin/default/login'],
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
            'errorAction' => 'error/error',
        ],
        'urlManager' => [
            'enableLocaleUrls' => false,
            'rules' => [
                '<module>/<controller>/<action>' => '<module>/<controller>/<action>',
                '<controller>/<action>' => '<controller>/<action>',
                '' => 'site/index',
            ],
        ],
        'assetManager' => [
            'linkAssets' => true,
            'appendTimestamp' => true,
        ],
        'formatter' => [
            'class' => '\backend\components\Formatter',
            'datetimeFormat' => 'php:d.m.y H:i:s',
        ],
    ],
    'params' => $params,
];
