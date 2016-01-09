<?php

use console\components\Migration;

/**
 * Class m160106_151446_create_article_table_translation migration
 */
class m160106_151446_create_article_table_translation extends Migration
{
    /**
     * Migration related table name
     */
    public $tableName = '{{%article_translation}}';

    /**
     * main table name, to make constraints
     */
    public $tableNameRelated = '{{%article}}';

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
                'announce' => $this->text() . ' COMMENT "Announce"',
                'content' => $this->text() . ' COMMENT "Content"',
                'tags' => $this->string() . ' COMMENT "Tags"',
            ],
            $this->tableOptions
        );

        $this->addPrimaryKey('', $this->tableName, ['model_id', 'language']);

        $this->addForeignKey(
            'fk-article_translation-model_id-article-id',
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
