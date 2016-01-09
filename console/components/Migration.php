<?php
/**
 * Author: metal
 * Email: metal
 */

namespace console\components;

/**
 * Class Migration
 * @package console\components
 */
class Migration extends \yii\db\Migration
{
    public $tableOptions;
    public function init()
    {
        parent::init();

        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }
        $this->tableOptions = $tableOptions;
    }
}
