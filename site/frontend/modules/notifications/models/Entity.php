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

    public function __construct($entity = false, $scenario = 'insert')
    {
        if ($entity)
        {
            $this->id = (int) $entity->id;
            $this->class = get_class($entity);
            $this->title = isset($entity->contentTitle) ? $entity->contentTitle : null;
            $this->tooltip = isset($entity->powerTipTitle) ? $entity->powerTipTitle : null;
            $this->url = isset($entity->url) ? $entity->url : null;
        }
        parent::__construct($scenario);
    }

}

?>
