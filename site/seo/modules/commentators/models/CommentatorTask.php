<?php

/**
 * This is the model class for table "commentators__tasks".
 *
 * The followings are the available columns in table 'commentators__tasks':
 * @property integer $id
 * @property integer $type
 * @property string $page_id
 * @property string $created
 * @property integer $status
 *
 * The followings are the available model relations:
 * @property Page $page
 */
class CommentatorTask extends CActiveRecord
{
    const STATUS_OPEN = 1;
    const STATUS_PAUSE = 2;

    const TYPE_COMMENT = 1;
    const TYPE_LIKE = 2;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return CommentatorTask the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return CDbConnection database connection
     */
    public function getDbConnection()
    {
        return Yii::app()->db_seo;
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'commentators__tasks';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('page_id, created', 'required'),
            array('type, status', 'numerical', 'integerOnly' => true),
            array('page_id', 'length', 'max' => 10),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, type, page_id, created, status', 'safe', 'on' => 'search'),
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
            'page' => array(self::BELONGS_TO, 'Page', 'page_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'type' => 'Тип задания',
            'page_id' => 'Страница',
            'created' => 'Дата создания',
            'status' => 'Статус',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id);
        $criteria->compare('type', $this->type);
        $criteria->compare('page_id', $this->page_id);
        $criteria->compare('created', $this->created, true);
        $criteria->compare('status', $this->status);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Возвращает список из 2х массивов - выполнившие задание комментаторы и не выполнившие
     * @return array
     */
    public function getExecutorsLists()
    {
        $user_ids = $this->getExecutorsIds();
        $executors = array();
        $non_executors = array();

        $all_commentators = CommentatorHelper::getCommentatorIdList();

        foreach ($all_commentators as $commentator_id) {
            if (in_array($user_ids, $commentator_id))
                $executors[] = $commentator_id;
            else
                $non_executors[] = $commentator_id;
        }

        return array($executors, $non_executors);
    }

    /**
     * Возвращает список id комментаторов, которые выполнили задание.
     * @return array
     */
    private function getExecutorsIds()
    {
        if ($this->type == self::TYPE_COMMENT) {
            $user_ids = Yii::app()->db->createCommand()
                ->selectDistinct('author_id')
                ->from('comments')
                ->where('entity=:entity AND entity_id=:entity_id', array(
                    ':entity' => $this->page->entity,
                    ':entity_id' => $this->page->entity_id,
                ))
                ->queryColumn();
        } else {
            #TODO проверяем лайки хотя бы по одной соц сети
            $user_ids = Yii::app()->db->createCommand()
                ->selectDistinct('user_id')
                ->from('commentators__likes')
                ->where('entity=:entity AND entity_id=:entity_id', array(
                    ':entity' => $this->page->entity,
                    ':entity_id' => $this->page->entity_id,
                ))
                ->queryColumn();
        }

        return $user_ids;
    }

    /**
     * Возвращает связанную с заданием статью
     * @return CommunityContent
     */
    public function getPost()
    {
        return $this->page->getArticle();
    }

    /**
     * Выполнено ли задание текущим комментатором
     * @return bool
     */
    public function isExecutedByCurrentUser()
    {
        return in_array(Yii::app()->user->id, $this->getExecutorsIds());
    }
}