<?php

use yii\db\Schema;
use console\components\Migration;

/**
 * Class m150420_112051_create_source_message_table migration
 */
class m150420_112051_create_source_message_table extends Migration
{
    /**
     * migration table name
     */
    public $tableName = '{{%source_message}}';

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable(
            $this->tableName,
            [
                'id' => Schema::TYPE_PK,

                'category' => Schema::TYPE_STRING . '(32)',
                'message' => Schema::TYPE_TEXT,
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
