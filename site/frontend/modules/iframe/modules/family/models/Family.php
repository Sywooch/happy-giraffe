<?php

namespace site\frontend\modules\iframe\modules\family\models;

/**
 * This is the model class for table "family__families".
 *
 * The followings are the available columns in table 'family__families':
 * @property int $id
 * @property string $description
 * @property string $adultsRelationshipStatus
 * @property int $created
 * @property int $updated
 *
 * The followings are the available model relations:
 * @property \site\frontend\modules\family\models\FamilyMember[] $members
 */
class Family extends \HActiveRecord implements \IHToJSON
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'family__families';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
            array('description', 'length', 'max' => 500),
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
			'members' => array(self::HAS_MANY, '\site\frontend\modules\family\models\FamilyMember', 'familyId'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'description' => 'Description',
            'adultRelationshipStatus' => 'Adult Relationship Status',
            'created' => 'Created',
            'updated' => 'Updated',
		);
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Family the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function behaviors()
    {
        return array(
            'withRelated' => array(
                'class' => 'site.common.extensions.wr.WithRelatedBehavior',
            ),
            'CTimestampBehavior' => array(
                'class' => 'zii.behaviors.CTimestampBehavior',
                'createAttribute' => 'created',
                'updateAttribute' => 'updated',
                'setUpdateOnCreate' => true,
            ),
            'PhotoCollectionBehavior' => array(
                'class' => 'site\frontend\modules\photo\components\ActivePhotoCollectionBehavior',
            ),
            'UrlBehavior' => array(
                'class' => 'site\common\behaviors\UrlBehavior',
                'route' => '/family/default/index',
                'params' => function($family) {
                    $member = FamilyMember::model()->family($family->id)->real()->find();
                    return array(
                        'userId' => $member->userId,
                    );
                }
            ),
        );
    }

    public function toJSON()
    {
        return array(
            'id' => (int) $this->id,
            'description' => $this->description,
            'photoCollection' => $this->photoCollection,
        );
    }

    /**
     * Права на управления семьей
     *
     * Используется менеджером прав.
     *
     * @param integer $userId id пользователя
     * @return bool может ли пользователь управлять данной семьей
     */
    public function canManage($userId)
    {
        return FamilyMember::model()->user($userId)->family($this->id)->exists();
    }

    /**
     * Получение членов семьи
     *
     * Позволяет выбрать из отношения members отфильтрованный список членов семьи.
     *
     * @param null|string $type тип члена семьи для фильтрации по типу или null для ее отсутствия
     * @param bool $publicOnly только публичные члены семьи (информация о которых актуальна и корректна)
     * @return \site\frontend\modules\family\models\FamilyMember[] отфильтрованный массив членов семьи
     */
    public function getMembers($type = null, $publicOnly = true)
    {
        $result = array();

        foreach ($this->members as $member) {
            $typeOk = $type === null || $type == $member->type;
            $publicOk = $publicOnly === false || $member->isPublic();
            if ($typeOk && $publicOk) {
                $result[] = $member;
            }
        }
        return $result;
    }

    /**
     * Создать семью
     *
     * Создает семью, автоматически добавляя в нее первого взрослого - самого создателя.
     *
     * @param int $userId id пользователя
     * @return null|Family созданный объект семьи или null в случае его отсутствия
     */
    public static function createFamily($userId)
    {
        $family = new Family();
        $member = new Adult();
        $member->scenario = 'familyCreate';
        $member->fillByUser($userId);
        $family->members = array($member);
        $success = $family->withRelated->save(true, array('members'));
        return ($success) ? $family : null;
    }

    public function createMember($attributes, $photoId = null)
    {
        $transaction = \Yii::app()->db->beginTransaction();
        $modelClass = FamilyMember::getClassName($attributes['type']);
        /** @var \site\frontend\modules\family\models\FamilyMember $model */
        $model = new $modelClass();
        $model->familyId = $this->id;
        $model->attributes = $attributes;

        try {
            $success = $model->save();
            if ($success) {
                if ($photoId !== null) {
                    $model->photoCollection->attachPhotos($photoId);
                }
                $members = $this->members;
                $members[] = $model;
                $this->members = $members;
                $transaction->commit();
            } else {
                $transaction->rollback();
            }
        } catch (\Exception $e) {
            $transaction->rollback();
            throw $e;
        }
        return $model;
    }

    public function hasMember($userId)
    {
        $criteria = new \CDbCriteria(array(
            'join' => 'INNER JOIN ' . FamilyMember::model()->tableName() . ' fm ON fm.userId = :userId AND fm.familyId = ' . $this->getTableAlias() . '.id',
            'params' => array(':userId' => $userId),
        ));
        $this->getDbCriteria()->mergeWith($criteria);
        return $this;
    }

    public function getChild($userId){
        $family = Family::model()->with([
            'members'=>[
                'joinType'=>'INNER JOIN',
                'condition'=>'members.type="child"',
            ]
        ])->hasMember($userId)->find();
        return $family->getMembers('child');
    }
}
