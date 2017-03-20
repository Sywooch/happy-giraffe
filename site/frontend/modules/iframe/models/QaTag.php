<?php

namespace site\frontend\modules\iframe\models;

use site\frontend\modules\som\modules\qa\controllers\DefaultController;
use site\frontend\modules\som\modules\qa\models\qaTag\Enum;

/**
 * This is the model class for table "qa__tags".
 *
 * The followings are the available columns in table 'qa__tags':
 * @property int $id
 * @property int $category_id
 * @property string $name
 *
 * The followings are the available model relations:
 * @property int $questionsCount
 * @property \site\frontend\modules\som\modules\qa\models\QaCategory $category
 */
class QaTag extends \HActiveRecord implements \IHToJSON
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'qa__tags';
    }

    /**
     * @return string|NULL
     */
    public function getTitle()
    {
        return (new Enum())->getTitleForWeb($this->name);
    }

    public function getUrl()
    {
        return \Yii::app()
                    ->getUrlManager()
                    ->createUrl(
                        'som/qa/default/pediatrician',
                        [
                            'tab'   => DefaultController::TAB_NEW,
                            'tagId' => $this->id
                        ]
                    )
                ;
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('category_id, name', 'required'),
            array('category_id', 'exist', 'attributeName' => 'id', 'className' => get_class(QaCategory::model())),
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
            'category' => array(self::BELONGS_TO, get_class(QaCategory::model()), 'category_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'category_id' => 'Category',
            'name' => 'Name',
        );
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return QaTag the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return array
     * @author Sergey Gubarev
     */
    public function toJSON()
    {
        return [
            'id'    => $this->id,
            'name'  => $this->name,
            'title' => $this->getTitle()
        ];
    }

    /**
     * @param int $categoryId
     *
     * @return QaTag
     */
    public function byCategory($categoryId)
    {
        $this->getDbCriteria()->compare($this->tableAlias . '.category_id', $categoryId);
        return $this;
    }

    /**
     * @param string $name
     *
     * @return QaTag
     */
    public function byName($name)
    {
        $this->getDbCriteria()->compare($this->tableAlias . '.name', $name);
        return $this;
    }

    /**
     * @param integer $intAge
     * @return NULL|self
     */
    public static function getByAge($intAge)
    {
        $map = [
            1 => '0-1',
            3 => '1-3',
            6 => '3-6',
            12 => '6-12',
        ];

        $result = 0;

        foreach (array_keys($map) as $age)
        {
            if ($intAge < $age)
            {
                $result = $age;
                break;
            }
        }

        if ($result == 0)
        {
            return;
        }

        return self::model()->byName($map[$result])->find();
    }
}
