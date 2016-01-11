<?php
namespace frontend\controllers;

use frontend\modules\article\models\Article;
use common\models\PageSeo;
use common\models\Robots;
use frontend\components\FrontendController;
use yii\base\UserException;
use yii\data\ActiveDataProvider;
use yii\web\HttpException;
use yii\web\NotFoundHttpException;
use Yii;

/**
 * Site controller
 */
class SiteController extends FrontendController
{
    public function actionIndex()
    {
        $query = Article::find()
            ->from(['t' => Article::tableName()])
            ->joinWith(['category', 'titleImage'])
            ->andWhere(['t.published' => 1])
            ->groupBy('id')
            ->orderBy('position DESC, date DESC');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => Article::PAGE_SIZE,
                'pageSizeParam' => false
            ],
        ]);

        PageSeo::registerSeo(PageSeo::ID_HOME_PAGE);

        return $this->render('../modules/article/views/default/index', ['dataProvider' => $dataProvider]);
    }

    public function actionRobots()
    {
        $robots = Robots::find()->one();

        if (!$robots) {
            throw new NotFoundHttpException();
        }

        $this->layout = false;

        \Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        $headers = \Yii::$app->response->headers;
        $headers->add('Content-Type', 'text/plain');

        return $this->renderContent($robots->text);
    }

    public function actionError()
    {
        if (($exception = Yii::$app->getErrorHandler()->exception) === null) {
            // action has been invoked not from error handler, but by direct route, so we display '404 Not Found'
            $exception = new HttpException(404, Yii::t('app', 'Page not found.'));
        }

        if ($exception instanceof HttpException) {
            $code = $exception->statusCode;
        } else {
            $code = $exception->getCode();
        }
        $name = Yii::t('app', 'Error');
        if ($exception instanceof UserException) {
            $message = $exception->getMessage();
        } else {
            $message = Yii::t('yii', 'An internal server error occurred.');
        }

        if (Yii::$app->getRequest()->getIsAjax()) {
            return "$name: $message";
        } else {
            return $this->render('error', [
                'name' => $name,
                'code' => $code,
                'message' => $message,
                'exception' => $exception,
            ]);
        }
    }
}
