<?php

namespace site\frontend\modules\som\modules\status\models;

/**
 * This is the model class for table "som__status".
 *
 * The followings are the available columns in table 'som__status':
 * @property string $id
 * @property string $text
 * @property string $moodId
 * @property string $authorId
 *
 * The followings are the available model relations:
 * @property \site\frontend\modules\som\modules\status\models\Moods $moodModel
 */
class Status extends \CActiveRecord implements \IHToJSON
{

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'som__status';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('text, authorId', 'required'),
            array('moodId', 'numerical', 'allowEmpty' => true, 'integerOnly' => true, 'min' => 1),
            array('authorId', 'numerical', 'allowEmpty' => false, 'integerOnly' => true, 'min' => 1),
            array('text', 'length', 'max' => 500),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'moodModel' => array(self::BELONGS_TO, 'site\frontend\modules\som\modules\status\models\Moods', 'moodId'),
        );
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return site\frontend\modules\som\modules\status\models\Status the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function behaviors()
    {
        return array(
            'softDelete' => array(
                'class' => 'site.common.behaviors.SoftDeleteBehavior',
                'removeAttribute' => 'isRemoved',
            ),
        );
    }

    public function onAfterSoftDelete()
    {
        // заглушка, для того, что бы можно было слушать события от SoftDeleteBehavior
    }

    public function onAfterSoftRestore()
    {
        // заглушка, для того, что бы можно было слушать события от SoftDeleteBehavior
    }

    public function toJSON()
    {
        return array(
            'id' => $this->id,
            'text' => $this->text,
            'mood' => array(
                'id' => $this->moodModel->id,
                'text' => $this->moodModel->text,
            ),
        );
    }

}
