<?php
/**
 * Created by PhpStorm.
 * User: anatolii
 * Date: 23.01.16
 * Time: 13:17
 */

namespace frontend\assets;


class SyntaxHighlighterAsset extends \giovdk21\yii2SyntaxHighlighter\SyntaxHighlighterAsset
{
    public static $extraCss = [
        'styles/shCore.css',
        'styles/shThemeDefault.css',
    ];
    public static $extraJs = [
        'scripts/shBrushPhp.js',
        'scripts/shBrushJScript.js',
        'scripts/shBrushCss.js',
    ];
}
