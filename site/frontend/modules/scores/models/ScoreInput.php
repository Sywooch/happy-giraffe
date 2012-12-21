<?php
/**
 * Author: alexk984
 * Date: 10.03.12
 */
class ScoreInput extends EMongoDocument
{
    const STATUS_OPEN = 1;
    const STATUS_CLOSED = 2;

    public $user_id;
    public $action_id;
    public $amount = 0;
    public $scores_earned;
    public $created;
    public $updated;
    public $status = self::STATUS_OPEN;

    public $added_items = array();
    public $removed_items = array();

    public $entity_id;

    private $_entity = null;

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getCollectionName()
    {
        return 'score_input';
    }

    public function indexes()
    {
        return array(
            'user_id_index' => array(
                'key' => array(
                    'user_id' => EMongoCriteria::SORT_DESC,
                ),
                'unique' => false,
            ),
            'created_index' => array(
                'key' => array(
                    'user_id' => EMongoCriteria::SORT_DESC,
                    'updated' => EMongoCriteria::SORT_DESC,
                ),
                'unique' => false,
            ),
        );
    }

    public function beforeSave()
    {
        if ($this->isNewRecord){
            $criteria = new EMongoCriteria;
            $criteria->user_id('==', (int)$this->user_id);
            $criteria->created('==', time());
            if (self::model()->find($criteria) !== null)
                $this->created = time() + 1;
            else
                $this->created = time();
            $this->updated = $this->created;
        }else
            $this->updated = time();

        if ($this->amount == 0) {
            if (!$this->isNewRecord)
                $this->delete();
            return false;
        }
        //check close task or not
        $action_info = ScoreAction::getActionInfo($this->action_id);
        if ($action_info['wait_time'] == 0)
            $this->status = self::STATUS_CLOSED;

        if ($this->status == self::STATUS_CLOSED) {
            $model = UserScores::model()->findByPk($this->user_id);
            if ($model !== null) {
                $model->scores += $this->scores_earned;
                $model->save();
            }else{
                $this->delete();
            }
        }

        return parent::beforeSave();
    }

    public function defaultScope()
    {
        return array(
            'order' => 'created DESC',
        );
    }

    /**
     * Открытое событие, которое произошло недавно. К нему можно прибавить еще пока оно не закрылось
     *
     * @param $user_id
     * @param $action_id
     * @param CActiveRecord $entity
     * @return ScoreInput
     */
    public function getActiveScoreInput($user_id, $action_id, $entity)
    {
        //check can we continue active task
        $action_info = ScoreAction::getActionInfo($action_id);
        if (!isset($action_info['wait_time']))
            return null;

        if ($action_info['wait_time'] == 0)
            return null;

        $criteria = new EMongoCriteria;
        $criteria->user_id('==', (int)$user_id);
        $criteria->action_id('==', (int)$action_id);
        $criteria->status('==', self::STATUS_OPEN);

        if ($action_id == ScoreAction::ACTION_100_VIEWS || $action_id == ScoreAction::ACTION_10_COMMENTS
            || $action_id == ScoreAction::ACTION_LIKE
        ) {
            $criteria->addCond('added_items.0.id', '==', (int)$entity->primaryKey);
            $criteria->addCond('added_items.0.entity', '==', get_class($entity));
        }

        if ($action_id == ScoreAction::ACTION_OWN_COMMENT) {
            $criteria->addCond('added_items.0.id', '==', (int)$entity['id']);
            $criteria->addCond('added_items.0.entity', '==', $entity['name']);
        }

        if ($action_id == ScoreAction::ACTION_PHOTO) {
            $criteria->addCond('entity_id', '==', (int)$entity->album_id);
        }

        $model = $this->find($criteria);
        if ($model === null) {
            $criteria = new EMongoCriteria;
            $criteria->user_id('==', (int)$user_id);
            $criteria->action_id('==', (int)$action_id);
            $criteria->status('==', self::STATUS_OPEN);

            if ($action_id == ScoreAction::ACTION_100_VIEWS || $action_id == ScoreAction::ACTION_10_COMMENTS
                || $action_id == ScoreAction::ACTION_LIKE || $action_id == ScoreAction::ACTION_PHOTO
            ) {
                $criteria->addCond('removed_items.0.id', '==', (int)$entity->primaryKey);
                $criteria->addCond('removed_items.0.entity', '==', get_class($entity));
            }

            if ($action_id == ScoreAction::ACTION_OWN_COMMENT) {
                $criteria->addCond('removed_items.0.id', '==', (int)$entity['id']);
                $criteria->addCond('removed_items.0.entity', '==', $entity['name']);
            }
            $model = $this->find($criteria);
        }
        return $model;
    }

