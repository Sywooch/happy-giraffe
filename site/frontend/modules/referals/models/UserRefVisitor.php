<?php

namespace site\frontend\modules\referals\models;
use site\frontend\modules\referals\components\ReferalsEvents;
use site\frontend\modules\referals\components\ReferalsManager;

/**
 * This is the model class for table "user__refs_visitors".
 *
 * The followings are the available columns in table 'user__refs_visitors':
 * @property int $ref_id
 * @property string ip
 * @property string from
 *
 * The followings are the available model relations:
 * @property UserRefLink $ref
 */
class UserRefVisitor extends \HActiveRecord
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'user__refs_visitors';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('ref_id, ip', 'required'),
            array('ref_id', 'exist', 'attributeName' => 'id', 'className' => get_class(UserRefLink::model())),
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
            'ref' => array(self::BELONGS_TO, get_class(UserRefLink::model()), 'ref_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'ref_id' => 'Referal Link',
            'ip' => 'IP Address',
            'from' => 'From',
        );
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return UserRefVisitor the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @param int $refId
     *
     * @return UserRefVisitor
     */
    public function byRef($refId)
    {
        $this->getDbCriteria()->compare($this->tableAlias . '.ref_id', $refId);
        return $this;
    }

    /**
     * @param string $ip
     *
     * @return UserRefVisitor
     */
    public function byIP($ip)
    {
        $this->getDbCriteria()->compare($this->tableAlias . '.ip', $ip);
        return $this;
    }

    /**
     * @param string $from
     *
     * @return UserRefVisitor
     */
    public function byFrom($from)
    {
        $this->getDbCriteria()->compare($this->tableAlias . '.from', $from);
        return $this;
    }
}
