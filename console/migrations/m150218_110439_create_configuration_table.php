<?php

use yii\db\Schema;
use console\components\Migration;

/**
 * Class m150218_110439_create_configuration_table migration
 */
class m150218_110439_create_configuration_table extends Migration
{
    /**
     * migration table name
     */
    public $tableName = '{{%configuration}}';

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable(
            $this->tableName,
            [
                'id' => 'CHAR(100) PRIMARY KEY COMMENT "Key"',
                'value' => Schema::TYPE_TEXT . ' NULL DEFAULT NULL COMMENT "Value"',
                'type' => Schema::TYPE_INTEGER . ' NOT NULL COMMENT "Field type"',

                'description' => Schema::TYPE_STRING . ' NULL DEFAULT NULL COMMENT "Description"',

                'preload' => Schema::TYPE_SMALLINT . '(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT "Preload"',
                'published' => Schema::TYPE_SMALLINT . '(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT "Published"',

                'created_at' => Schema::TYPE_INTEGER . ' NOT NULL COMMENT "Created at"',
                'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL COMMENT "Updated at"',
            ],
            $this->tableOptions
        );
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable($this->tableName);
    }
}