    /**
     * @param $score_value
     * @param int $count
     * @param CActiveRecord $entity
     */
    public function addItem($score_value, $count = 1, $entity)
    {
        $this->amount = $this->amount + $count;
        $this->scores_earned += $score_value * $count;
        if ($entity !== null) {
            if (is_array($entity)) {
                $this->addItemsInAdded($entity['id'], $entity['name']);
            } else {
                $this->_entity = $entity;
                $this->addItemsInAdded($entity->primaryKey, get_class($entity));
                if ($this->action_id == ScoreAction::ACTION_PHOTO) {
                    $this->entity_id = (int)$entity->album_id;
                }
            }
        }
    }

    public function addItemsInAdded($entity_id, $entity)
    {
        if (in_array($this->action_id, array(ScoreAction::ACTION_FRIEND, ScoreAction::ACTION_PHOTO))
            || (empty($this->added_items) && empty($this->removed_items))
        ) {
            foreach ($this->added_items as $item) {
                if ($item['id'] == $entity_id && $item['entity'] == $entity)
                    return;
            }

            $this->added_items [] = array(
                'id' => (int)$entity_id,
                'entity' => $entity,
            );
        }
    }

    /**
     * @param $score_value
     * @param int $count
     * @param CActiveRecord $entity
     */
    public function removeItem($score_value, $count = 1, $entity)
    {
        $this->amount = $this->amount - $count;
        $this->scores_earned -= $score_value * $count;
        if ($entity !== null) {
            if (is_array($entity)) {
                $this->removed_items [] = array(
                    'id' => (int)$entity['id'],
                    'entity' => $entity['name'],
                );
            } else {
                if (in_array($this->action_id, array(ScoreAction::ACTION_FRIEND, ScoreAction::ACTION_PHOTO))
                    || (empty($this->added_items) && empty($this->removed_items))
                ) {
                    foreach ($this->added_items as $key => $added_item) {
                        if ($added_item['id'] == $entity->primaryKey &&
                            $added_item['entity'] == get_class($entity)
                        ) {
                            unset($this->added_items[$key]);
                            return;
                        }
                    }
                    $this->removed_items [] = array(
                        'id' => (int)$entity->primaryKey,
                        'entity' => get_class($entity),
                    );
                }

                if ($this->action_id == ScoreAction::ACTION_PHOTO) {
                    $this->entity_id = (int)$entity->album_id;
                }
            }
        }
    }

    /**
     * @static
     * Пользователю отображаются только закрытые события. Проверяем прошло ли время максимальной длительности
     * открытости события. Если прошло, закрываем
     */
    public static function CheckOnClose()
    {
        $ScoreAction = ScoreAction::model()->findAll('wait_time > 0');
        foreach ($ScoreAction as $action) {
            $criteria = new EMongoCriteria;
            $criteria->status('==', self::STATUS_OPEN);
            $criteria->action_id('==', (int)$action->id);
            $criteria->created('<', (int)(time() - $action->wait_time * 60));

            $need_close = ScoreInput::model()->findAll($criteria);
            foreach ($need_close as $model) {
                $model->status = self::STATUS_CLOSED;
                $model->save();
            }
//            $modifier = new EMongoModifier();
//            $modifier->addModifier('status', 'set', self::STATUS_CLOSED);
//            $modifier->addModifier('updated', 'set', time());
//            ScoreInput::model()->updateAll($modifier, $criteria);
        }
    }

    public function getIcon()
    {
        $icon = $this->getIconName();
        if (empty($icon))
            return '<i class="act-'.$this->action_id.'"></i>';
        return '<i class="' . $icon . ' act-'.$this->action_id.'"></i>';
    }

