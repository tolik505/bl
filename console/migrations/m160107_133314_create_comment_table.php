<?php

use console\components\Migration;

/**
 * Class m160107_133314_create_comment_table migration
 */
class m160107_133314_create_comment_table extends Migration
{
    /**
     * migration table name
     */
    public $tableName = '{{%comment}}';

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable(
            $this->tableName,
            [
                'id' => $this->primaryKey(),

                'model_name' => $this->string()->notNull(),
                'model_id' => $this->integer()->notNull(),
                'user_id' => $this->integer()->defaultValue(null) . ' COMMENT "User"',
                'name' => $this->string()->defaultValue(null) . ' COMMENT "Name"',
                'content' => $this->text()->notNull() . ' COMMENT "Content"',
                'tree' => $this->integer()->defaultValue(null),
                'lft' => $this->integer()->notNull(),
                'rgt' => $this->integer()->notNull(),
                'depth' => $this->integer()->notNull(),
                'status_id' => $this->smallInteger(2)->notNull()->defaultValue(0) . ' COMMENT "Status"',

                'published' => $this->boolean()->notNull()->defaultValue(1) . ' COMMENT "Published"',
                'position' => $this->integer()->notNull()->defaultValue(0) . ' COMMENT "Position"',

                'created_at' => $this->integer()->notNull() . ' COMMENT "Created at"',
                'updated_at' => $this->integer()->notNull() . ' COMMENT "Updated at"',
            ],
            $this->tableOptions
        );

        $this->addForeignKey(
            'fk-comment-user_id-user-id',
            $this->tableName,
            'user_id',
            \common\models\User::tableName(),
            'id',
            'SET NULL',
            'CASCADE'
        );
    }

    /**
     * commands will be executed in transaction
     */
    public function safeDown()
    {
        $this->dropTable($this->tableName);
    }
}
