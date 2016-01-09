<?php
/**
 * @author walter
 */

namespace common\components;


use yii\helpers\Url;

class UrlManager extends \codemix\localeurls\UrlManager {

    /**
     * @var string page parameter default name
     */
    public $pageParam = 'page';

    /**
     * @inheritdoc
     */
    public function parseRequest($request)
    {
        $parent = parent::parseRequest($request);
        if ($parent && (isset($parent[1][$this->pageParam]) || $request->get($this->pageParam) != null)) {
            $this->checkPagerUrl($parent[0], $parent[1]);
        }
        return $parent;
    }

    /**
     * @param $route
     * @param $params
     */
    public function checkPagerUrl($route, $params)
    {
        $params = array_merge($_GET, $params);
        if ($params[$this->pageParam] === '1' || $params[$this->pageParam] === '0') {
            $this->redirectToCorrectPagerUrl($this->generateCorrectPagerUrl($route, $params));
        }
    }

    /**
     * @param $route
     * @param $params
     * @return string
     */
    public function generateCorrectPagerUrl($route, $params)
    {
        $routeArr = [];
        $routeArr[] = '/'.$route;
        unset($params[$this->pageParam]);
        $route = array_merge($routeArr, $params);
        return Url::toRoute($route);
    }

    /**
     * @param $url
     */
    public function redirectToCorrectPagerUrl($url)
    {
        \Yii::$app->response->redirect($url);
    }

} 