    public function getIconName()
    {
        switch ($this->action_id) {
            case ScoreAction::ACTION_FIRST_BLOG_RECORD:
            case ScoreAction::ACTION_RECORD:
                if ($this->amount > 0)
                    return 'icon-post';
                return 'icon-post-d';
            case ScoreAction::ACTION_10_COMMENTS:
            case ScoreAction::ACTION_OWN_COMMENT:
                if ($this->amount > 0)
                    return 'icon-comments';
                return 'icon-comment-d';
            case ScoreAction::ACTION_100_VIEWS:
                return 'icon-views';
            case ScoreAction::ACTION_PROFILE_PHOTO:
            case ScoreAction::ACTION_PROFILE_FAMILY:
            case ScoreAction::ACTION_PROFILE_INTERESTS:
            case ScoreAction::ACTION_PROFILE_BIRTHDAY:
            case ScoreAction::ACTION_PROFILE_EMAIL:
            case ScoreAction::ACTION_PROFILE_LOCATION:
            case ScoreAction::ACTION_PROFILE_FULL:
                return 'icon-ava';
            case ScoreAction::ACTION_PHOTO:
                return 'icon-photo';
            case ScoreAction::ACTION_FRIEND:
                return 'icon-friends';
        }

        return '';
    }

    public function getPoints()
    {
        if ($this->scores_earned > 0)
            return '+' . $this->scores_earned;
        else
            return $this->scores_earned;
    }

    /**
     * Получить текст события
     *
     * @return string
     */
    public function getText()
    {
        $text = '';
        switch ($this->action_id) {
            case ScoreAction::ACTION_PROFILE_PHOTO:
                $text = 'Вы <span>Добавили фото</span> в личной анкете';
                break;
            case ScoreAction::ACTION_PROFILE_FAMILY:
                $text = 'Вы заполнили данные <span>Семья</span> в личной анкете';
                break;
            case ScoreAction::ACTION_PROFILE_INTERESTS:
                $text = 'Вы заполнили данные <span>Интересы</span> в личной анкете';
                break;
            case ScoreAction::ACTION_PROFILE_BIRTHDAY:
                $text = 'Вы указали <span>День вашего рождения</span> в личной анкете';
                break;
            case ScoreAction::ACTION_PROFILE_EMAIL:
                $text = 'Вы подтвердили ваш <span>E-mail</span>';
                break;
            case ScoreAction::ACTION_PROFILE_LOCATION:
                $text = 'Вы указали ваше <span>Место жительства</span>';
                break;
            case ScoreAction::ACTION_PROFILE_FULL:
                $text = '<span>Вы прошли первые 6 шагов!</span>';
                break;

            case ScoreAction::ACTION_RECORD:
                $text = $this->getArticleText();
                break;
            case ScoreAction::ACTION_FIRST_BLOG_RECORD:
                $text = $this->getArticleText();
                break;

            case ScoreAction::ACTION_VISIT:
                $text = $this->getVisitText();
                break;
            case ScoreAction::ACTION_5_DAYS_ATTEND:
                $text = 'За посещение сайта в течение 5 дней подряд';
                break;
            case ScoreAction::ACTION_20_DAYS_ATTEND:
                $text = 'За посещение сайта в течение 20 дней подряд';
                break;

            case ScoreAction::ACTION_OWN_COMMENT:
                $text = $this->getOwnCommentText();
                break;

            case ScoreAction::ACTION_FRIEND:
                $text = $this->getFriendsText();
                break;

            case ScoreAction::ACTION_10_COMMENTS:
                $text = '';
                break;
            case ScoreAction::ACTION_100_VIEWS:
                $text = $this->getViewsArticleText();
                break;

            case ScoreAction::ACTION_PHOTO:
                $text = $this->getPhotoText();
                break;

            case ScoreAction::ACTION_LIKE:
                $text = $this->getRatingText();
                break;

            case ScoreAction::ACTION_CONTEST_PARTICIPATION:
                $text = 'Вы приняли участие в конкурсе';
                break;
        }

        return $text;
    }

    public function getVisitText()
    {
        if (date("Y-m-d", $this->created) == date("Y-m-d"))
            $text = 'За посещение сайта сегодня';
        else
            $text = 'За посещение сайта <span>' . Yii::app()->dateFormatter->format("d MMMM", $this->created) . '</span>';

        return $text;
    }

