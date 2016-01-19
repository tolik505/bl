<?php
return [
    'page/<page>' => 'site/index',
    '' => 'site/index',
    'articles/page/<page>' => 'article/default/index',
    'articles' => 'article/default/index',
    'article/<alias>' => 'article/default/view',
    'search/<query>/page/<page>' => 'article/search/index',
    'search/<query>' => 'article/search/index',
    'search' => 'article/search/index',
    'subscribe' => 'request/default/subscribe',
    'sitemap' => 'site/sitemap',
    'add-comment' => 'comment/default/add-comment',
    'robots.txt' => 'site/robots',
    'sitemap.xml' => 'sitemap/default/index',
    '<alias>/page/<page>' => 'article/default/category',
    '<alias>' => 'article/default/category'
];
