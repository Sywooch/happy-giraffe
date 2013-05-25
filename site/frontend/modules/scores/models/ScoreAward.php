<?php

/**
 * This is the model class for table "score__awards".
 *
 * The followings are the available columns in table 'score__awards':
 * @property string $id
 * @property string $title
 * @property string $description
 * @property integer $scores
 *
 * The followings are the available model relations:
 * @property User[] $users
 */
class ScoreAward extends HActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ScoreAward the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'score__awards';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('title', 'required'),
            array('scores', 'numerical', 'integerOnly' => true),
            array('title', 'length', 'max' => 255),
            array('description', 'safe'),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, title, description, scores', 'safe', 'on' => 'search'),
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
            'users' => array(self::MANY_MANY, 'User', 'score__users_awards(award_id, user_id)'),
//			'some_users' => array(self::MANY_MANY, 'User', 'score__users_awards(award_id, user_id)', 'limit'=>10),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'title' => 'title',
            'description' => 'Description',
            'scores' => 'Scores',
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

        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('title', $this->title, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('scores', $this->scores);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function getAwardsCount($user_id)
    {
        return Yii::app()->db->createCommand()
            ->select('count(award_id)')
            ->from('score__users_awards')
            ->where('user_id = :user_id')
            ->queryScalar(array(':user_id' => $user_id));
    }

    public function getRandomUsers()
    {
        $userIds = Yii::app()->db->createCommand()
            ->select('user_id')
            ->from('score__users_awards')
            ->where('award_id = :award_id', array(':award_id' => $this->id))
            ->limit(10)
            ->queryColumn();

        return User::model()->findAllByPk($userIds);
    }

    /**
     * Трофеи автору за просмотры его поста
     *
     * @param CommunityContent $content_model
     * @param int $old_views
     * @param int $now_views
     * @return void
     */
    public static function checkPageViews($content_model, $old_views, $now_views)
    {
        if ($content_model->author_id == User::HAPPY_GIRAFFE || empty($content_model->author_id))
            return;

        $award_levels = array(
            11 => 1000, //трофей "Заметный пост"
            12 => 2500, //трофей "Известный пост"
            13 => 10000, //трофей "Знаменитый пост"
        );

        foreach ($award_levels as $award_id => $award_limit) {

            //если перешел рубеж трофея
            if ($old_views < $award_limit && $now_views >= $award_limit) {

                $transaction = Yii::app()->db->beginTransaction();
                try {
                    //на всякий случай проверяем есть ли уже такой трофей
                    $exist = ScoreUserAward::model()->findByAttributes(array(
                        'award_id' => $award_id,
                        'user_id' => $content_model->author_id,
                        'entity' => get_class($content_model),
                        'entity_id' => $content_model->id,
                    ));
                    //если нет - выдаем
                    if ($exist === null) {
                        $award = new ScoreUserAward();
                        $award->award_id = $award_id;
                        $award->user_id = $content_model->author_id;
                        $award->entity = get_class($content_model);
                        $award->entity_id = $content_model->id;
                        $award->save();
                    }
                    $transaction->commit();
                } catch (Exception $e) {
                    $transaction->rollback();
                }
            }

            if ($now_views < $award_limit)
                break;
        }
    }

    /**
     * Трофеи автору за лайки к его посту
     *
     * @param $entity
     * @param int $entity_id
     * @return void
     */
    public static function checkPageLikes($entity, $entity_id)
    {
        //даем только за посты
        if ($entity !== 'CommunityContent' && $entity !== 'BlogContent')
            return;

        $content_model = CActiveRecord::model($entity)->findByPk($entity_id);
        if ($content_model === null || $content_model->author_id == User::HAPPY_GIRAFFE || empty($content_model->author_id))
            return;

        $award_levels = array(
            14 => 10, //трофей "Хороший пост"
            15 => 25, //трофей "Интересный пост"
            16 => 100, //трофей "Превосходный пост"
        );

        foreach ($award_levels as $award_id => $award_limit) {
            $criteria = new EMongoCriteria;
            $criteria->entity_id('==', (int)$entity_id);
            $criteria->entity_name('==', $entity);
            $count = RatingYohoho::model()->count($criteria);

            //если перешел рубеж трофея
            if ($count >= $award_limit) {
                $transaction = Yii::app()->db->beginTransaction();
                try {
                    //на всякий случай проверяем есть ли уже такой трофей
                    $exist = ScoreUserAward::model()->findByAttributes(array(
                        'award_id' => $award_id,
                        'user_id' => $content_model->author_id,
                        'entity' => get_class($content_model),
                        'entity_id' => $content_model->id,
                    ));
                    //если нет - выдаем
                    if ($exist === null) {
                        $award = new ScoreUserAward();
                        $award->award_id = $award_id;
                        $award->user_id = $content_model->author_id;
                        $award->entity = get_class($content_model);
                        $award->entity_id = $content_model->id;
                        $award->save();
                    }
                    $transaction->commit();
                } catch (Exception $e) {
                    $transaction->rollback();
                }
            } else
                break;
        }
    }
}
