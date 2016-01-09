<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'themes/basic/css/settings.css',
        'themes/basic/css/style.css',
        'themes/basic/css/responsive.css',
        'themes/basic/css/colors/blue.css',
        'themes/basic/css/fontello.css',
        'css/site.css',
    ];
    public $js = [
        'themes/basic/js/bootstrap.js',
        'themes/basic/js/jquery.migrate.js',
        'themes/basic/js/modernizrr.js',
        'themes/basic/js/jquery.fitvids.js',
        'themes/basic/js/owl.carousel.min.js',
        'themes/basic/js/nivo-lightbox.min.js',
        'themes/basic/js/jquery.isotope.min.js',
        'themes/basic/js/jquery.appear.js',
        'themes/basic/js/count-to.js',
        'themes/basic/js/jquery.textillate.js',
        'themes/basic/js/jquery.lettering.js',
        'themes/basic/js/jquery.nicescroll.min.js',
        'themes/basic/js/script.js',
        'js/frontend.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'justinvoelker\tagging\TaggingAsset',
    ];
}
