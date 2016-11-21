<?php
namespace site\frontend\modules\quests\models;

/**
 * This is the model class for table "quests".
 *
 * The followings are the available columns in table 'quest':
 * @property int $id
 * @property int $user_id
 * @property string $name
 * @property string $description
 * @property int $end_date
 * @property int $type_id
 * @property string $model_name
 * @property int $model_id
 * @property string $settings
 * @property bool is_completed
 * @property bool is_dropped
 *
 * The followings are the available model relations:
 * @property \User $user
 */
class Quest extends \HActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'quests';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id, type_id', 'required'),
            array('user_id', 'exist', 'attributeName' => 'id', 'className' => get_class(\User::model())),
            array('is_completed, is_dropped', 'booleanStringValidator'),
            array('is_completed, is_dropped', 'booleanIntValidator'),
            array('is_completed, is_dropped', 'boolean'),
        );
    }

    public function booleanStringValidator($attribute, $params)
    {
        if (is_string($this->$attribute)) {
            if ($this->$attribute == 'true') {
                $this->$attribute = true;
            } else if ($this->$attribute == 'false') {
                $this->$attribute = false;
            } else {
                $this->addError($attribute, "Quest::{$attribute} must contain 'true' or 'false' value!");
            }
        }
    }

    public function booleanIntValidator($attribute, $params)
    {
        if (is_numeric($this->$attribute)) {
            if ($this->$attribute == 1) {
                $this->$attribute = true;
            } else if ($this->$attribute == 0) {
                $this->$attribute = false;
            } else {
                $this->addError($attribute, "Quest::{$attribute} must contain 1 or 0 value!");
            }
        }
    }

    public function behaviors()
    {
        return array(
            'CacheDelete' => array(
                'class' => \site\frontend\modules\api\ApiModule::CACHE_DELETE,
            ),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'user' => array(self::BELONGS_TO, get_class(\User::model()), 'user_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'user_id' => 'User',
            'end_date' => 'End Date',
            'type_id' => 'Type',
            'settings' => 'Settings',
        );
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Quest the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

//    public function resetScope($resetDefault = true)
//    {
//        $this->_ignoreDefaultScope = true;
//        return parent::resetScope($resetDefault);
//    }

    public function defaultScope()
    {
        $alias = $this->getTableAlias(true, false);

        return array(
            'condition' => $alias . '.`is_completed` = 0 AND ' . $alias . '.`is_dropped` = 0',
        );
    }

    /**
     * @param int $userId
     *
     * @return Quest
     */
    public function byUser($userId)
    {
        $this->getDbCriteria()->compare($this->tableAlias . '.user_id', $userId);
        return $this;
    }

    /**
     * @param int $typeId
     *
     * @return Quest
     */
    public function byType($typeId)
    {
        $this->getDbCriteria()->compare($this->tableAlias . '.type_id', $typeId);
        return $this;
    }

    /**
     * @param string $modelName
     *
     * @return Quest
     */
    public function byModelName($modelName)
    {
        $this->getDbCriteria()
            ->compare($this->tableAlias . '.model_name', $modelName);

        return $this;
    }

    /**
     * @param string $modelName
     * @param int $modelId
     *
     * @return Quest
     */
    public function byModel($modelName, $modelId)
    {
        $this->getDbCriteria()
            ->compare($this->tableAlias . '.model_name', $modelName)
            ->compare($this->tableAlias . '.model_id', $modelId);
        return $this;
    }

    /**
     * @return Quest
     */
    public function byNearest()
    {
        $this->getDbCriteria()->order = 'end_date desc';
        return $this;
    }

    /**
     * @param bool $isCompleted
     *
     * @return Quest
     */
    public function completed($isCompleted)
    {
        $this->getDbCriteria()->compare($this->tableAlias . '.is_completed', $isCompleted);
        return $this;
    }

    /**
     * @param bool $isDropped
     *
     * @return Quest
     */
    public function dropped($isDropped)
    {
        $this->getDbCriteria()->compare($this->tableAlias . '.is_dropped', $isDropped);
        return $this;
    }

    /**
     * @return array
     */
    public function getSettingsArray()
    {
        if (isset($this->settings)) {
            return \CJSON::decode($this->settings, true);
        }

        return array();
    }

    /**
     * @return bool
     */
    public function complete()
    {
        $this->is_completed = true;
        return $this->update(array('is_completed'));
    }

    /**
     * @return bool
     */
    public function drop()
    {
        $this->is_dropped = true;
        return $this->update(array('is_dropped'));
    }

    /**
     * @return bool
     */
    public function isActive()
    {
        return $this->end_date > time();
    }
}
