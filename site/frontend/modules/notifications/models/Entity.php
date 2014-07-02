<?php

namespace site\frontend\modules\notifications\models;

/**
 * Description of Entity
 *
 * @property-read string $type тип контента: post,video,photo,status,question,comment
 * @author Кирилл
 */
class Entity extends \EMongoEmbeddedDocument implements \IHToJSON
{

    public $id;
    public $class;
    public $tooltip;
    public $title;
    public $url;
    public $userId;
    public $typeId;

    public function __construct($entity = false, $scenario = 'insert')
    {
        if ($entity)
        {
            $this->id = isset($entity->id) ? (int) $entity->id : null;
            $this->class = get_class($entity);
            $this->title = isset($entity->contentTitle) ? $entity->contentTitle : null;
            $this->tooltip = isset($entity->powerTipTitle) ? $entity->powerTipTitle : null;
            $this->url = isset($entity->url) ? $entity->url : null;
            $this->userId = isset($entity->author_id) ? (int) $entity->author_id : null;
            if($entity instanceof \CommunityContent)
                $this->typeId = (int) $entity->type_id;
        }
        parent::__construct($scenario);
    }

    public function getType()
    {
        $result = 'post';
        if (is_subclass_of($this->class, 'CommunityContent') || $this->class == 'CommunityContent')
        {
            switch ($this->typeId)
            {
                case \CommunityContentType::TYPE_POST:
                    $result = 'post';
                    break;
                case \CommunityContentType::TYPE_VIDEO:
                    $result = 'video';
                    break;
                case \CommunityContentType::TYPE_PHOTO:
                    $result = 'photo';
                    break;
                case \CommunityContentType::TYPE_STATUS:
                    $result = 'status';
                    break;
                case \CommunityContentType::TYPE_QUESTION:
                    $result = 'question';
                    break;
            }
        }
        elseif ($this->class == 'AlbumPhoto')
        {
            $result = 'photo';
        }
        elseif ($this->class == 'Comment')
        {
            $result = 'comment';
        }

        return $result;
    }
    
    public function toJSON()
    {
        return array(
            'tooltip' => $this->tooltip,
            'title' => $this->title,
            'url' => $this->url,
            'type' => $this->type,
        );
    }

}

?>
