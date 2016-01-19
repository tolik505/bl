<?php

use console\components\Migration;

/**
 * Class m160119_155501_create_mail_request migration
 */
class m160119_155501_create_mail_request extends Migration
{
    /**
     * migration table name
     */
    public $tableName = '{{%mail_request}}';

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable(
            $this->tableName,
            [
                'id' => $this->primaryKey(),

                'label' => $this->string()->notNull() . ' COMMENT "Email"',
                'language' => $this->string()->notNull() . ' COMMENT "Language"',
                'status' => $this->smallInteger(1)->notNull()->defaultValue(0) . ' COMMENT "Status"',

                'created_at' => $this->integer()->notNull() . ' COMMENT "Created at"',
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
