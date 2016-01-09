<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\components\gii\module;
use yii\gii\CodeFile;
use yii\helpers\StringHelper;

/**
 * @inheritdoc
 */
class Generator extends \yii\gii\generators\module\Generator
{
    public $enableI18N = true;

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'Advanced Module Generator';
    }

    /**
     * @inheritdoc
     */
    public function generate()
    {
        $files = [];
        $modulePath = $this->getModulePath();

        $files[] = new CodeFile(
            $modulePath . '/' . StringHelper::basename($this->moduleClass) . '.php',
            $this->render("module.php")
        );
        $files[] = new CodeFile(
            $modulePath . '/controllers/.gitkeep',
            ''
        );
        $files[] = new CodeFile(
            $modulePath . '/views/.gitkeep',
            ''
        );
        $files[] = new CodeFile(
            $modulePath . '/models/.gitkeep',
            ''
        );

        return $files;
    }
}