    /**
     * Получить текст если добавлена/удалена статья
     * @return string
     */
    public function getArticleText()
    {
        $text = '';
        if (empty($this->added_items) && empty($this->removed_items))
            return '';
        if ($this->amount > 0) {
            $class = $this->added_items[0]['entity'];
            $id = $this->added_items[0]['id'];
        } else {
            $class = $this->removed_items[0]['entity'];
            $id = $this->removed_items[0]['id'];
        }

        $model = $class::model()->resetScope()->findByPk($id);

        if ($model === null)
            return '';
        if ($this->action_id == ScoreAction::ACTION_FIRST_BLOG_RECORD)
            if ($this->amount > 0)
                $record_title = 'первую запись ';
            else
                $record_title = 'единственная запись ';
        else {
            $record_title = 'запись ';
        }

        if ($class == 'CommunityContent' || $class == 'BlogContent') {
            if ($this->amount > 0)
                if ($model->isFromBlog)
                    $text = 'Вы добавили ' . $record_title . '<span>' . $model->title . '</span> в блог';
                else
                    $text = 'Вы добавили ' . $record_title . '<span>' . $model->title . '</span> в клуб <span>' . $model->rubric->community->title . '</span>';
            if ($this->amount < 0) {
                if ($model->isFromBlog)
                    $text = 'Ваша ' . $record_title . '<span>' . $model->title . '</span> в блоге удалена';
                else {
                    $text = 'Ваша ' . $record_title . '<span>' . $model->title . '</span> в клубе <span>' . $model->rubric->community->title . '</span> удалена';
                }
            }
        }
        if ($class == 'RecipeBookRecipe') {
            if ($this->amount > 0)
                $text = 'Вы добавили ' . $record_title . ' <span>' . $model->title . '</span> в сервис <span>Книга народных рецептов</span>';
            if ($this->amount < 0) {
                $text = 'Ваша ' . $record_title . '<span>' . $model->title . '</span> в сервис <span>Книга народных рецептов</span> удалена';
            }
        }

        return $text;
    }

    /**
     * Получить текст для 100 просмотров статьи юзера
     * @return string
     */
    public function getViewsArticleText()
    {
        $text = '';
        if (empty($this->added_items))
            return $text;
        $class = $this->added_items[0]['entity'];
        $id = $this->added_items[0]['id'];

        $model = $class::model()->resetScope()->findByPk($id);
        if ($model === null)
            return $text;

        if ($class == 'CommunityContent' || $class == 'BlogContent') {
            if ($model->isFromBlog)
                $text = 100 * $this->amount . ' новых просмотров вашей записи <span>' . $model->title . '</span> в блоге';
            else
                $text = 100 * $this->amount . ' новых просмотров вашей записи <span>' . $model->title . '</span> в клубе <span>' . $model->rubric->community->title . '</span>';
        }

        return $text;
    }

    /**
     * Получить текст для 100 просмотров статьи юзера
     * @return string
     */
    public function get10CommentsText()
    {
        if (empty($this->added_items) && empty($this->removed_items))
            return '';

        $text = '';
        if ($this->amount > 0) {
            $class = $this->added_items[0]['entity'];
            $id = $this->added_items[0]['id'];
        } else {
            $class = $this->removed_items[0]['entity'];
            $id = $this->removed_items[0]['id'];
        }

        $model = $class::model()->resetScope()->findByPk($id);
        if ($model === null)
            return '';

        if ($class == 'CommunityContent' || $class == 'BlogContent') {
            if ($this->amount > 0) {
                if ($model->isFromBlog)
                    $text = 10 * $this->amount . ' новых комментариев к вашей записи <span>' . $model->title . '</span> в блоге';
                else
                    $text = 10 * $this->amount . ' новых комментариев к вашей записи <span>' . $model->title . '</span> в клубе <span>' . $model->rubric->community->title . '</span>';
            } else
                $text = abs(10 * $this->amount) . ' комментариев к вашей записи <span>' . $model->title . '</span> в клубе <span>' . $model->rubric->community->title . '</span> были удалены';
        }
        if ($class == 'RecipeBookRecipe') {
            if ($this->amount > 0) {
                $text = 10 * $this->amount . ' новых комментариев к вашей записи <span>' . $model->title . '</span> в сервисе <span>Книга народных рецептов</span>';
            } else
                $text = abs(10 * $this->amount) . ' комментариев к вашей записи <span>' . $model->title . '</span> в сервисе <span>Книга народных рецептов</span> были удалены';
        }

        return $text;
    }

