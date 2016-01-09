<?php

use yii\db\Schema;
use console\components\Migration;

/**
 * Class m150420_112058_create_message_table migration
 */
class m150420_112058_create_message_table extends Migration
{
    /**
     * migration table name
     */
    public $tableName = '{{%message}}';

    /**
     * main table name, to make constraints
     */
    public $tableNameRelated = '{{%source_message}}';

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable(
            $this->tableName,
            [
                'id' => Schema::TYPE_INTEGER,
                'language' => Schema::TYPE_STRING . '(16)',
                'translation' => Schema::TYPE_TEXT,
            ],
            $this->tableOptions
        );
        $this->addPrimaryKey('', $this->tableName, ['id', 'language']);
        $this->addForeignKey(
            'fk-message-id-source_message-id',
            $this->tableName,
            'id',
            $this->tableNameRelated,
            'id',
            'CASCADE',
            'RESTRICT'
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
