<?php

use yii\db\Schema;
use console\components\Migration;

/**
 * Class m150210_132500_create_language_model migration
 */
class m150210_132500_create_language_model extends Migration
{
    /**
     * migration table name
     */
    public $tableName = '{{%language}}';

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable(
            $this->tableName,
            [
                'id' => Schema::TYPE_PK,

                'label' => Schema::TYPE_STRING. '(20) NOT NULL COMMENT "Label"',
                'code' => Schema::TYPE_STRING. '(5) NOT NULL COMMENT "Code"',
                'locale' => Schema::TYPE_STRING. '(5) NOT NULL COMMENT "Locale"',

                'published' => Schema::TYPE_SMALLINT . '(1) UNSIGNED NOT NULL DEFAULT 1 COMMENT "Published"',
                'position' => Schema::TYPE_INTEGER . ' UNSIGNED NOT NULL DEFAULT 0 COMMENT "Position"',

                'is_default' => Schema::TYPE_SMALLINT . '(1) NOT NULL DEFAULT 0 COMMENT "Is language is default"',

                'created_at' => Schema::TYPE_INTEGER . ' NOT NULL COMMENT "Created at"',
                'updated_at' => Schema::TYPE_INTEGER . ' NOT NULL COMMENT "Updated at"',

                'UNIQUE key_unique_code (code)',
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
