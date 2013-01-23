<?php
/**
 * Created by JetBrains PhpStorm.
 * User: choo
 * Date: 3/10/12
 * Time: 6:17 PM
 * To change this template use File | Settings | File Templates.
 */
class UserNotification extends EMongoDocument
{
    const NEW_COMMENT = 0;
    const NEW_REPLY = 1;
    const CONTEST_WORK_REMOVED = 2;

    private $_types = array(
        self::NEW_COMMENT => array(
            'method' => 'newComment',
        ),
        self::NEW_REPLY => array(
            'method' => 'newReply',
        ),
        self::CONTEST_WORK_REMOVED => array(
            'method' => 'newRemoved',
        ),
    );

    public $type;
    public $created;

    public $recipient_id;
    public $initiator_id;
    public $text;
    public $url;
    public $entity;

    public function getCollectionName()
    {
        return 'notifications';
    }

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function init()
    {
        parent::init();

        Yii::import('application.modules.contest.models.*');
    }

    public function rules()
    {
        return array(
//            array('recipient_id', 'compare', 'compareAttribute' => 'initiator_id', 'operator' => '!='),
        );
    }

    protected function afterSave()
    {
        $comet = new CometModel;
        $comet->send($this->recipient_id, array(
            'html' => Yii::app()->controller->renderPartial('//userPopup/_notification', array('data' => $this), true),
        ), CometModel::TYPE_NEW_NOTIFICATION);

        parent::afterSave();
    }

    public function deleteByEntity($entity, $user_id)
    {
        $entity_name = get_class($entity);
        #TODO костыль
        if ($entity_name == 'SimpleRecipe' || $entity_name == 'MultivarkaRecipe')
            $entity_name = 'CookRecipe';

        $criteria = new EMongoCriteria(array(
            'conditions' => array(
                'recipient_id' => array('equals' => (int) $user_id),
                'entity.id' => array('equals' => (int) $entity->id),
                'entity.name' => array('equals' => $entity_name),
            ),
        ));

        $this->deleteAll($criteria);
    }

    public function getUserCriteria($user_id)
    {
        $criteria = new EMongoCriteria;
        $criteria->recipient_id = (int) $user_id;
        $criteria->sort('created', EMongoCriteria::SORT_DESC);
        return $criteria;
    }

    public function getUserCount($user_id)
    {
        return $this->count($this->getUserCriteria($user_id));
    }

    public function getUserNotifications($user_id)
    {
        return new EMongoDocumentDataProvider($this, array(
            'criteria' => $this->getUserCriteria($user_id),
            'pagination' => array(
                'pageSize' => 20,
            ),
        ));
    }

    public function create($type, $params = array())
    {
        $model = new self;
        $model->type = $type;
        $model->created = time();
        $method = $this->_types[$type]['method'];
        if (call_user_func_array(array($model, $method), $params))
            $model->save();
    }

    /**
     * @param $comment Comment
     */
    public function newComment($comment)
    {
        $entity = CActiveRecord::model($comment->entity)->findByPk($comment->entity_id);
        $entityName = get_class($entity);
        if (! (in_array($entityName, array('CommunityContent', 'BlogContent', 'User', 'CookRecipe')) ||
            $entityName == 'AlbumPhoto' && ($entity->album !== null || $entity->getAttachByEntity('ContestWork') !== null)))
            return false;

        $this->recipient_id = (int) (($entityName != 'User') ? $entity->author_id : $entity->id);
        $this->initiator_id = (int) $comment->author_id;
        if ($this->recipient_id == $this->initiator_id)
            return false;

        $this->url = $comment->url;

        $line1 = CHtml::link($comment->author->fullName, $comment->author->url) . ' ' . HDate::simpleVerb('добавил', $comment->author->gender) . ' ' . (($entityName == 'User') ? 'запись' : 'комментарий') . CHtml::tag('br');
        switch (get_class($entity)) {
            case 'BlogContent':
                $line2 = 'к вашей записи ' . CHtml::link($entity->title, $entity->url) . ' в блоге';
                break;
            case 'CommunityContent':
                $line2 = 'к вашей записи ' . CHtml::link($entity->title, $entity->url) . ' в сообществе ' . CHtml::link($entity->rubric->community->title, $entity->rubric->community->url);
                break;
            case 'User':
                $line2 = 'в вашей гостевой книге';
                break;
            case 'CookRecipe':
                $line2 = 'к вашему рецепту ' . CHtml::link($entity->title, $entity->url);
                break;
            case 'AlbumPhoto':
                if ($entity->getAttachByEntity('ContestWork') === null) {
                    $line2 = 'к вашему фото ' . CHtml::link($entity->title, $entity->url) . ' в альбоме ' . CHtml::link($entity->album->title, $entity->album->url);
                } else {
                    $model = $entity->getAttachByEntity('ContestWork')->model;
                    $line2 = 'к вашей работе ' . CHtml::link($model->title, Yii::app()->createUrl('/albums/singlePhoto', array('entity' => 'Contest', 'contest_id' => $model->contest_id, 'photo_id' => $entity->id))) . ' на конкурсе ' . CHtml::link($model->contest->title, $model->contest->url);
                    $this->url = Yii::app()->createUrl('/albums/singlePhoto', array('entity' => 'Contest', 'contest_id' => $model->contest_id, 'photo_id' => $entity->id));
                }
                break;
        }
        $this->text = $line1 . $line2;
        $this->entity = array(
            'name' => $entityName,
            'id' => (int) $entity->id,
        );
        return true;
    }

