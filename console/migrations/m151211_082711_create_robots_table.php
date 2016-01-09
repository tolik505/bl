<?php

use yii\db\Schema;
use console\components\Migration;

/**
 * Class m151211_082711_create_robots_table migration
 */
class m151211_082711_create_robots_table extends Migration
{
    /**
     * migration table name
     */
    public $tableName = '{{%robots}}';

    /**
     * @inheritdoc
     */
    public function safeUp()
    {
        $this->createTable(
            $this->tableName,
            [
                'id' => Schema::TYPE_PK,
                'text' => Schema::TYPE_TEXT . ' NULL DEFAULT NULL COMMENT "Text"',
            ],
            $this->tableOptions
        );

        $this->insert($this->tableName, [
               'text' => 'User-agent: *
Disallow:'
            ]);
    }

    /**
     * @inheritdoc
     */
    public function safeDown()
    {
        $this->dropTable($this->tableName);
    }
}
