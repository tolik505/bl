<?php

return [
    [
        'label' => Yii::t('app', 'Settings'),
        'items' => [
            [
                'label' => Yii::t('app', 'Articles'),
                'items' => [
                    [
                        'label' => Yii::t('app', 'Article categories'),
                        'url' => ['/article/article-category/index'],
                    ],
                    [
                        'label' => Yii::t('app', 'Articles'),
                        'url' => ['/article/article/index'],
                    ],
                ],
            ],
        ],
    ],
    [
        'label' => 'Configuration',
        'url' => ['/configuration/default/index'],
        'items' => [
            [
                'label' => 'Configuration',
                'url' => ['/configuration/default/index'],
            ],
            [
                'label' => 'Translations',
                'url' => ['/i18n/default/index'],
            ],
            [
                'label' => 'Seo Tags',
                'url' => ['/meta/tag/index'],
            ],
            [
                'label' => 'Robots.txt',
                'url' => ['/seo/robots/index'],
            ],
            [
                'label' => 'Language',
                'url' => ['/language/language/index'],
            ],
            [
                'label' => 'Redirects',
                'url' => ['/redirects/redirects/index'],
            ],
            [
                'label' => 'Page Seo',
                'url' => ['/seo/page-seo/index'],
            ],
        ],
    ]
];
