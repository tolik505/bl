<?php

namespace backend\modules\imagesUpload\controllers;

use backend\components\BackendController;
use backend\modules\imagesUpload\models\ImagesUploadModel;
use Yii;
use common\models\EntityToFile;
use metalguardian\fileProcessor\components\Image;
use metalguardian\fileProcessor\helpers\FPM;
use metalguardian\fileProcessor\models\File;
use yii\helpers\FileHelper;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\web\UploadedFile;

/**
 * DefaultController implements the CRUD actions for Configuration model.
 */
class DefaultController extends BackendController
{
    /**
     * @inheritdoc
     */
    public function getModelClass()
    {
        return ImagesUploadModel::className();
    }

    /**
     * @return string
     */
    public function actionUploadImage()
    {
        $returnData = [];

        $className = \Yii::$app->request->get('model_name');
        $attribute = \Yii::$app->request->get('attribute');
        if ($className && $attribute){
            $model = new $className;
            $modelName = $model->formName();

            $files = UploadedFile::getInstances($model,  $attribute);
            foreach ($files as $file) {
                $originalName = $file->baseName.'.'.$file->extension;

                $fileId = FPM::transfer()->saveUploadedFile($file);
                if ($fileId) {
                    $existModelId = \Yii::$app->request->post('id');
                    $tempSign = \Yii::$app->request->post('sign');

                    $savedImage = EntityToFile::add(
                        $modelName,
                        $existModelId,
                        $fileId,
                        $tempSign,
                        \Yii::$app->request->get('entity_attribute')
                    );

                    if (!$savedImage) {
                        $returnData['error'][] = 'Не получилось связать файл '.$originalName.' с моделью';
                    } else {
                        $returnData = [
                            'deleteUrl' => ImagesUploadModel::deleteImageUrl(['id' => $savedImage->id]),
                            'cropUrl' => ImagesUploadModel::getCropUrl(['id' => $savedImage->id]),
                            'id' => $savedImage->id,
                            'imgId' => $savedImage->file_id
                        ];
                    }

                } else {
                    $returnData['error'][] = 'Не получилось сохранить файл '.$originalName;
                }
            }
        }

        return Json::encode($returnData);
    }

    /**
     * @return string
     */
    public function actionDeleteImage()
    {
        $returnData = [];

        $id = \Yii::$app->request->get('id');

        if ($id) {
            $imageEntity = EntityToFile::find()->where('id = :id', [':id' => (int)$id])->one();

            if ($imageEntity) {
                $fileId = $imageEntity->file_id;
                if ($imageEntity->delete()) {
                    FPM::deleteFile($fileId);
                } else {
                    $returnData[] = ['error' => 'Не удалось удалить файл'];
                }

            } else {
                $returnData[] = ['error' => 'Информация о изображении не найдена'];
            }

        }

        return Json::encode($returnData);
    }


    public function actionSortImages()
    {
        $sortOrder = \Yii::$app->request->post('sort');

        if ($sortOrder) {
            $sortOrder = explode(',', $sortOrder);
            $i = count($sortOrder);
            foreach ($sortOrder as $fileId) {
                \Yii::$app->db->createCommand()->update(
                    EntityToFile::tableName(),
                    [
                        'position' => $i
                    ],
                    'id = :id',
                    [':id' => (int)$fileId]
                )->execute();

                $i--;
            }
        }

        echo Json::encode([]);
    }

    /**
     * @return string
     */
    public function actionCrop()
    {
        $fileId = \Yii::$app->request->get('id');

        if (!$fileId) {
            return 'Кроп доступен только после загрузки изображения';
        }

        $imageEntity = EntityToFile::find()->where('id = :id', [':id' => (int)$fileId])->one();

        return $this->renderAjax('_crop_image', [
            'id' => $imageEntity ? $imageEntity->file_id : null,
        ]);
    }

    /**
     * @return string
     */
    public function actionSaveCroppedImage()
    {
        $data = \Yii::$app->request->post('data');
        $data = $data ? Json::decode($data) : null;

        if ($data) {
            $fileId = $data['fileId'];

            $imageEntity = EntityToFile::find()->where('file_id = :id', [':id' => (int)$fileId])->one();

            if ($imageEntity) {
                //Find original img path
                $directory = FPM::getOriginalDirectory($imageEntity->file_id);
                FileHelper::createDirectory($directory, 0777, true);
                $fileName =
                    $directory
                    . DIRECTORY_SEPARATOR
                    . FPM::getOriginalFileName(
                        $imageEntity->file_id,
                        $imageEntity->file->base_name,
                        $imageEntity->file->extension
                    );
                //Delete cached image
                FPM::cache()->delete($imageEntity->file_id);
                //Delete thumbs
                $this->clearImageThumbs($imageEntity->file);

                Image::crop($fileName, $data['width'], $data['height'], $data['startX'], $data['startY'])
                    ->save($fileName);

                return Json::encode(
                    [
                        'replaces' => [
                            [
                                'what' => '#preview-image-' . $imageEntity->file_id,
                                'data' => Html::img(
                                    FPM::originalSrc($imageEntity->file_id).'?'.time(),
                                    [
                                        'class' => 'file-preview-image',
                                        'id' => 'preview-image-' . $imageEntity->file_id
                                    ]
                                )
                            ]
                        ],
                        'js' => Html::script('hideModal(".modal")')
                    ]
                );
            }
        }
    }


    /**
     * Delete all previously generated image thumbs
     *
     * @param File $model
     */
    protected function clearImageThumbs(File $model)
    {
        $fp = \Yii::$app->getModule('fileProcessor');

        if ($fp) {
            $imageSections = $fp->imageSections;

            foreach ($imageSections as $moduleName => $config) {

                foreach ($config as $size => $data) {
                    $thumbnailFile = FPM::getThumbnailDirectory($model->id, $moduleName, $size) . DIRECTORY_SEPARATOR .
                        FPM::getThumbnailFileName($model->id, $model->base_name, $model->extension);

                    if (is_file($thumbnailFile)) {
                        unlink($thumbnailFile);
                    }
                }
            }
        }
    }
}
