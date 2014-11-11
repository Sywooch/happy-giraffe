<?php

namespace site\frontend\modules\family\models;

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
class Family extends \CActiveRecord implements \IHToJSON
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
                'class' => 'site\frontend\modules\photo\components\PhotoCollectionBehavior',
            ),
            'UrlBehavior' => array(
                'class' => 'site\common\behaviors\UrlBehavior',
                'route' => '/family/default/index',
                'params' => array(
                    'id' => 'id',
                    'userId' => 'author_id',
                ),
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
     * Получить семью по id пользователя
     *
     * Возвращает семью по id пользователя. В случае отсутствия таковой, она может быть создана.
     *
     * @param int $userId id пользователя
     * @param bool $create создавать ли семью в случае отсутствия существующей
     * @return null|Family созданный объект семьи или null в случае его отсутствия
     */
    public static function getByUserId($userId, $create = true)
    {
        /** @var \site\frontend\modules\family\models\FamilyMember $member */
        $member = FamilyMember::model()->user($userId)->find();
        if ($member !== null && $member->family !== null) {
            return $member->family;
        }

        return ($create) ? self::createFamily($userId) : null;
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
     * @param bool $public только публичные члены семьи (информация о которых актуальна и корректна)
     * @return \site\frontend\modules\family\models\FamilyMember[] отфильтрованный массив членов семьи
     */
    public function getMembers($type = null, $public = true)
    {
        $result = array();
        foreach ($this->members as $member) {
            $typeOk = $type === null || $type == $member->type;
            $publicOk = $public === false || $member->isPublic();
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
    protected static function createFamily($userId)
    {
        $family = new Family();
        $member = new Adult();
        $member->scenario = 'familyCreate';
        $member->fillByUser($userId);
        $family->members = array($member);
        $success = $family->withRelated->save(false, array('members'));
        return ($success) ? $family : null;
    }
}
