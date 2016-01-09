<?php

namespace frontend\modules\article\controllers;

use frontend\components\FrontendController;
use frontend\modules\article\models\Article;
use common\models\PageSeo;
use frontend\modules\article\models\ArticleCategory;
use yii\data\ActiveDataProvider;
use notgosu\yii2\modules\metaTag\components\MetaTagRegister;
use yii\web\NotFoundHttpException;

class DefaultController extends FrontendController
{
    public function actionIndex()
    {
        return $this->commonAction();
    }

    public function actionCategory($alias)
    {
        $model = ArticleCategory::find()
            ->andWhere(['alias' => $alias])
            ->isPublished()
            ->one();

        if (!$model) {
            throw new NotFoundHttpException(\Yii::t('app', 'Page not found'));
        }

        return $this->commonAction($model);
    }

    /**
     * @param $categoryModel ArticleCategory|null
     * @return string
     */
    public function commonAction($categoryModel = null)
    {
        $query = Article::find()
            ->from(['t' => Article::tableName()])
            ->joinWith(['category', 'titleImage'])
            ->andWhere(['t.published' => 1])
            ->groupBy('id')
            ->orderBy('position DESC, date DESC');
        if ($categoryModel) {
            $query->andWhere(['category_id' => $categoryModel->id]);
            MetaTagRegister::register($categoryModel);
            $categoryLabel = $categoryModel->label;
        } else {
            PageSeo::registerSeo(PageSeo::ID_HOME_PAGE);
            $categoryLabel = \Yii::t('app', 'All articles');
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Article::PAGE_SIZE,
                'pageSizeParam' => false
            ],
        ]);

        return $this->render('index', ['dataProvider' => $dataProvider, 'categoryLabel' => $categoryLabel]);
    }

    public function actionView($alias)
    {
        /** @var Article $model */
        $model = Article::find()
            ->from(['t' => Article::tableName()])
            ->joinWith(['titleImage', 'category'])
            ->andWhere(['t.alias' => $alias, 't.published' => 1])
            ->one();

        if (!$model) {
            throw new NotFoundHttpException(\Yii::t('app', 'Page not found'));
        }

        $model->views = $model->views + 1;
        $model->save(false);

        MetaTagRegister::register($model);

        if (\Yii::$app->request->isAjax) {
            return $this->renderAjax('view', ['model' => $model]);
        }

        return $this->render('view', ['model' => $model]);
    }
}
