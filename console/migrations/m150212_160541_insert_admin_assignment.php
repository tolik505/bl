<?php

use yii\base\InvalidConfigException;
use yii\db\Schema;
use console\components\Migration;
use yii\rbac\DbManager;

/**
 * Class m150212_160541_insert_admin_assignment migration
 */
class m150212_160541_insert_admin_assignment extends Migration
{
    /**
     * @throws yii\base\InvalidConfigException
     * @return DbManager
     */
    protected function getAuthManager()
    {
        $authManager = Yii::$app->getAuthManager();
        if (!$authManager instanceof DbManager) {
            throw new InvalidConfigException('You should configure "authManager" component to use database before executing this migration.');
        }
        return $authManager;
    }

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $authManager = $this->getAuthManager();
        $this->db = $authManager->db;

        $userId = \common\models\User::findByEmail('admin@dev.dev')->id;

        $this->insert($authManager->assignmentTable, [
            'item_name' => \common\models\User::ROLE_ADMIN,
            'user_id' => $userId,
            'created_at' => time(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $authManager = $this->getAuthManager();
        $this->db = $authManager->db;

        $userId = \common\models\User::findByEmail('admin@dev.dev')->id;

        $this->delete($authManager->assignmentTable, ['user_id' => $userId]);
    }
}