    /**
     * Получить текст для добавления/удаления фото
     * @return string
     */
    public function getPhotoText()
    {
        if (empty($this->added_items) && empty($this->removed_items))
            return '';
        if ($this->amount > 0) {
            $class = $this->added_items[0]['entity'];
            $id = $this->added_items[0]['id'];
        } else {
            $class = $this->removed_items[0]['entity'];
            $id = $this->removed_items[0]['id'];
        }

        $model = CActiveRecord::model($class)->findByPk($id);
        if ($model === null)
            return '';
        if ($model->album === null)
            return '';

        if ($this->amount == 1)
            return 'Добавлено фото <span>' . $model->title . '</span> в фотоальбом <span>' . $model->album->title . '</span>';
        elseif ($this->amount > 1)
            return 'Добавлено ' . $this->amount . ' фото в фотоальбом <span>' . $model->album->title . '</span>';
        elseif ($this->amount == 1)
            return 'Вы удалили фото из альмоба <span>' . $model->album->title . '</span>';
        else
            return 'Вы удалили ' . abs($this->amount) . ' фото из альмоба <span>' . $model->album->title . '</span>';
    }

    /**
     * Получить текст для Созданных/удаленных юзером комментариев
     * @return string
     */
    public function getOwnCommentText()
    {
        if (empty($this->added_items) && empty($this->removed_items))
            return '';
        if ($this->amount > 0) {
            $class = $this->added_items[0]['entity'];
            $id = $this->added_items[0]['id'];
        } else {
            $class = $this->removed_items[0]['entity'];
            $id = $this->removed_items[0]['id'];
        }

        $model = $class::model()->resetScope()->findByPk($id);
        if ($model === null)
            return '';

        if ($class == 'User') {
            if ($this->amount == 1)
                $text = 'Вы добавили запись';
            elseif ($this->amount > 1)
                $text = 'Вы добавили ' . $this->amount . ' ' . HDate::GenerateNoun(array('запись', 'записи', 'записей'), $this->amount);
            elseif ($this->amount == -1)
                $text = 'Удалена ваша запись';
            else
                $text = 'Удалены ваши ' . abs($this->amount) . ' ' . HDate::GenerateNoun(array('запись', 'записи', 'записей'), abs($this->amount));

            if ($this->user_id == $id)
                $text .= ' в гостевой книге';
            else
                $text .= ' в гостевой книге пользователя <span>' . CHtml::encode($model->fullName) . '</span> ';
            return $text;
        }

        if ($class == 'AlbumPhoto') {
            if ($this->amount == 1)
                $text = 'Вы добавили комментарий к фото <img src="' . $model->getPreviewUrl(30, 30) . '">';
            elseif ($this->amount > 1)
                $text = 'Вы добавили ' . $this->amount . ' ' . HDate::GenerateNoun(array('комментарий', 'комментария', 'комментариев'), $this->amount) . ' к фото <img src="' . $model->getPreviewUrl(30, 30) . '">';
            elseif ($this->amount == -1)
                $text = 'Ваш комментарий к фото <img src="' . $model->getPreviewUrl(30, 30) . '">';
            else
                $text = 'Ваши ' . abs($this->amount) . ' ' . HDate::GenerateNoun(array('комментарий', 'комментария', 'комментариев'), abs($this->amount)) . ' к фото <img src="' . $model->getPreviewUrl(30, 30) . '">';

            if ($this->amount < -1) $text .= ' удалены';
            if ($this->amount == -1) $text .= ' удален';

            return $text;
        }

        if (!isset($model->title))
            return '';

        if ($this->amount == 1)
            $text = 'Вы добавили комментарий к записи <span>' . $model->title . '</span> ';
        elseif ($this->amount > 1)
            $text = 'Вы добавили ' . $this->amount . ' ' . HDate::GenerateNoun(array('комментарий', 'комментария', 'комментариев'), $this->amount) . ' к записи <span>' . $model->title . '</span> ';
        elseif ($this->amount == -1)
            $text = 'Ваш комментарий к записи <span>' . $model->title . '</span> ';
        else
            $text = 'Ваши ' . abs($this->amount) . ' ' . HDate::GenerateNoun(array('комментарий', 'комментария', 'комментариев'), abs($this->amount)) . ' к записи <span>' . $model->title . '</span> ';

        if ($class == 'CommunityContent' || $class == 'BlogContent') {

            if ($model->isFromBlog) {
                if ($model->author_id == $this->user_id)
                    $text .= ($this->amount > 0) ? 'в блог' : 'в блоге';
                else {
                    $text .= ($this->amount > 0) ? 'в блог' : 'в блоге';
                    $text .= ' <span>' . CHtml::encode($model->author->fullName) . '</span>';
                }
            } else {
                $text .= ($this->amount > 0) ? 'в клуб' : 'в клубе';
                if ($model->rubric_id !== null)
                    $text .= ' <span>' . $model->rubric->community->title . '</span>';
                else
                    $text .= ' <span>Утро с Веселым Жирафом</span>';
            }
        }
        if ($class == 'RecipeBookRecipe') {
            $text .= ($this->amount > 0) ? 'в сервис ' : 'в сервисе';
            $text .= ' <span>Книга народных рецептов</span>';
        }
        if ($this->amount < -1) $text .= ' удалены';
        if ($this->amount == -1) $text .= ' удален';

        return $text;
    }

