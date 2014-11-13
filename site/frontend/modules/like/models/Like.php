<?php

namespace site\frontend\modules\like\models;

/**
 * Description of Like
 *
 * @author Кирилл
 */
class Like extends \HGLike implements \IHToJSON
{

    // в оригинальной модели всё плохо, но переделывать некогда.
    // пока будем использовать новую модель, а потом будем переделывать.
    private static $_instance;

    /**
     * @return HGLike
     */
    public static function model()
    {
        if (null === self::$_instance) {
            self::$_instance = new self();
        }

        return self::$_instance;
    }

    public function toJSON()
    {
        /** @todo Реализовать */
    }

    public function countByEntity($entity)
    {
        /* скопировано и расширен интерфейс, отностилеьно оригинального */
        if (is_object($entity)) {
            if (method_exists($entity, 'getIsFromBlog')) {
                if ($entity->getIsFromBlog())
                    $entity_name = 'BlogContent';
                else
                    $entity_name = 'CommunityContent';
            }
            else
                $entity_name = get_class($entity);
            $entity_id = (int) $entity->primaryKey;
        } else {
            $entity_id = (int) $entity['entityId'];
            $entity_name = $entity['entity'];
        }

        return $this->getCollection()->count(array(
                'entity_id' => $entity_id,
                'entity_name' => $entity_name,
        ));
    }

    /**
     * Лайкал ли пользователь запись
     *
     * @param CommunityContent|Comment $entity
     * @param int $user_id
     * @return bool
     */
    public function hasLike($entity, $user_id)
    {
        /* скопировано и расширен интерфейс, отностилеьно оригинального */
        if (is_object($entity)) {
            if (method_exists($entity, 'getIsFromBlog')) {
                if ($entity->getIsFromBlog())
                    $entity_name = 'BlogContent';
                else
                    $entity_name = 'CommunityContent';
            }
            else
                $entity_name = get_class($entity);
            $entity_id = (int) $entity->primaryKey;
        } else {
            $entity_id = (int) $entity['entityId'];
            $entity_name = $entity['entity'];
        }

        return $this->getCollection()->findOne(array(
                'entity_id' => $entity_id,
                'entity_name' => $entity_name,
                'user_id' => (int) $user_id,
            )) !== null;
    }

}

?>
