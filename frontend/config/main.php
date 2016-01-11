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
                //your models
                /*
                'app\modules\news\models\News',
                //or configuration for creating a behavior
                [
                    'class' => 'app\modules\news\models\News',
                    'behaviors' => [
                        'sitemap' => [
                            'class' => SitemapBehavior::className(),
                            'scope' => function ($model) {
                                    $model->select(['url', 'lastmod']);
                                    $model->andWhere(['is_deleted' => 0]);
                                },
                            'dataClosure' => function ($model) {
                                    return [
                                        'loc' => Url::to($model->url, true),
                                        'lastmod' => strtotime($model->lastmod),
                                        'changefreq' => SitemapBehavior::CHANGEFREQ_DAILY,
                                        'priority' => 0.8
                                    ];
                                }
                        ],
                    ],
                ],*/
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
            'cacheKey' => 'sitemapCacheKey',
            'enableGzip' => false, // default is false
        ],
        'article' => [
            'class' => 'frontend\modules\article\ArticleModule'
        ],
        'comment' => [
            'class' => 'frontend\modules\comment\CommentModule',
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
            'class' => 'common\components\UrlManager',
            'enableLanguageDetection' => false,
            'languages' => ['ru'],
            'rules' => require(__DIR__ . '/../../common/config/url-rules.php'),
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
