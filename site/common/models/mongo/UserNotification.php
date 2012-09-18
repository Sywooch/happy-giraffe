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

    private $_types = array(
        self::NEW_COMMENT => array(
            'method' => 'newComment',
            'view' => 'site.common.views.UserNotification.newComment',
        ),
        self::NEW_REPLY => array(
            'method' => 'newReply',
            'view' => 'site.common.views.UserNotification.newReply',
        ),
    );

    public $type;
    public $created;

    public $recipient_id;
    public $initiator_id;
    public $text;
    public $url;

    public function getCollectionName()
    {
        return 'notifications';
    }

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function rules()
    {
        return array(
            array('recipient_id', 'compare', 'compareAttribute' => 'initiator_id', 'operator' => '!='),
        );
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
        if (! (in_array($entityName, array('CommunityContent', 'User', 'CookRecipe')) || $entityName == 'AlbumPhoto' && $entity->album !== null))
            return false;

        $this->recipient_id = (int) ($entityName != 'User') ? $entity->author_id : $entity->id;
        $this->initiator_id = (int) $comment->author_id;
        $this->url = $comment->url;

        $line1 = CHtml::link($comment->author->fullName, $comment->author->url) . ' ' . HDate::simpleVerb('добавил', $comment->author->gender) . ' ' . (($entityName == 'User') ? 'запись' : 'комментарий') . CHtml::tag('br');
        switch (get_class($entity)) {
            case 'CommunityContent':
                if ($entity->isFromBlog) {
                    $line2 = 'к вашей записи ' . CHtml::link($entity->title, $entity->url) . ' в блоге';
                } else {
                    $line2 = 'к вашей записи ' . CHtml::link($entity->title, $entity->url) . ' в сообществе ' . CHtml::link($entity->rubric->community->title, $entity->rubric->community->url);
                }
                break;
            case 'User':
                $line2 = 'в вашей гостевой книге';
                break;
            case 'CookRecipe':
                $line2 = 'к вашему рецепту ' . CHtml::link($entity->title, $entity->url);
                break;
            case 'AlbumPhoto':
                $line2 = 'к вашему фото ' . CHtml::link($entity->title, $entity->url) . ' в альбоме ' . CHtml::link($entity->album->title, $entity->album->url);
                break;
        }
        $this->text = $line1 . $line2;
        return true;
    }

    /**
     * @param $comment Comment
     */
    public function newReply($comment)
    {
        $entity = CActiveRecord::model($comment->entity)->findByPk($comment->entity_id);
        $entityName = get_class($entity);
        if (! (in_array($entityName, array('CommunityContent', 'User', 'CookRecipe')) || $entityName == 'AlbumPhoto' && $entity->album !== null))
            return false;

        $this->recipient_id = (int) $comment->response->author_id;
        $this->initiator_id = (int) $comment->author_id;
        $this->url = $comment->url;

        $line1 = CHtml::link($comment->author->fullName, $comment->author->url) . ' ' . HDate::simpleVerb('ответил', $comment->author->gender) . ' на ваш комментарий' . CHtml::tag('br');
        switch (get_class($entity)) {
            case 'CommunityContent':
                if ($entity->isFromBlog) {
                    $line2 = 'к записи ' . CHtml::link($entity->title, $entity->url) . ' в блоге';
                } else {
                    $line2 = 'к записи ' . CHtml::link($entity->title, $entity->url) . ' в сообществе ' . CHtml::link($entity->rubric->community->title, $entity->rubric->community->url);
                }
                break;
            case 'CookRecipe':
                $line2 = 'к рецепту ' . CHtml::link($entity->title, $entity->url);
                break;
            case 'AlbumPhoto':
                $line2 = 'к фото ' . CHtml::link($entity->title, $entity->url) . ' в альбоме ' . CHtml::link($entity->album->title, $entity->album->url);
                break;
        }
        $this->text = $line1 . $line2;
        return true;
    }
}