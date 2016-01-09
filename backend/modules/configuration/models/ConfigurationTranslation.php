<?php

namespace backend\modules\configuration\models;

use Yii;

/**
 * @inheritdoc
 * @property Configuration $model
 */
class ConfigurationTranslation extends \common\models\ConfigurationTranslation
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return \yii\helpers\ArrayHelper::merge(parent::behaviors(), [

        ]);
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%configuration_translation}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['value'], 'required', 'except' => ['file', 'image', 'integer', 'double', 'boolean', 'string']],

            [['value'], 'integer', 'on' => 'integer'],

            [['value'], 'double', 'on' => 'double'],

            [['value'], 'string', 'on' => 'string'],

            [['value'], 'boolean', 'on' => 'boolean'],
        ];
    }

    public function afterFind()
    {
        parent::afterFind();

        $this->setScenario($this->getTypeScenario());
    }

    public function beforeValidate()
    {
        if (parent::beforeValidate()) {
            $this->setScenario($this->getTypeScenario());
            //if (in_array($this->getScenario(), ['file', 'image'], true)) {
                $this->addBehavior();
            //}

            return true;
        }

        return false;
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        $label =
            ($this->model && $this->model->description)
                ?
                Yii::t('app', 'Value') . ' (' . $this->model->description . ')'
                :
                Yii::t('app', 'Value');
        return [
            'value' => $label . ' [' . $this->language . ']',
        ];
    }

    /**
     * @return string
     */
    public function getTypeScenario()
    {
        if ($this->model) {
            return $this->model->getTypeScenario();
        }
        return 'string';
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModel()
    {
        return $this->hasOne(Configuration::className(), ['id' => 'model_id']);
    }

    private function addBehavior()
    {
        $this->attachBehaviors([
            'file' => [
                'class' => \metalguardian\fileProcessor\behaviors\UploadBehavior::className(),
                'attribute' => '[' . $this->language . ']value',
                'validator' => [
                    'extensions' => ['pdf', 'doc', 'docx', 'xls', 'xlsx', 'txt', 'png', 'gif', 'jpg', 'jpeg'],
                    'on' => ['file', 'image'],
                ],
                'required' => false
            ],
        ]);
    }

    public function __get($name)
    {
        if (strpos($name, '[') === 0) {
            $name = substr($name, strpos($name, ']') + 1);
            return parent::__get($name);
        }
        return parent::__get($name);
    }

    public function __set($name, $value)
    {
        if (strpos($name, '[') === 0) {
            $name = substr($name, strpos($name, ']') + 1);
            parent::__set($name, $value);
        }
        parent::__set($name, $value);
    }


}
