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

    public $entity;
    public $entity_id;

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
        if ($this->isNewRecord)
            $this->created = time();
        $this->updated = time();

        if ($this->amount == 0) {
            if (!$this->isNewRecord)
                $this->delete();
            return false;
        }
        //check close task or not
        $action_info = ScoreActions::getActionInfo($this->action_id);
        if ($action_info['wait_time'] == 0)
            $this->status = self::STATUS_CLOSED;

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
        $action_info = ScoreActions::getActionInfo($action_id);
        if ($action_info['wait_time'] == 0)
            return null;

        $criteria = new EMongoCriteria;
        $criteria->user_id('==', (int)$user_id);
        $criteria->action_id('==', (int)$action_id);
        $criteria->status('==', self::STATUS_OPEN);

        if ($action_id == ScoreActions::ACTION_100_VIEWS || $action_id == ScoreActions::ACTION_10_COMMENTS) {
            $criteria->addCond('added_items.0.id', '==', (int)$entity->primaryKey);
            $criteria->addCond('added_items.0.entity', '==', get_class($entity));
        }

        if ($action_id == ScoreActions::ACTION_OWN_COMMENT) {
            $criteria->addCond('added_items.0.id', '==', (int)$entity['id']);
            $criteria->addCond('added_items.0.entity', '==', $entity['name']);
        }

        return $this->find($criteria);
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
                $this->addItemsInAdded($entity->primaryKey, get_class($entity));
            }
        }
    }

    public function addItemsInAdded($entity_id, $entity)
    {
        foreach ($this->added_items as $item) {
            if ($item['id'] == $entity_id && $item['entity'] == $entity)
                return;
        }

        $this->added_items [] = array(
            'id' => (int)$entity_id,
            'entity' => $entity,
        );
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
        }
    }

    /**
     * @static
     * Пользователю отображаются только закрытые события. Проверяем прошло ли время максимальной длительности
     * открытости события. Если прошло, закрываем
     */
    public static function CheckOnClose()
    {
        $scoreActions = ScoreActions::model()->findAll('wait_time > 0');
        foreach ($scoreActions as $action) {
            $criteria = new EMongoCriteria;
            $criteria->status('==', self::STATUS_OPEN);
            $criteria->action_id('==', (int)$action->id);
            $criteria->created('<', (int)(time() + $action->wait_time * 60));

            $modifier = new EMongoModifier();
            $modifier->addModifier('status', 'set', self::STATUS_CLOSED);
            ScoreInput::model()->updateAll($modifier, $criteria);
        }
    }

    public function getIcon()
    {
        $icon = $this->getIconName();
        if (empty($icon))
            return '';
        return '<i class="' . $icon . '"></i>';
    }

    public function getIconName()
    {
        switch ($this->action_id) {
            case ScoreActions::ACTION_RECORD:
                if ($this->amount > 0)
                    return 'icon-post';
                return 'icon-post-d';
            case ScoreActions::ACTION_10_COMMENTS:
            case ScoreActions::ACTION_OWN_COMMENT:
                if ($this->amount > 0)
                    return 'icon-comments';
                return 'icon-comments-d';
            case ScoreActions::ACTION_100_VIEWS:
                return 'icon-views';
            case ScoreActions::ACTION_PROFILE_PHOTO:
            case ScoreActions::ACTION_PROFILE_FAMILY:
            case ScoreActions::ACTION_PROFILE_INTERESTS:
            case ScoreActions::ACTION_PROFILE_MAIN:
                return 'icon-ava';
            case ScoreActions::ACTION_PHOTO:
                return 'icon-photo';
            case ScoreActions::ACTION_FRIEND:
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

    public function getText()
    {
        $text = '';
        switch ($this->action_id) {
            case ScoreActions::ACTION_PROFILE_PHOTO:
                $text = 'Вы <span>Добавили фото</span> в личной анкете';
                break;
            case ScoreActions::ACTION_PROFILE_FAMILY:
                $text = 'Вы заполнили данные <span>Семья</span> в личной анкете';
                break;
            case ScoreActions::ACTION_PROFILE_INTERESTS:
                $text = 'Вы заполнили данные <span>Интересы</span> в личной анкете';
                break;
            case ScoreActions::ACTION_PROFILE_MAIN:
                $text = 'Вы заполнили данные <span>Личная информация</span> в личной анкете';
                break;

            case ScoreActions::ACTION_RECORD:
                $text = $this->getArticleText();
                break;

            case ScoreActions::ACTION_VISIT:
                $text = 'За посещение сайта сегодня';
                break;
            case ScoreActions::ACTION_5_DAYS_ATTEND:
                $text = 'За посещение сайта в течение 5 дней подряд';
                break;
            case ScoreActions::ACTION_20_DAYS_ATTEND:
                $text = 'За посещение сайта в течение 20 дней подряд';
                break;

            case ScoreActions::ACTION_OWN_COMMENT:
                $text = $this->getOwnCommentText();
                break;

            case ScoreActions::ACTION_10_COMMENTS:
                $text = '';
                break;
            case ScoreActions::ACTION_100_VIEWS:
                $text = '100 новых просмотров вашей записи ' . $this->getViewsArticleText();
                break;

            case ScoreActions::ACTION_PHOTO:
                $text = $this->getPhotoText();
                break;
        }

        return $text;
    }

    public function getArticleText()
    {
        if (empty($this->added_items))
            return '';
        $class = $this->added_items[0]['entity'];
        $id = $this->added_items[0]['id'];

        $model = $class::model()->findByPk($id);
        if ($model === null)
            return '';

        if ($this->amount > 0)
            if ($class == 'CommunityContent') {
                if ($model->isFromBlog)
                    return 'Вы добавили запись ' . $model->name . ' в блог';
                else
                    return 'Вы добавили запись <span>' . $model->name . '</span> в клуб <span>' . $model->rubric->community->name . '</span>';
            }
        if ($this->amount < 0) {
            if ($model->isFromBlog)
                return 'Ваша запись  ' . $model->name . ' в блоге удалена';
            else
                return 'Ваша запись  <span>' . $model->name . '</span> в клубе <span>' . $model->rubric->community->name . '</span> удалена';
        }
    }

    public function getViewsArticleText()
    {
        if (empty($this->added_items))
            return '';
        $class = $this->added_items[0]['entity'];
        $id = $this->added_items[0]['id'];

        $model = $class::model()->findByPk($id);
        if ($model === null)
            return '';

        if ($class == 'CommunityContent') {
            if ($model->isFromBlog)
                return '100 новых просмотров вашей записи <span>' . $model->name . '</span> в блоге';
            else
                return '100 новых просмотров вашей записи <span>' . $model->name . '</span> в клубе <span>' . $model->rubric->community->name . '</span>';
        }
    }

    public function getPhotoText()
    {
        if (empty($this->added_items))
            return '';
        $class = $this->added_items[0]['entity'];
        $id = $this->added_items[0]['id'];

        $model = $class::model()->findByPk($id);
        if ($model === null)
            return '';

        if ($this->amount == 1)
            return 'Добавлено фото <span>' . $model->title . '</span> в фотоальбом <span>' . $model->album->title . '</span>';
        elseif ($this->amount > 1)
            return 'Добавлено ' . $this->amount . ' фото в фотоальбом <span>' . $model->album->title . '</span>';
        else
            return 'Вы удалили фото из альмоба <span>' . $model->album->title . '</span>';
    }

    public function getOwnCommentText()
    {
        if (empty($this->added_items))
            return '';
        $class = $this->added_items[0]['entity'];
        $id = $this->added_items[0]['id'];

        $model = $class::model()->findByPk($id);
        if ($model === null)
            return '';

        if ($this->amount == 1)
            return 'Вы добавили комментарий к записи <span>' . $model->name . '</span>';
        elseif ($this->amount > 1)
            return 'Вы добавили ' . $this->amount . ' ' . HDate::GenerateNoun(array('комментарий', 'комментария', 'комментариев'), $this->amount) . ' к записи <span>' . $model->name . '</span>';
        else
            return 'Вы удалили ' . abs($this->amount) . ' ' . HDate::GenerateNoun(array('комментарий', 'комментария', 'комментариев'), $this->amount) . ' к записи <span>' . $model->name . '</span>';
    }

    public function getFriendsText()
    {
        if (empty($this->added_items))
            return '';
        $friends = array();
        foreach ($this->added_items as $item) {
            $class = $item['entity'];
            $id = $item['id'];

            $model = $class::model()->findByPk($id);
            if ($model !== null)
                $friends[] = $model;
        }

        if (empty($friends))
            return '';

        if (count($friends) == 1)
            return 'У вас новый друг ' . $friends[0]->getAva('small') . ' <span>' . $friends[0]->first_name . '</span>';
        else {
            $text = 'У вас ' . count($friends) . ' ' . HDate::GenerateNoun(array('новый друг', 'новых друга', 'новых друзей'), $this->amount);
            foreach ($friends as $friend) {
                $text .= ' ' . $friend->getAva('small') . ' <span>' . $friend->first_name . '</span>';
            }
            $text .= '<br>';
        }

        if (!empty($this->removed_items)) {
            $removed_friends = array();
            foreach ($this->removed_items as $item) {
                $class = $item['entity'];
                $id = $item['id'];

                $model = $class::model()->findByPk($id);
                if ($model !== null)
                    $removed_friends[] = $model;
            }

            if (count($friends) == 1)
                return 'Вы потеряли друга ' . $friends[0]->getAva('small') . ' <span>' . $friends[0]->first_name . '</span>';
            elseif (count($friends) > 1) {
                $text .= 'Вы потеряли ' . count($friends) . ' ' . HDate::GenerateNoun(array('друга', 'друзей', 'друзей'), $this->amount);
                foreach ($friends as $friend) {
                    $text .= ' ' . $friend->getAva('small') . ' <span>' . $friend->first_name . '</span>';
                }
            }
        }

        return $text;
    }
}