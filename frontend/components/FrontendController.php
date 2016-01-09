<?php
/**
 * @author walter
 */

namespace frontend\components;


use yii\helpers\Url;
use yii\web\Controller;

class FrontendController extends Controller {

    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            $this->view->registerLinkTag(['rel' => 'canonical', 'href' => Url::canonical()]);

            if (\Yii::$app->request->get('page') == 1) {
                $this->redirect(str_replace('/page/1', '', \Yii::$app->request->getUrl()));
            }

            return true;
        } else {
            return false;
        }
    }

    /**
     * Redirects the browser to the specified URL.
     * This method is a shortcut to [[Response::redirect()]].
     *
     * You can use it in an action by returning the [[Response]] directly:
     *
     * ```php
     * // stop executing this action and redirect to login page
     * return $this->redirect(['login']);
     * ```
     *
     * @param string|array $url the URL to be redirected to. This can be in one of the following formats:
     *
     * - a string representing a URL (e.g. "http://example.com")
     * - a string representing a URL alias (e.g. "@example.com")
     * - an array in the format of `[$route, ...name-value pairs...]` (e.g. `['site/index', 'ref' => 1]`)
     *   [[Url::to()]] will be used to convert the array into a URL.
     *
     * Any relative URL will be converted into an absolute one by prepending it with the host info
     * of the current request.
     *
     * @param integer $statusCode the HTTP status code. Defaults to 302.
     * See <http://www.w3.org/Protocols/rfc2616/rfc2616-sec10.html>
     * for details about HTTP status code
     * @return Response the current response object
     */
    public function redirect($url, $statusCode = 301)
    {
        return \Yii::$app->getResponse()->redirect(Url::to($url), $statusCode);
    }
} 
