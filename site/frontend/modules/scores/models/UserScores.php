<?php

/**
 * This is the model class for table "score__user_scores".
 *
 * The followings are the available columns in table 'score__user_scores':
 * @property integer $user_id
 * @property integer $scores
 * @property integer $viewed_scores
 * @property integer $level_id
 * @property integer $full
 *
 * The followings are the available model relations:
 * @property ScoreLevel $level
 * @property User $user
 */
class UserScores extends HActiveRecord
{
    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return UserScores the static model class
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
        return 'score__user_scores';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('user_id', 'required'),
            array('user_id, scores, level_id, full, viewed_scores', 'numerical', 'integerOnly' => true),
            array('user_id, scores, level_id, full', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'level' => array(self::BELONGS_TO, 'ScoreLevel', 'level_id'),
            'user' => array(self::BELONGS_TO, 'User', 'user_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'user_id' => 'User',
            'scores' => 'Scores',
            'level_id' => 'Level',
            'full' => 'Full',
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

        $criteria->compare('user_id', $this->user_id, true);
        $criteria->compare('scores', $this->scores, true);
        $criteria->compare('level_id', $this->level_id, true);
        $criteria->compare('full', $this->full);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public static function getModel($user_id)
    {
        $model = UserScores::model()->findByPk($user_id);
        if ($model === null) {
            if (User::model()->findByPk($user_id) === null)
                return null;

            $model = new UserScores;
            $model->scores = 0;
            $model->user_id = $user_id;
        }

        return $model;
    }

    public function checkFull()
    {
        if ($this->getStepsCount() >= 6) {
            $this->full = 1;
            $this->level_id = 1;
            UserAction::model()->add($this->user_id, UserAction::USER_ACTION_LEVELUP, array('level_id' => 1));
            $this->save();
            ScoreInput::model()->add($this->user_id, ScoreInput::SCORE_ACTION_6_STEPS);
        }
    }

    public function getStepsCount()
    {
        $count = 0;
        $steps = array(ScoreAction::ACTION_PROFILE_BIRTHDAY,
            ScoreAction::ACTION_PROFILE_PHOTO, ScoreAction::ACTION_PROFILE_FAMILY,
            ScoreAction::ACTION_PROFILE_INTERESTS, ScoreAction::ACTION_PROFILE_EMAIL,
            ScoreAction::ACTION_PROFILE_LOCATION);
        foreach ($steps as $step)
            if ($this->stepComplete($step))
                $count++;

        return $count;
    }

    public function stepComplete($step_id)
    {
        switch ($step_id) {
            case ScoreAction::ACTION_PROFILE_BIRTHDAY:
                return !empty($this->user->birthday);
            case ScoreAction::ACTION_PROFILE_PHOTO:
                return !empty($this->user->avatar_id);
            case ScoreAction::ACTION_PROFILE_FAMILY:
                return !empty($this->user->relationship_status);
            case ScoreAction::ACTION_PROFILE_INTERESTS:
                return !empty($this->user->interests);
            case ScoreAction::ACTION_PROFILE_EMAIL:
                return !empty($this->user->email_confirmed);
            case ScoreAction::ACTION_PROFILE_LOCATION:
                return !empty($this->user->userAddress);
        }

        return true;
    }

    /**
     * возвращает достижения пользователя в виде нужном для вывода
     *
     * @return ScoreAchievement[]
     */
    public function getActualAchieves()
    {
        return ScoreAchievement::model()->findAllByPk($this->getActualAchievesIds());
    }

    /**
     * возвращает массив id достижений пользователя
     *
     * @return array
     */
    public function getActualAchievesIds()
    {
        $value = Yii::app()->cache->get('achieve_list_' . $this->user_id);
        if ($value === false) {
            $achieves = ScoreAchievement::model()->roots();
            $userAchieves = $this->user->achievements;
            $value = array();

            foreach ($achieves as $achieve) {
                $current_achieve = $achieve;
                foreach ($userAchieves as $userAchieve) {
                    if ($current_achieve->id == $userAchieve->id)
                        $current_achieve = $current_achieve->next;
                }

                $value[] = $current_achieve->id;
            }

            $dependency = new CDbCacheDependency('SELECT count(achievement_id) FROM score__user_achievements WHERE user_id=' . $this->user_id);
            Yii::app()->cache->set('achieve_list_' . $this->user_id, $value, 0, $dependency);
        }

        return $value;
    }

    /**
     * @param $model Comment
     */
    public function check10Comments($model)
    {
        $content_model = CActiveRecord::model($model->entity)->findByPk($model->entity_id);
        if ($content_model !== null) {
            if ($content_model->commentsCount % 10 == 0)
                ScoreInput::model()->add($content_model->author_id, ScoreInput::SCORE_ACTION_10_COMMENTS, array('model' => $content_model));
        }
    }

    /**
     * Проверяем на 10 лайков к посту
     *
     * @param $entity_name
     * @param $entity_id
     * @return void
     */
    public function check10Likes($entity_name, $entity_id)
    {
        $content_model = CActiveRecord::model($entity_name)->findByPk($entity_id);
        if ($content_model !== null) {
            if ($content_model->commentsCount % 10 == 0)
                ScoreInput::model()->add($content_model->author_id, ScoreInput::SCORE_ACTION_10_COMMENTS, array('model' => $content_model));
        }
    }

    public function getUserHistory($page = 0)
    {
        $criteria = new EMongoCriteria;
        $criteria->addCond('user_id', '==', (int)$this->user_id);
        $criteria->sort('updated', EMongoCriteria::SORT_DESC);
        $criteria->limit(10);
        $criteria->offset($page*10);
//        $dataProvider = new EMongoDocumentDataProvider('ScoreInput', array('criteria' => $criteria));

        return ScoreInput::model()->findAll($criteria);
    }


    /************************************************** LEVELS, PACKS *************************************************/
    /************************************************** LEVELS, PACKS *************************************************/
    /**
     * Находится ли юзер в состоянии получения нового уровня
     *
     * @return bool
     */
    public function hasNewLevel()
    {
        $next_level = $this->getNextLevel();
        if ($next_level === null)
            return false;

        $user_packs_count = count($this->user->packs);
        return ($this->scores >= $next_level->score_cost && $user_packs_count <= ($this->level_id - 1));
    }

    /**
     * @return ScoreLevel
     */
    public function getNextLevel()
    {
        return ScoreLevel::model()->find('id=' . ($this->level_id + 1));
    }

    /**
     * Какие пакеты будут доступны на следующем уровне
     *
     * @return ScorePack[]
     */
    public function getNextLevelPacks()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('id', $this->getNextLevelPackIds());
        $criteria->order = 'image';
        return ScorePack::model()->findAll($criteria);
    }

    public function getNextLevelPackIds()
    {
        $cache_id = 'next_level_packs_' . $this->user_id;
        $value = Yii::app()->cache->get($cache_id);
        if ($value === false) {

            $roots = ScorePack::model()->roots();
            if ($this->level_id == 1)
                $value = CHtml::listData($roots, 'id', 'id');
            else {

                $value = array();
                $user_packs = $this->user->packs;
                foreach ($roots as $root) {
                    $pack = $root;
                    while ($pack !== null && $this->hasPack($user_packs, $pack->id))
                        $pack = $pack->nextLevelPack();

                    if ($pack !== null)
                        $value[] = $pack->id;
                }
            }

            $dependency = new CDbCacheDependency('SELECT count(pack_id) FROM score__users_packs WHERE user_id=' . $this->user_id);
            Yii::app()->cache->set($cache_id, $value, 0, $dependency);
        }

        return $value;
    }

    public function hasPack($user_packs, $pack_id)
    {
        foreach ($user_packs as $user_pack)
            if ($user_pack->id == $pack_id)
                return true;
        return false;
    }

    /**
     * Приобрести пакет опций
     *
     * @param $id
     * @return bool
     */
    public function addPack($id)
    {
        if (!$this->checkPackAvailable($id))
            return false;

        $transaction = Yii::app()->db->beginTransaction();
        try {
            Yii::app()->db->createCommand()
                ->insert('score__users_packs', array(
                'user_id' => $this->user_id,
                'pack_id' => $id
            ));

            $this->level_id++;
            $this->save();

            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollback();
            return false;
        }

        return true;
    }

    /**
     * Проверяем может ли юзер взять этот пакет (защите от хакеров)
     *
     * @param $pack_id
     * @return bool
     */
    public function checkPackAvailable($pack_id)
    {
        if (!$this->hasNewLevel())
            return false;

        $no_cheat = false;
        $packs = $this->getNextLevelPacks();
        foreach ($packs as $pack)
            if ($pack->id == $pack_id)
                $no_cheat = true;


        return $no_cheat;
    }
}