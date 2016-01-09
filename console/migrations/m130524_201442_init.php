<?php

use console\components\Migration;
use yii\db\Schema;

class m130524_201442_init extends Migration
{
    /**
     * migration table name
     */
    public $tableName = '{{%user}}';

    public function safeUp()
    {
        $this->createTable($this->tableName, [
            'id' => Schema::TYPE_PK,

            'username' => Schema::TYPE_STRING . ' NOT NULL COMMENT "User name"',
            'auth_key' => Schema::TYPE_STRING . '(32) NOT NULL',
            'password_hash' => Schema::TYPE_STRING . ' NOT NULL',
            'password_reset_token' => Schema::TYPE_STRING,
            'email' => Schema::TYPE_STRING . ' NOT NULL COMMENT "Email"',

            'status' => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 10 COMMENT "Status"',

            'created_at' => Schema::TYPE_INTEGER . ' NOT NULL',
            'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL',
        ], $this->tableOptions);
    }

    public function safeDown()
    {
        $this->dropTable($this->tableName);
    }
}
