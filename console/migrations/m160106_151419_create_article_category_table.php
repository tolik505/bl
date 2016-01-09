<?php

use console\components\Migration;

/**
 * Class m160106_151419_create_article_category_table migration
 */
class m160106_151419_create_article_category_table extends Migration
{
    /**
     * migration table name
     */
    public $tableName = '{{%article_category}}';

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
                'alias' => $this->string()->notNull()->unique() . ' COMMENT "Alias"',

                'published' => $this->boolean()->notNull()->defaultValue(1) . ' COMMENT "Published"',
                'position' => $this->integer()->notNull()->defaultValue(0) . ' COMMENT "Position"',
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
