<?php

namespace site\frontend\modules\notifications\models;

/**
 * Description of Entity
 *
 * @author Кирилл
 */
class Entity extends \EMongoEmbeddedDocument
{

    public $id;
    public $class;
    public $tooltip;
    public $title;
    public $url;
    public $userId;

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
        }
        parent::__construct($scenario);
    }

}

?>
