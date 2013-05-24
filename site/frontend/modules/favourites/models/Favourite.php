<?php

/**
 * This is the model class for table "favourites".
 *
 * The followings are the available columns in table 'favourites':
 * @property string $id
 * @property string $entity
 * @property string $entity_id
 * @property string $user_id
 * @property string $updated
 * @property string $created
 * @property string $note
 *
 * The followings are the available model relations:
 * @property Users $user
 * @property FavouritesTags[] $favouritesTags
 */
class Favourite extends HActiveRecord
{
    public $relatedModel;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Favourite the static model class
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

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
            array('entity, entity_id, user_id', 'required'),
            array('tagsNames, note', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, entity, entity_id, user_id, updated, created, note', 'safe', 'on'=>'search'),
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
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'entity' => 'Entity',
            'entity_id' => 'Entity',
            'user_id' => 'User',
            'updated' => 'Updated',
            'created' => 'Created',
            'note' => 'Note',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=new CDbCriteria;

        $criteria->compare('id',$this->id,true);
        $criteria->compare('entity',$this->entity,true);
        $criteria->compare('entity_id',$this->entity_id,true);
        $criteria->compare('user_id',$this->user_id,true);
        $criteria->compare('updated',$this->updated,true);
        $criteria->compare('created',$this->created,true);
        $criteria->compare('note',$this->note,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
}