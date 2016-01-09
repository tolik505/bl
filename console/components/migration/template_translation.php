<?php
/**
 * This view is used by console/controllers/MigrateController.php
 * The following variables are available in this view:
 */
/* @var $className string the new migration class name */
/* @var $tableName string the new migration table name */

echo "<?php\n";
?>

use console\components\Migration;

/**
 * Class <?= $className ?> migration
 */
class <?= $className ?> extends Migration
{
    /**
     * Migration related table name
     */
    public $tableName = '{{%<?= $tableName . '_translation' ?>}}';

    /**
     * main table name, to make constraints
     */
    public $tableNameRelated = '{{%<?= $tableName ?>}}';

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

                // examples:
                //'label' => $this->string() . ' COMMENT "Label"',
                //'content' => $this->text() . ' COMMENT "Content"',
            ],
            $this->tableOptions
        );

        $this->addPrimaryKey('', $this->tableName, ['model_id', 'language']);

        $this->addForeignKey(
            'fk-<?= $tableName . '_translation' ?>-model_id-<?= $tableName ?>-id',
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
