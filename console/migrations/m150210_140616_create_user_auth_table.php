<?php

use yii\db\Schema;
use console\components\Migration;

/**
 * Class m150210_140616_create_user_auth_table migration
 */
class m150210_140616_create_user_auth_table extends Migration
{
    /**
     * migration table name
     */
    public $tableName = '{{%user_auth}}';

    /**
     * related table name, to make constraints
     */
    public $tableNameRelated = '{{%user}}';

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable(
            $this->tableName,
            [
                'id' => Schema::TYPE_PK,

                'user_id' => Schema::TYPE_INTEGER . ' NOT NULL COMMENT "User"',
                'source' => Schema::TYPE_STRING . ' NOT NULL COMMENT "Source"',
                'source_id' => Schema::TYPE_STRING . ' NOT NULL COMMENT "Source id"',

                'created_at' => Schema::TYPE_INTEGER . ' NOT NULL COMMENT "Created at"',
                'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL COMMENT "Updated at"',
            ],
            $this->tableOptions
        );

        $this->addForeignKey(
            'fk-user_auth-user_id-user-id',
            $this->tableName,
            'user_id',
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