    /**
     * Получить текст о новом друге или потере друга
     * @return string
     */
    public function getFriendsText()
    {
        if (empty($this->added_items) && empty($this->removed_items))
            return '';
        $text = '';

        $friends = array();
        foreach ($this->added_items as $item) {
            $class = $item['entity'];
            $id = $item['id'];

            $model = $class::model()->resetScope()->findByPk($id);
            if ($model !== null)
                $friends[] = $model;
        }

        if (count($friends) == 1)
            $text = 'У вас новый друг ' . CHtml::image($friends[0]->getAva('small')) . '&nbsp;<span>' . CHtml::encode($friends[0]->first_name) . '</span>';
        elseif (count($friends) > 1) {
            $text = 'У вас ' . count($friends) . ' ' . HDate::GenerateNoun(array('новый друг', 'новых друга', 'новых друзей'), $this->amount);
            foreach ($friends as $friend) {
                $text .= ' ' . CHtml::image($friend->getAva('small')) . ' <span>' . CHtml::encode($friend->first_name) . '</span>,';
            }
            $text = rtrim($text, ',');
            $text .= '<br>';
        }

        if (!empty($this->removed_items)) {
            $removed_friends = array();
            foreach ($this->removed_items as $item) {
                $class = $item['entity'];
                $id = $item['id'];

                $model = $class::model()->resetScope()->findByPk($id);
                if ($model !== null)
                    $removed_friends[] = $model;
            }

            if (count($friends) == 1)
                $text .= 'Вы потеряли друга ' . CHtml::image($friends[0]->getAva('small')) . ' <span>' . CHtml::encode($friends[0]->first_name) . '</span>';
            elseif (count($friends) > 1) {
                $text .= 'Вы потеряли ' . count($friends) . ' ' . HDate::GenerateNoun(array('друга', 'друзей', 'друзей'), $this->amount);
                foreach ($friends as $friend) {
                    $text .= ' ' . CHtml::image($friend->getAva('small')) . ' <span>' . CHtml::encode($friend->first_name) . '</span>, ';
                }
                $text = rtrim($text, ', ');
            }
        }

        return $text;
    }

    public function getRatingText()
    {
        $text = '';
        if (empty($this->added_items) && empty($this->removed_items))
            return '';
        if (!empty($this->added_items)) {
            $class = $this->added_items[0]['entity'];
            $id = $this->added_items[0]['id'];
        } else {
            $class = $this->removed_items[0]['entity'];
            $id = $this->removed_items[0]['id'];
        }

        $model = $class::model()->resetScope()->findByPk($id);

        if ($model === null)
            return '';

        if ($class == 'CommunityContent' || $class == 'BlogContent') {
            if ($this->amount > 0)
                if ($model->isFromBlog)
                    $text = 'Увеличен рейтинг вашей записи <span>' . $model->title . '</span> в блоге';
                else
                    $text = 'Увеличен рейтинг вашей записи <span>' . $model->title . '</span> в клубе <span>' . $model->rubric->community->title . '</span>';
            if ($this->amount < 0) {
                if ($model->isFromBlog)
                    $text = 'Понижен рейтинг вашей записи <span>' . $model->title . '</span> в блоге';
                else
                    $text = 'Понижен рейтинг вашей записи <span>' . $model->title . '</span> в клубе <span>' . $model->rubric->community->title . '</span>';
            }
        }
        if ($class == 'RecipeBookRecipe') {
            if ($this->amount > 0)
                $text = 'Увеличен рейтинг вашей записи <span>' . $model->title . '</span> в сервисе <span>Книга народных рецептов</span>';
            if ($this->amount < 0) {
                $text = 'Понижен рейтинг вашей записи <span>' . $model->title . '</span> в сервисе <span>Книга народных рецептов</span>';
            }
        }

        return $text;
    }
}