    /**
     * @param $comment Comment
     */
    public function newReply($comment)
    {
        $entity = CActiveRecord::model($comment->entity)->findByPk($comment->entity_id);
        $entityName = get_class($entity);
        if (! (in_array($entityName, array('CommunityContent', 'BlogContent', 'CookRecipe')) || $entityName == 'AlbumPhoto' && ($entity->album !== null || ($attach = $entity->getAttachByEntity('ContestWork')) !== null)))
            return false;

        $this->recipient_id = (int) $comment->response->author_id;
        $this->initiator_id = (int) $comment->author_id;
        if ($this->recipient_id == $this->initiator_id)
            return false;

        $this->url = $comment->url;

        $line1 = CHtml::link($comment->author->fullName, $comment->author->url) . ' ' . HDate::simpleVerb('ответил', $comment->author->gender) . ' на ваш комментарий' . CHtml::tag('br');
        switch (get_class($entity)) {
            case 'BlogContent':
                $line2 = 'к записи ' . CHtml::link($entity->title, $entity->url) . ' в блоге';
                break;
            case 'CommunityContent':
                $line2 = 'к записи ' . CHtml::link($entity->title, $entity->url) . ' в сообществе ' . CHtml::link($entity->rubric->community->title, $entity->rubric->community->url);
                break;
            case 'CookRecipe':
                $line2 = 'к рецепту ' . CHtml::link($entity->title, $entity->url);
                break;
            case 'AlbumPhoto':
                if ($attach === null) {
                    $line2 = 'к фото ' . CHtml::link($entity->title, $entity->url) . ' в альбоме ' . CHtml::link($entity->album->title, $entity->album->url);
                } else {
                    $model = $attach->model;
                    $line2 = 'к работе ' . CHtml::link($model->title, Yii::app()->createUrl('/albums/singlePhoto', array('entity' => 'Contest', 'contest_id' => $model->contest_id, 'photo_id' => $entity->id))) . ' на конкурсе ' . CHtml::link($model->contest->title, $model->contest->url);
                    $this->url = Yii::app()->createUrl('/albums/singlePhoto', array('entity' => 'Contest', 'contest_id' => $model->contest_id, 'photo_id' => $entity->id));
                }
                break;
        }
        $this->text = $line1 . $line2;
        $this->entity = array(
            'name' => $entityName,
            'id' => (int) $entity->id,
        );
        return true;
    }

    /**
     * @param $model ContestWork
     */
    public function newRemoved($model)
    {
        $this->recipient_id = (int) $model->user_id;
        $this->initiator_id = (int) Yii::app()->user->id;
        $this->url = null;
        $this->text = 'Ваша фотография снята с фотоконкурса ' . CHtml::link($model->contest->title, $model->contest->url) . ' по причине  несоответствия правилам конкурса';
        $this->entity = array(
            'name' => get_class($model),
            'id' => (int) $model->id,
        );
        return true;
    }
}