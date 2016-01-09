<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\components\gii;

use yii\web\AssetBundle;

/**
 * This declares the asset files required by Gii.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class GiiAdvancedAsset extends AssetBundle
{
    public $sourcePath = '@backend/components/gii/assets';
    public $css = [
        'main.css',
    ];
    public $js = [
        'gii.js',
    ];
    public $depends = [
        'yii\gii\GiiAsset',
    ];
}
