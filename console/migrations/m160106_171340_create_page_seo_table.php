<?php

use console\components\Migration;

/**
 * Class m160106_171340_create_page_seo_table migration
 */
class m160106_171340_create_page_seo_table extends Migration
{
    /**
     * migration table name
     */
    public $tableName = '{{%page_seo}}';

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable(
            $this->tableName,
            [
                'id' => $this->primaryKey(),

                'label' => $this->string()->notNull() . ' COMMENT "Label"',
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
