<?php

namespace backend\modules\configuration\components;

use backend\modules\configuration\components\ConfigurationModel;
use backend\modules\configuration\models\Testing;
use common\helpers\LanguageHelper;
use Yii;
use yii\web\Controller;

/**
 * ConfigurationController implements the CRUD actions for Configuration model.
 */
abstract class ConfigurationController extends Controller
{
    /**
     * Have to return Model::className()
     *
     * @inheritdoc
     */
    abstract public function getModelClass();

    /**
     * @return string|\yii\web\Response
     */
    public function actionUpdate()
    {
        $class = $this->getModelClass();
        /** @var ConfigurationModel $model */
        $model = new $class();

        if ($this->loadModels($model) && $model->save()) {
            return $this->redirect(['view']);
        }

        return $this->render('/configuration/templates/update', [
            'model' => $model,
        ]);
    }

    /**
     * @return mixed
     */
    public function actionView()
    {
        $class = $this->getModelClass();
        /** @var ConfigurationModel $model */
        $model = new $class();
        return $this->render('/configuration/templates/view', [
            'model' => $model,
        ]);
    }

    /**
     * @param ConfigurationModel $model
     *
     * @return bool
     */
    public function loadModels($model)
    {
        $loaded = true;

        //\common\helpers\Dump::dump(Yii::$app->request->post(), 1);

        $models = $model->getModels();

        foreach ($models as $key => $item) {
            if ($item instanceof \common\components\model\Translateable) {
                $languages = LanguageHelper::getLanguageModels();

                $items = [];
                foreach ($languages as $language) {
                    if ($language->locale === LanguageHelper::getDefaultLanguage()->locale) {
                        continue;
                    }
                    $items[$language->locale]= $item->getTranslation($language->locale);
                }

                $loaded &= ConfigurationModel::loadMultiple($items, Yii::$app->request->post(), null, $key);
            }
        }

        return $loaded & ConfigurationModel::loadMultiple($models, Yii::$app->request->post());
    }
}
