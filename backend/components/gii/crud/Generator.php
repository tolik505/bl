<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace backend\components\gii\crud;

use Yii;
use yii\db\Connection;
use \yii\db\TableSchema;
use yii\db\Schema;
use yii\gii\CodeFile;
use yii\helpers\ArrayHelper;
use yii\helpers\Inflector;
use yii\helpers\VarDumper;
use yii\web\Controller;
use yii\db\ActiveRecord;
use yii\db\BaseActiveRecord;

/**
 * @inheritdoc
 */
class Generator extends \yii\gii\generators\crud\Generator
{
    public $db = 'db';
    public $enableI18N = true;
    public $indexWidgetType = 'grid';
    public $template = 'advanced';
    public $baseModelClass;
    public $baseControllerClass = '\backend\components\BackendController';
    public $isImage = false;

    /**
     * @inheritdoc
     */
    public function getName()
    {
        return 'Advanced CRUD Generator';
    }

    /**
     * @inheritdoc
     */
    public function getDescription()
    {
        return 'This generator generates a controller and views that implement CRUD (Create, Read, Update, Delete)
            operations for the specified data model.';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // validation rules from base generator
            [['template'], 'required', 'message' => 'A code template must be selected.'],
            [['template'], 'validateTemplate'],

            [['controllerClass', 'modelClass', 'baseControllerClass', 'baseModelClass'], 'filter', 'filter' => 'trim'],
            [['modelClass', 'controllerClass', 'baseControllerClass', 'baseModelClass'], 'required'],
            [['modelClass', 'controllerClass', 'baseControllerClass', 'baseModelClass'], 'match', 'pattern' => '/^[\w\\\\]*$/', 'message' => 'Only word characters and backslashes are allowed.'],
            [['baseModelClass'], 'validateClass', 'params' => ['extends' => BaseActiveRecord::className()]],
            [['baseControllerClass'], 'validateClass', 'params' => ['extends' => Controller::className()]],
            [['controllerClass'], 'match', 'pattern' => '/Controller$/', 'message' => 'Controller class name must be suffixed with "Controller".'],
            [['controllerClass'], 'match', 'pattern' => '/(^|\\\\)[A-Z][^\\\\]+Controller$/', 'message' => 'Controller class name must start with an uppercase letter.'],
            [['controllerClass', 'modelClass'], 'validateNewClass'],
            [['baseModelClass'], 'validateBaseModelClass'],
            [['enableI18N', 'isImage'], 'boolean'],
            [['messageCategory'], 'validateMessageCategory', 'skipOnEmpty' => false],
            ['viewPath', 'safe'],
        ];
    }

    /**
     * Checks if model class is valid
     */
    public function validateBaseModelClass()
    {
        /* @var $class ActiveRecord */
        $class = $this->baseModelClass;
        $pk = $class::primaryKey();
        if (empty($pk)) {
            $this->addError('baseModelClass', "The table associated with $class must have primary key(s).");
        }
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return array_merge(parent::attributeLabels(), [
            'baseModelClass' => 'Base Model Class',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function hints()
    {
        return array_merge(parent::hints(), [
            'baseModelClass' => 'This is the Base ActiveRecord class associated with the table that CRUD will be built upon.
                You should provide a fully qualified class name, e.g., <code>common\models\Post</code>.',
            'modelClass' => 'This is the name of the backend model class to be generated. You should provide a fully
                qualified namespaced class name, e.g., <code>app\models\Post</code>.',
        ]);
    }

    /**
     * @inheritdoc
     */
    public function requiredTemplates()
    {
        return ['controller.php', 'model.php', 'search.php'];
    }

    /**
     * @inheritdoc
     */
    public function generate()
    {
        $controllerFile = Yii::getAlias('@' . str_replace('\\', '/', ltrim($this->controllerClass, '\\')) . '.php');

        $files = [
            new CodeFile($controllerFile, $this->render('controller.php')),
        ];

        $modelFile = Yii::getAlias('@' . str_replace('\\', '/', ltrim($this->modelClass, '\\')) . '.php');

        $files[] = new CodeFile(
            $modelFile,
            $this->render(
                'model.php',
                [
                    'viewColumns' => $this->getViewColumns(),
                    'indexColumns' => $this->getIndexColumns(),
                    'formColumns' => $this->getFormColumns(),
                ]
            )
        );

        $searchModel = Yii::getAlias('@' . str_replace('\\', '/', ltrim($this->modelClass, '\\') . 'Search.php'));
        $files[] = new CodeFile(
            $searchModel,
            $this->render(
                'search.php',
                [
                    'rules' => $this->generateSearchRules(),
                    'searchConditions' => $this->generateSearchConditions(),
                ]
            )
        );

        return $files;
    }

    /**
     * @inheritdoc
     */
    public function getNameAttribute()
    {
        foreach ($this->getColumnNames() as $name) {
            if (!strcasecmp($name, 'label') || !strcasecmp($name, 'name') || !strcasecmp($name, 'title')) {
                return $name;
            }
        }
        /* @var $class \yii\db\ActiveRecord */
        $class = $this->baseModelClass;
        $pk = $class::primaryKey();

        return $pk[0];
    }

    /**
     * Returns table schema for current model class or false if it is not an active record
     * @return boolean|\yii\db\TableSchema
     */
    public function getTableSchema()
    {
        /* @var $class ActiveRecord */
        $class = $this->baseModelClass;
        if (is_subclass_of($class, 'yii\db\ActiveRecord')) {
            return $class::getTableSchema();
        } else {
            return false;
        }
    }

    /**
     * Generates search conditions
     * @return array
     */
    public function generateSearchConditions()
    {
        $columns = [];
        if (($table = $this->getTableSchema()) === false) {
            $class = $this->baseModelClass;
            /* @var $model \yii\base\Model */
            $model = new $class();
            foreach ($model->attributes() as $attribute) {
                $columns[$attribute] = 'unknown';
            }
        } else {
            foreach ($table->columns as $column) {
                if ($this->checkNoSearchAttribute($column->name)) {
                    continue;
                }
                $columns[$column->name] = $column->type;
            }
        }

        $likeConditions = [];
        $hashConditions = [];
        foreach ($columns as $column => $type) {
            switch ($type) {
                case Schema::TYPE_SMALLINT:
                case Schema::TYPE_INTEGER:
                case Schema::TYPE_BIGINT:
                case Schema::TYPE_BOOLEAN:
                case Schema::TYPE_FLOAT:
                case Schema::TYPE_DOUBLE:
                case Schema::TYPE_DECIMAL:
                case Schema::TYPE_MONEY:
                case Schema::TYPE_DATE:
                case Schema::TYPE_TIME:
                case Schema::TYPE_DATETIME:
                case Schema::TYPE_TIMESTAMP:
                    $hashConditions[] = "'{$column}' => \$this->{$column},";
                    break;
                default:
                    $likeConditions[] = "->andFilterWhere(['like', '{$column}', \$this->{$column}])";
                    break;
            }
        }

        $conditions = [];
        if (!empty($hashConditions)) {
            $conditions[] = "\$query->andFilterWhere([\n"
                . str_repeat(' ', 12) . implode("\n" . str_repeat(' ', 12), $hashConditions)
                . "\n" . str_repeat(' ', 8) . "]);\n";
        }
        if (!empty($likeConditions)) {
            $conditions[] = "\$query" . implode("\n" . str_repeat(' ', 12), $likeConditions) . ";\n";
        }

        return $conditions;
    }

    /**
     * @param $attribute
     * @return bool
     */
    public function checkNoSearchAttribute($attribute)
    {
        static $attributes = [
            'created_at',
            'updated_at',
            'position',
        ];

        return in_array($attribute, $attributes, true);
    }

    /**
     * Generates validation rules for the search model.
     * @return array the generated validation rules
     */
    public function generateSearchRules()
    {
        if (($table = $this->getTableSchema()) === false) {
            return ["[['" . implode("', '", $this->getColumnNames()) . "'], 'safe']"];
        }
        $types = [];
        foreach ($table->columns as $column) {
            if ($this->checkNoRuleAttribute($column->name)) {
                continue;
            }
            switch ($column->type) {
                case Schema::TYPE_SMALLINT:
                case Schema::TYPE_INTEGER:
                case Schema::TYPE_BIGINT:
                    $types['integer'][] = $column->name;
                    break;
                case Schema::TYPE_BOOLEAN:
                    $types['boolean'][] = $column->name;
                    break;
                case Schema::TYPE_FLOAT:
                case Schema::TYPE_DOUBLE:
                case Schema::TYPE_DECIMAL:
                case Schema::TYPE_MONEY:
                    $types['number'][] = $column->name;
                    break;
                case Schema::TYPE_DATE:
                case Schema::TYPE_TIME:
                case Schema::TYPE_DATETIME:
                case Schema::TYPE_TIMESTAMP:
                default:
                    $types['safe'][] = $column->name;
                    break;
            }
        }

        $rules = [];
        foreach ($types as $type => $columns) {
            $rules[] = "[['" . implode("', '", $columns) . "'], '$type']";
        }

        return $rules;
    }

    /**
     * @param $attribute
     * @return bool
     */
    public function checkNoRuleAttribute($attribute)
    {
        static $attributes = [
            'created_at',
            'updated_at',
            'position',
        ];

        return in_array($attribute, $attributes, true);
    }

    /**
     * @return array
     */
    public function getViewColumns()
    {
        $columns = [];
        if (($tableSchema = $this->getTableSchema()) === false) {
            foreach ($this->getColumnNames() as $name) {
                $columns[] = "'". $name . "'";
            }
        } else {
            foreach ($this->getTableSchema()->columns as $column) {
                if ($this->checkNoViewAttribute($column->name)) {
                    continue;
                }
                $format = $this->generateColumnFormat($column);
                if ($format == 'ntext') {
                    $columns[] = "[
                        'attribute' => '$column->name',
                        'format' => 'html',
                    ]";
                } else {
                    $columns[] = "'" . $column->name . ($format === 'text' ? "" : ":" . $format) . "'";
                }
            }
        }

        return $columns;
    }

    /**
     * @param $attribute
     * @return bool
     */
    public function checkNoViewAttribute($attribute)
    {
        static $attributes = [
            'created_at',
            'updated_at',
        ];

        return in_array($attribute, $attributes, true);
    }

    /**
     * @inheritdoc
     */
    public function generateColumnFormat($column)
    {
        if (stripos($column->name, 'published') !== false) {
            return 'boolean';
        } elseif (stripos($column->name, 'file') !== false) {
            return 'file';
        } elseif ($column->phpType === 'boolean' || ($column->type === Schema::TYPE_SMALLINT && $column->size === 1)) {
            return 'boolean';
        } elseif (stripos($column->name, 'link') !== false) {
            return 'url';
        }

        return parent::generateColumnFormat($column);
    }

    /**
     * @return array
     */
    public function getIndexColumns()
    {
        $count = 0;
        $columns = [];
        if (($tableSchema = $this->getTableSchema()) === false) {
            foreach ($this->getColumnNames() as $name) {
                if (++$count < 6) {
                    $columns[] = "'". $name . "'";
                } else {
                    $columns[] = "// '". $name . "'";
                }
            }
        } else {
            foreach ($tableSchema->columns as $column) {
                if ($this->checkNoIndexAttribute($column->name)) {
                    continue;
                }
                $format = $this->generateColumnFormat($column);
                if ($count < 6 && $format !== 'ntext' && $column->name != 'id' || in_array($column->name, ['published', 'position'])) {
                    $columns[] = "'" . $column->name . ($format === 'text' ? "" : ":" . $format) . "'";
                    $count++;
                } else {
                    $columns[] = "// '" . $column->name . ($format === 'text' ? "" : ":" . $format) . "'";
                }
            }
        }

        return $columns;
    }

    /**
     * @param $attribute
     * @return bool
     */
    public function checkNoIndexAttribute($attribute)
    {
        static $attributes = [
            'created_at',
            'updated_at',
        ];

        return in_array($attribute, $attributes, true);
    }

    /**
     * @return array
     */
    public function getFormColumns()
    {
        /* @var $model \yii\db\ActiveRecord */
        $model = new $this->baseModelClass();
        $safeAttributes = $model->safeAttributes();
        if (empty($safeAttributes)) {
            $safeAttributes = $model->attributes();
        }
        $columns = [];
        foreach ($this->getColumnNames() as $attribute) {
            if (in_array($attribute, $safeAttributes)) {
                $columns[$attribute] = $this->generateFormFieldConfig($attribute);
            }
        }

        return $columns;
    }

    /**
     * @return array model column names
     */
    public function getColumnNames()
    {
        /* @var $class ActiveRecord */
        $class = $this->baseModelClass;
        if (is_subclass_of($class, 'yii\db\ActiveRecord')) {
            return $class::getTableSchema()->getColumnNames();
        } else {
            /* @var $model \yii\base\Model */
            $model = new $class();

            return $model->attributes();
        }
    }

    /**
     * Generates code for active field
     * @param string $attribute
     * @return string
     */
    public function generateFormFieldConfig($attribute)
    {
        $tableSchema = $this->getTableSchema();
        if ($tableSchema === false || !isset($tableSchema->columns[$attribute])) {
            if (preg_match('/^(password|pass|passwd|passcode)$/i', $attribute)) {
                return "[
                'type' => ActiveFormBuilder::INPUT_PASSWORD,
            ]";
            } else {
                return "[
                'type' => ActiveFormBuilder::INPUT_TEXT,
            ]";
            }
        }
        $column = $tableSchema->columns[$attribute];
        $foreignKeys = $this->getForeignKeys($tableSchema);
        if ($attribute === 'published') {
            return "[
                'type' => ActiveFormBuilder::INPUT_CHECKBOX,
            ]";
        } elseif ($column->phpType === 'boolean' || ($column->type === Schema::TYPE_SMALLINT && $column->size === 1)) {
            return "[
                'type' => ActiveFormBuilder::INPUT_CHECKBOX,
            ]";
        } elseif (stripos($column->name, 'file') !== false) {
            return "[
                'type' => ActiveFormBuilder::INPUT_FILE,
            ]";
        } elseif ($column->type === Schema::TYPE_DATE) {
            return "[
                'type' => ActiveFormBuilder::INPUT_WIDGET,
                'widgetClass' => \\metalguardian\\dateTimePicker\\Widget::className(),
                'options' => [
                    'mode' => \\metalguardian\\dateTimePicker\\Widget::MODE_DATE,
                    'options' => [
                        'class' => 'form-control',
                    ],
                ],
            ]";
        } elseif ($column->type === Schema::TYPE_TIME) {
            return "[
                'type' => ActiveFormBuilder::INPUT_WIDGET,
                'widgetClass' => \\metalguardian\\dateTimePicker\\Widget::className(),
                'options' => [
                    'mode' => \\metalguardian\\dateTimePicker\\Widget::MODE_TIME,
                    'options' => [
                        'class' => 'form-control',
                    ],
                ],
            ]";
        } elseif ($column->type === Schema::TYPE_DATETIME) {
            return "[
                'type' => ActiveFormBuilder::INPUT_WIDGET,
                'widgetClass' => \\metalguardian\\dateTimePicker\\Widget::className(),
                'options' => [
                    'options' => [
                        'class' => 'form-control',
                    ],
                ],
            ]";
        } elseif ($column->type === 'text') {
            return "[
                'type' => ActiveFormBuilder::INPUT_WIDGET,
                'widgetClass' => \\backend\\components\\ImperaviContent::className(),
                'options' => [
                    'model' => \$this,
                    'attribute' => '$attribute',
                ]
            ]";
        } elseif (in_array($column->name, $foreignKeys, true)) {
            $foreignKeysTables = $this->getForeignKeysTables($tableSchema);
            $relTableName = isset($foreignKeysTables[$column->name]) ? $foreignKeysTables[$column->name] : null;
            if ($relTableName) {
                $relClassName = '\\common\\models\\' . $this->generateClassName($relTableName);
                return "[
                'type' => ActiveFormBuilder::INPUT_DROPDOWN_LIST,
                'items' => {$relClassName}::getItems(),
                'options' => [
                    'prompt' => '',
                ],
            ]";
            }
        } else {
            if (preg_match('/^(password|pass|passwd|passcode)$/i', $column->name)) {
                $input = 'INPUT_PASSWORD';
            } else {
                $input = 'INPUT_TEXT';
            }
            if (is_array($column->enumValues) && count($column->enumValues) > 0) {
                $dropDownOptions = [];
                foreach ($column->enumValues as $enumValue) {
                    $dropDownOptions[$enumValue] = Inflector::humanize($enumValue);
                }
                return "[
                'type' => ActiveFormBuilder::INPUT_DROPDOWN_LIST,
                'items' => " . preg_replace("/\n\s*/", ' ', VarDumper::export($dropDownOptions)) . ",
                'options' => [
                    'prompt' => '',
                ],
            ]";
            } elseif ($column->phpType !== 'string' || $column->size === null) {
                return "[
                'type' => ActiveFormBuilder::{$input},
            ]";
            } else {
                $class = '';
                if ($column->name == 'label' && isset($tableSchema->columns['alias'])) {
                    $class = "'class' => 's_name'";
                } elseif ($column->name == 'alias' && isset($tableSchema->columns['label'])) {
                    $class = "'class' => 's_alias'";
                }
                return "[
                'type' => ActiveFormBuilder::{$input},
                'options' => [
                    'maxlength' => true,
                    $class
                ],
            ]";
            }
        }
    }

    /**
     * Generates a class name from the specified table name.
     * @param string $tableName the table name (which may contain schema prefix)
     * @param boolean $useSchemaName should schema name be included in the class name, if present
     * @return string the generated class name
     */
    protected function generateClassName($tableName, $useSchemaName = null)
    {
        $schemaName = '';
        if (($pos = strrpos($tableName, '.')) !== false) {
            if ($useSchemaName) {
                $schemaName = substr($tableName, 0, $pos) . '_';
            }
            $tableName = substr($tableName, $pos + 1);
        }

        $db = $this->getDbConnection();
        $patterns = [];
        $patterns[] = "/^{$db->tablePrefix}(.*?)$/";
        $patterns[] = "/^(.*?){$db->tablePrefix}$/";
        $className = $tableName;
        foreach ($patterns as $pattern) {
            if (preg_match($pattern, $tableName, $matches)) {
                $className = $matches[1];
                break;
            }
        }

        return Inflector::id2camel($schemaName.$className, '_');
    }

    /**
     * @return Connection the DB connection as specified by [[db]].
     */
    protected function getDbConnection()
    {
        return Yii::$app->get($this->db, false);
    }

    /**
     * @param TableSchema $tableSchema
     * @return array
     */
    protected function getForeignKeys($tableSchema)
    {
        static $foreignKeys = null;


        if ($foreignKeys === null) {
            $foreignKeys = ArrayHelper::getColumn($tableSchema->foreignKeys, function ($element) {
                unset($element[0]);
                $keys = array_keys($element);
                return $keys[0];
            });
        }

        return $foreignKeys;
    }

    /**
     * @param TableSchema $tableSchema
     * @return array
     */
    protected function getForeignKeysTables($tableSchema)
    {
        static $foreignKeys = null;


        if ($foreignKeys === null) {
            $foreignKeys = ArrayHelper::map($tableSchema->foreignKeys, function ($element) {
                unset($element[0]);
                $keys = array_keys($element);
                return $keys[0];
            }, function ($element) {
                return $element[0];
            });
        }

        return $foreignKeys;
    }
}
