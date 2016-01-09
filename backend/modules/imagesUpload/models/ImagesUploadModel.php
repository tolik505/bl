<?php
/**
 * Created by PhpStorm.
 * User: anatolii
 * Date: 23.12.15
 * Time: 18:27
 */
namespace backend\modules\imagesUpload\models;

use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

class ImagesUploadModel extends Model
{
    /**
     * @param array $params
     * @return string
     */
    public static function uploadUrl($params = [])
    {
        return Url::toRoute(ArrayHelper::merge(['/imagesUpload/default/upload-image'], $params));
    }

    /**
     * @param array $params
     * @return string
     */
    public static function sortImagesUrl($params = [])
    {
        return Url::toRoute(ArrayHelper::merge(['/imagesUpload/default/sort-images'], $params));
    }

    /**
     * @param array $params
     * @return string
     */
    public static function getCropUrl($params = [])
    {
        return Url::toRoute(ArrayHelper::merge(['/imagesUpload/default/crop'], $params));
    }

    /**
     * @param array $params
     * @return string
     */
    public static function getSaveCroppedImageUrl($params = [])
    {
        return Url::toRoute(ArrayHelper::merge(['/imagesUpload/default/save-cropped-image'], $params));
    }

    /**
     * @param array $params
     * @return string
     */
    public static function deleteImageUrl($params = [])
    {
        return Url::toRoute(ArrayHelper::merge(['/imagesUpload/default/delete-image'], $params));
    }
}
