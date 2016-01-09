<?php
/**
 * @author walter
 */

namespace frontend\helpers;


use yii\helpers\Html;

/**
 * Class ExtendedHtml
 * @package frontend\helpers
 */
class ExtendedHtml extends Html
{

    /**
     * Generates ajax hyperlink tag
     * @param $text
     * @param null $url
     * @param array $options
     * @return string
     */
    public static function ajaxLink($text, $url = null, $options = [])
    {
        $options['class'] = isset($options['class'])
            ? $options['class'] . ' ajax-link'
            :
            'ajax-link';
        $options['rel'] = 'noindex/nofollow';
        return parent::a($text, $url, $options);
    }

    /**
     * Generates a hyperlink tag to another sites
     * @param $text
     * @param null $url
     * @param array $options
     * @return string
     */
    public static function externalLink($text, $url = null, $options = [])
    {
        $options['rel'] = 'noindex/nofollow';
        return parent::a($text, $url, $options);
    }

}