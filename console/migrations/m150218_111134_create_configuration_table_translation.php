<?php

use yii\db\Schema;
use console\components\Migration;

/**
 * Class m150218_111134_create_configuration_table_translation migration
 */
class m150218_111134_create_configuration_table_translation extends Migration
{
    /**
     * Migration related table name
     */
    public $tableName = '{{%configuration_translation}}';

    /**
     * main table name, to make constraints
     */
    public $tableNameRelated = '{{%configuration}}';

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable(
            $this->tableName,
            [
                'model_id' => 'CHAR(100) NOT NULL COMMENT "Related model id"',
                'language' => Schema::TYPE_STRING . '(16) NOT NULL COMMENT "Language"',

                'value' => Schema::TYPE_TEXT . ' COMMENT "Value"',
            ],
            $this->tableOptions
        );

        $this->addPrimaryKey('', $this->tableName, ['model_id', 'language']);

        $this->addForeignKey(
            'fk-configuration_translation-model_id-configuration-id',
            $this->tableName,
            'model_id',
            $this->tableNameRelated,
            'id',
            'CASCADE',
            'CASCADE'
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
