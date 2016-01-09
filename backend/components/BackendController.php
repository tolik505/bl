<?php
/**
 * Author: metal
 * Email: metal
 */

namespace backend\components;

use common\helpers\LanguageHelper;
use vova07\imperavi\actions\GetAction;
use vova07\imperavi\actions\UploadAction;
use Yii;
use yii\base\Model;
use yii\base\NotSupportedException;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Class BackendController
 * @package backend\components
 */
abstract class BackendController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => [\common\models\User::ROLE_ADMIN],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }

    /**
     * @throws NotSupportedException
     * @return string
     */
    abstract public function getModelClass();

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'images-get' => [
                'class' => GetAction::className(),
                'url' => '/uploads/redactor/', // Directory URL address, where files are stored.
                'path' => '@webroot/uploads/redactor',
                'type' => GetAction::TYPE_IMAGES,
                'options' => [
                    'basePath' => Yii::getAlias('@webroot/uploads/redactor'),
                    'except' => ['.gitkeep']
                ]

            ],
            'image-upload' => [
                'class' => UploadAction::className(),
                'url' => '/uploads/redactor/', // Directory URL address, where files are stored.
                'path' => 'uploads/redactor' // Absolute path to directory where files are stored.
            ],
        ];
    }

    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

    /**
     * Lists all Menu models.
     * @return mixed
     */
    public function actionIndex()
    {
        $class = $this->getModelClass();
        /** @var BackendModel $searchModel */
        $searchModel = (new $class)->getSearchModel();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('//templates/index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Menu model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('//templates/view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Menu model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $class = $this->getModelClass();
        /** @var \yii\db\ActiveRecord $model */
        $model = new $class();
        $model->loadDefaultValues();

        if ($this->loadModels($model) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('//templates/create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * @param \yii\db\ActiveRecord $model
     *
     * @return bool
     */
    public function loadModels($model)
    {
        $loaded = true;
        if ($model instanceof \common\components\model\Translateable) {
            $languages = LanguageHelper::getLanguageModels();

            $models = [];
            foreach ($languages as $language) {
                if ($language->locale === LanguageHelper::getDefaultLanguage()->locale) {
                    continue;
                }
                $models[$language->locale]= $model->getTranslation($language->locale);
            }

            if (!empty($models)) {
                $loaded &= Model::loadMultiple($models, Yii::$app->request->post());
            }
        }

        $loaded = $model->load(Yii::$app->request->post()) && $loaded;

        return $loaded;
    }

    /**
     * Updates an existing Menu model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->loadModels($model) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('//templates/update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Menu model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Menu model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return \yii\db\ActiveRecord the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        /** @var \yii\db\ActiveRecord $class */
        $class = $this->getModelClass();
        if (($model = $class::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
