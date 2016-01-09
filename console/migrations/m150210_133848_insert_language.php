<?php

use yii\db\Schema;
use console\components\Migration;

/**
 * Class m150210_133848_insert_language migration
 */
class m150210_133848_insert_language extends Migration
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
        $this->insert($this->tableName, [
            'label' => 'eng',
            'code' => 'en',
            'locale' => 'en',

            'published' => 1,
            'position' => 0,

            'is_default' => 1,

            'created_at' => time(),
            'updated_at' => time(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->truncateTable($this->tableName);
    }
}
