<?php

/**
 * This is the model class for table "messaging__messages".
 *
 * The followings are the available columns in table 'messaging__messages':
 * @property string $id
 * @property string $author_id
 * @property string $thread_id
 * @property string $text
 * @property string $updated
 * @property string $created
 *
 * The followings are the available model relations:
 * @property Users $author
 * @property MessagingThreads $thread
 * @property Users[] $users
 */
class MessagingMessage extends CActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return MessagingMessage the static model class
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
        return 'messaging__messages';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('author_id, thread_id, text', 'required'),
            array('updated, created', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, author_id, thread_id, text, updated, created', 'safe', 'on'=>'search'),
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
            'author' => array(self::BELONGS_TO, 'User', 'author_id'),
            'thread' => array(self::BELONGS_TO, 'MessagingThread', 'thread_id'),
            'messageUsers' => array(self::HAS_MANY, 'MessagingMessageUser', 'message_id'),
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
            'author_id' => 'Author',
            'thread_id' => 'Thread',
            'text' => 'Text',
            'updated' => 'Updated',
            'created' => 'Created',
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
        $criteria->compare('author_id',$this->author_id,true);
        $criteria->compare('thread_id',$this->thread_id,true);
        $criteria->compare('text',$this->text,true);
        $criteria->compare('updated',$this->updated,true);
        $criteria->compare('created',$this->created,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
}