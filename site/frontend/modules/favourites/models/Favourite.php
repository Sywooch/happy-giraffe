<?php

/**
 * This is the model class for table "favourites".
 *
 * The followings are the available columns in table 'favourites':
 * @property string $id
 * @property string $model_name
 * @property string $model_id
 * @property string $entity
 * @property string $user_id
 * @property string $updated
 * @property string $created
 * @property string $note
 *
 * The followings are the available model relations:
 * @property User $user
 * @property FavouriteTag[] $favouritesTags
 */
class Favourite extends CActiveRecord
{
    public $relatedModel;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'favourites';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('model_name, model_id, user_id', 'required'),
            array('note', 'length', 'max' => 150),
            array('tagsNames', 'safe'),
			array('model_name', 'length', 'max'=>255),
			array('model_id, user_id', 'length', 'max'=>11),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, model_name, model_id, entity, user_id, updated, created, note', 'safe', 'on'=>'search'),
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
			'user' => array(self::BELONGS_TO, 'User', 'user_id'),
			'tags' => array(self::MANY_MANY, 'FavouriteTag', 'favourites__tags_favourites(favourite_id, tag_id)'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'model_name' => 'Model Name',
            'model_id' => 'Model',
            'entity' => 'Entity',
            'user_id' => 'User',
            'updated' => 'Updated',
            'created' => 'Created',
            'note' => 'Note',
        );
    }

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id,true);
		$criteria->compare('model_name',$this->model_name,true);
		$criteria->compare('model_id',$this->model_id,true);
        $criteria->compare('entity',$this->entity,true);
		$criteria->compare('user_id',$this->user_id,true);
		$criteria->compare('updated',$this->updated,true);
		$criteria->compare('created',$this->created,true);
		$criteria->compare('note',$this->note,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Favourite the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public function defaultScope()
    {
        return array(
            'with' => 'tags',
        );
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
            ),
            'notificationBehavior' => array(
                'class' => 'site\frontend\modules\notifications\behaviors\FavoriteBehavior',
            ),
        );
    }

    public function setTagsNames($tagsNames)
    {
        $this->tags = $this->processTags($tagsNames);
    }

    public function getTagsNames()
    {
        return array_map(function($tag) {
            return $tag->name;
        }, $this->tags);
    }

    protected function beforeSave()
    {
        if (! $this->isNewRecord)
            Yii::app()->db->createCommand()->delete('favourites__tags_favourites', 'favourite_id = :favourite_id', array(':favourite_id' => $this->id));

        if ($this->isNewRecord)
            $this->entity = $this->getEntityByModelNameId($this->model_name, $this->model_id);

        return parent::beforeSave();
    }

    public function afterSave()
    {
        PostRating::reCalc($this->getRelatedModel());
        parent::afterSave();
    }

    public function afterDelete()
    {
        PostRating::reCalc($this->getRelatedModel());
        return parent::afterDelete();
    }

    protected function getRelatedModel()
    {
        return CActiveRecord::model($this->model_name)->resetScope()->findByPk($this->model_id);
    }

    protected function processTags($tagsNames)
    {
        $tagsArray = is_array($tagsNames) ? $tagsNames : explode(',', $tagsNames);

        return array_map(function($name) {
            $tag = FavouriteTag::model()->findByAttributes(array('name' => $name));
            if ($tag === null) {
                $tag = new FavouriteTag();
                $tag->name = $name;
                $tag->save();
            }
            return $tag;
        }, $tagsArray);
    }

    public function getCountByModel($model)
    {
        $modelName = get_class($model);
        if ($modelName == 'CommunityContent' && $model->getIsFromBlog())
            $modelName = 'BlogContent';
        elseif($modelName == 'BlogContent' && !$model->getIsFromBlog())
            $modelName = 'CommunityContent';

        return $this->count('model_name = :model_name AND model_id = :model_id', array(':model_name' => $modelName, ':model_id' => $model->id));
    }

    public function getAllByModel($model, $limit)
    {
        $modelName = get_class($model);
        if ($modelName == 'CommunityContent' && $model->getIsFromBlog())
            $modelName = 'BlogContent';
        elseif($modelName == 'BlogContent' && !$model->getIsFromBlog())
            $modelName = 'CommunityContent';

        $criteria = new CDbCriteria();
        $criteria->condition = 'model_name = :model_name AND model_id = :model_id';
        $criteria->params = array(':model_name' => $modelName, ':model_id' => $model->id);
        $criteria->limit = $limit;
        if (Yii::app() instanceof CWebApplication && ! Yii::app()->user->isGuest)
            $criteria->compare('user_id', '<>' . Yii::app()->user->id);

        return $this->findAll($criteria);
    }

    public function getUserHas($userId, $model)
    {
        $modelName = get_class($model);
        if ($modelName == 'CommunityContent' && $model->getIsFromBlog())
            $modelName = 'BlogContent';
        elseif($modelName == 'BlogContent' && !$model->getIsFromBlog())
            $modelName = 'CommunityContent';
        return $this->exists('model_name = :model_name AND model_id = :model_id AND user_id = :user_id', array(':model_name' => $modelName, ':model_id' => $model->id, ':user_id' => $userId));
    }

    public function getEntityByModelNameId($modelName, $modelId)
    {
        switch ($modelName) {
            case 'CookRecipe':
            case 'SimpleRecipe':
            case 'MultivarkaRecipe':
                return 'cook';
            case 'AlbumPhoto':
                return 'photo';
            case 'CommunityContent':
            case 'BlogContent':
                $model = CActiveRecord::model($modelName)->resetScope()->findByPk($modelId);
                return $model->type_id == 1 ? 'post' : 'video';
            default:
                return '';
        }
    }

    public function getEntityByModel($model)
    {
        switch (get_class($model)) {
            case 'CookRecipe':
            case 'SimpleRecipe':
            case 'MultivarkaRecipe':
                return 'cook';
            case 'AlbumPhoto':
                return 'photo';
            case 'CommunityContent':
            case 'BlogContent':
                return $model->type_id == 1 ? 'post' : 'video';
            default:
                return '';
        }
    }

    /**
     * Возвращает массив добавление в избранное за последние 24 часа
     * @return array
     */
    public function findLastDayFavourites()
    {
        $result = array();
        $t = microtime(true);
        $favourites = Yii::app()->db->createCommand()
            ->select('model_name, model_id, count(id) as count')
            ->from($this->tableName())
            ->group('model_name, model_id')
            ->where('created > "'.date("Y-m-d H:i:s", strtotime('-1 day')) .'"')
            ->queryAll();
        echo microtime(true) - $t . "\n";
        echo count($favourites)."\n";

        foreach ($favourites as $favourite) {
            $model = CActiveRecord::model($favourite['model_name'])->findByPk($favourite['model_id']);
            if ($model === null)
                continue;
            if (!isset($model->author_id))
                continue;

            if (!isset($result[$model->author_id]))
                $result[$model->author_id] = array();
            if (!isset($result[$model->author_id][$favourite['model_name']]))
                $result[$model->author_id][$favourite['model_name']] = array();
            $result[$model->author_id][$favourite['model_name']][$favourite['model_id']] = $favourite['count'];
        }

        return $result;
    }
}
