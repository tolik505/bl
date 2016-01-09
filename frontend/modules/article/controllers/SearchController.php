<?php

namespace frontend\modules\article\controllers;

use frontend\components\FrontendController;
use frontend\modules\article\models\Article;
use common\models\PageSeo;
use frontend\modules\article\models\ArticleCategory;
use yii\data\ActiveDataProvider;
use notgosu\yii2\modules\metaTag\components\MetaTagRegister;
use yii\web\NotFoundHttpException;

class SearchController extends FrontendController
{
    public function actionIndex($query)
    {
        $queryData = Article::find()
            ->from(['t' => Article::tableName()])
            ->joinWith(['category', 'titleImage'])
            ->andWhere(['t.published' => 1])
            ->andWhere('t.label LIKE :query OR t.content LIKE :query OR t.tags LIKE :query', [':query' => "%$query%"])
            ->groupBy('id')
            ->orderBy('t.position DESC, t.date DESC');

        $dataProvider = new ActiveDataProvider([
            'query' => $queryData,
            'pagination' => [
                'pageSize' => Article::PAGE_SIZE,
                'pageSizeParam' => false
            ],
        ]);

        return $this->render('../default/index', [
            'dataProvider' => $dataProvider,
            'query' => $query,
            'categoryLabel' => \Yii::t('app', 'Search')
        ]);
    }
}
