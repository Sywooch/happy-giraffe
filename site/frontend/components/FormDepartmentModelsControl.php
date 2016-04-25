<?php

namespace site\frontend\components;

/**
 * Класс для защиты форм от повторного отправления. Сохраняет в сессию 
 * сгенерированный url  и не позволяет создать пост до тех пор пока не отчищен.
 *
 * @author danil
 */
class FormDepartmentModelsControl
{

    private static $_instans = null;

    /**
     *
     * @var \CHttpSession
     */
    private static $session = null;

    /**
     * singleton
     * @return FormDepartmentModelsControl
     */
    public static function getInstance()
    {
        if (self::$_instans == null)
        {
            self::$_instans = new self();
            self::$session = new \CHttpSession();
            self::$session->open();
        }
        return self::$_instans;
    }

    /**
     * запоминаем данные о созданном посте для заданной формы
     * @param string $key
     * @param string $entity
     * @param int $entityId
     */
    public function setEntity($key, $entity, $entityId)
    {
        self::$session[$key] = array(
            'FormDepartmentModelsControlEntity' => $entity,
            'FormDepartmentModelsControlEntityId' => $entityId
        );
    }

    /**
     * возвращаем данные о созданном посте для формы
     * @param string $key
     * @return mixed
     */
    public function getEntity($key)
    {
        if (isset(self::$session[$key]['FormDepartmentModelsControlEntity']) && isset(self::$session[$key]['FormDepartmentModelsControlEntity']) && self::$session[$key]['FormDepartmentModelsControlEntity'] != null)
        {
            return array(
                'entity' => self::$session[$key]['FormDepartmentModelsControlEntity'],
                'entityId' => self::$session[$key]['FormDepartmentModelsControlEntityId']
            );
        }
        return null;
    }

    /**
     * создать новый ключ формы для отслеживания уникальности создания постов
     * @return string
     */
    public function createNewFormKey()
    {
        $key = uniqid();
        self::$session[$key] = array();
        return $key;
    }

}
