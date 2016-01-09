<?php
/**
 * 
 */

namespace backend\components;
use metalguardian\fileProcessor\helpers\FPM;
use yii\helpers\Html;

/**
 * Class Formatter
 */
class Formatter extends \yii\i18n\Formatter
{
    /**
     * Formats the value as an link tag using FPM module.
     * @param mixed $value the value to be formatted
     * @param array $options
     * @return string the formatted result
     */
    public function asFile($value, $options = [])
    {
        if (!$value) {
            return $this->nullDisplay;
        }
        $file = FPM::transfer()->getData($value);

        if (in_array($file->extension, ['jpg', 'png', 'gif', 'tif', 'bmp'])) {
            $linkLabel = FPM::image($file->id, 'admin', 'file');
        } else {
            $linkLabel = FPM::getOriginalFileName($file->id, $file->base_name, $file->extension);
        }

        return Html::a(
            $linkLabel,
            FPM::originalSrc($value),
            ['target' => '_blank']
        );
    }
}
