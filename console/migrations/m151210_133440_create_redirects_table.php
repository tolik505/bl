<?php

use yii\db\Schema;
use console\components\Migration;

/**
 * Class m151210_133440_create_redirects_table migration
 */
class m151210_133440_create_redirects_table extends Migration
{
    /**
     * migration table name
     */
    public $tableName = '{{%redirects}}';

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable(
            $this->tableName,
            [
                'id' => Schema::TYPE_PK,

                'from' => Schema::TYPE_STRING . ' NOT NULL COMMENT "From"',
                'to' => Schema::TYPE_STRING . ' NOT NULL COMMENT "To"',

                'is_active' => Schema::TYPE_SMALLINT . '(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT "Is active"',

                'created_at' => Schema::TYPE_INTEGER . ' NOT NULL COMMENT "Created"',
                'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL COMMENT "Modified"',
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
