<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-frontend',
    'name' => 'Project',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log', 'fileProcessor', 'config'],
    'controllerNamespace' => 'frontend\controllers',
    'modules' => [
        'sitemap' => [
            'class' => 'himiklab\sitemap\Sitemap',
            'models' => [
                'frontend\modules\article\models\ArticleCategory',
                'frontend\modules\article\models\Article',
            ],
            'urls'=> [
                [
                    'loc' => '/',
                    'lastmod' => time(),
                    'changefreq' => \himiklab\sitemap\behaviors\SitemapBehavior::CHANGEFREQ_DAILY,
                    'priority' => 0.8
                ],
                // your additional urls
                /*[
                    'loc' => '/news/index',
                    'changefreq' => \himiklab\sitemap\behaviors\SitemapBehavior::CHANGEFREQ_DAILY,
                    'priority' => 0.8,
                    'news' => [
                        'publication'   => [
                            'name'          => 'Example Blog',
                            'language'      => 'en',
                        ],
                        'access'            => 'Subscription',
                        'genres'            => 'Blog, UserGenerated',
                        'publication_date'  => 'YYYY-MM-DDThh:mm:ssTZD',
                        'title'             => 'Example Title',
                        'keywords'          => 'example, keywords, comma-separated',
                        'stock_tickers'     => 'NASDAQ:A, NASDAQ:B',
                    ],
                    'images' => [
                        [
                            'loc'           => 'http://example.com/image.jpg',
                            'caption'       => 'This is an example of a caption of an image',
                            'geo_location'  => 'City, State',
                            'title'         => 'Example image',
                            'license'       => 'http://example.com/license',
                        ],
                    ],
                ],*/
            ],
            'cacheKey' => 'siteMapCacheKey',
            'enableGzip' => false, // default is false
            'cacheExpire' => 12*3600,
        ],
        'article' => [
            'class' => 'frontend\modules\article\ArticleModule'
        ],
        'comment' => [
            'class' => 'frontend\modules\comment\CommentModule',
        ],
        'request' => [
            'class' => 'frontend\modules\request\RequestModule',
        ],
    ],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'config' => [
            'class' => '\common\components\ConfigurationComponent',
        ],
        'user' => [
            'loginUrl' => ['/user/login'],
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
        'urlManager' => [
            'enableLanguageDetection' => false,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'view' => [
            'theme' => [
                'basePath' => '@app/themes/basic',
                'pathMap' => [
                    '@app/views' => ['@app/themes/basic'],
                    '@app/modules' => ['@app/themes/basic/modules']
                ],
                'baseUrl' => '@web/themes/basic',
            ],
        ],
        'assetManager' => [
            'linkAssets' => true,
            'appendTimestamp' => true,
        ],
    ],
    'params' => $params,
];
