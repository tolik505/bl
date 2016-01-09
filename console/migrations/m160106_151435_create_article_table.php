<?php

use console\components\Migration;

/**
 * Class m160106_151435_create_article_table migration
 */
class m160106_151435_create_article_table extends Migration
{
    /**
     * migration table name
     */
    public $tableName = '{{%article}}';

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
                'category_id' => $this->integer()->defaultValue(null) . ' COMMENT "Article category"',
                'announce' => $this->text()->defaultValue(null) . ' COMMENT "Announce"',
                'content' => $this->text()->notNull() . ' COMMENT "Content"',
                'date' => $this->date()->notNull() . ' COMMENT "Date"',
                'tags' => $this->string()->defaultValue(null) . ' COMMENT "Tags"',
                'views' => $this->integer()->notNull()->defaultValue(0) . ' COMMENT "Views"',

                'published' => $this->boolean()->notNull()->defaultValue(1) . ' COMMENT "Published"',
                'position' => $this->integer()->notNull()->defaultValue(0) . ' COMMENT "Position"',

                'created_at' => $this->integer()->notNull() . ' COMMENT "Created at"',
                'updated_at' => $this->integer()->notNull() . ' COMMENT "Updated at"',
            ],
            $this->tableOptions
        );

        $this->addForeignKey(
            'fk-article-category_id-article_category-id',
            $this->tableName,
            'category_id',
            'article_category',
            'id',
            'SET NULL',
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
