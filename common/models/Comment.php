<?php

namespace common\models;

use common\components\model\CommentQuery;
use creocoder\nestedsets\NestedSetsBehavior;
use Yii;
use yii\helpers\Url;

/**
 * @inheritdoc
 *
 * @property User $user
 */
class Comment extends \common\models\base\Comment
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return \yii\helpers\ArrayHelper::merge(parent::behaviors(), [
            'timestamp' => [
                'class' => \yii\behaviors\TimestampBehavior::className(),
            ],
            'tree' => [
                'class' => NestedSetsBehavior::className(),
                'treeAttribute' => 'tree'
            ],
        ]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @param $params array
     * @return string
     */
    public static function getAddCommentUrl($params = [])
    {
        return Url::toRoute(['/comment/default/add-comment', $params]);
    }

    /**
     * @return string
     */
    public function getAuthorName()
    {
        if ($this->user_id){
            return $this->user->username;
        }
        return $this->name;
    }

    public function getChildren()
    {
        return $this->children()->all();
    }

    public function makeRootIfNotExist()
    {
        $root = $this->getRoot();
        if (!$root) {
            $root = new Comment();
            $root->model_name = $this->model_name;
            $root->model_id = $this->model_id;
            $root->content = 'root';
            $root->name = 'root';
            $root->makeRoot();
        }

        return $root;
    }

    public function getRoot()
    {
        return Comment::find()
            ->where(['model_name' => $this->model_name])
            ->where(['model_id' => $this->model_id])
            ->roots()
            ->one();
    }

    public static function find()
    {
        return new CommentQuery(get_called_class());
    }
}
