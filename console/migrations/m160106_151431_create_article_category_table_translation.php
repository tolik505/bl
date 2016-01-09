<?php

use console\components\Migration;

/**
 * Class m160106_151431_create_article_category_table_translation migration
 */
class m160106_151431_create_article_category_table_translation extends Migration
{
    /**
     * Migration related table name
     */
    public $tableName = '{{%article_category_translation}}';

    /**
     * main table name, to make constraints
     */
    public $tableNameRelated = '{{%article_category}}';

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable(
            $this->tableName,
            [
                'model_id' => $this->integer()->notNull() . ' COMMENT "Related model id"',
                'language' => $this->string(16)->notNull() . ' COMMENT "Язык"',

                'label' => $this->string() . ' COMMENT "Label"',
            ],
            $this->tableOptions
        );

        $this->addPrimaryKey('', $this->tableName, ['model_id', 'language']);

        $this->addForeignKey(
            'fk-article_category_translation-model_id-article_category-id',
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
