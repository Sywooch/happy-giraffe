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
     * @return type
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

    public function setEntity($entity, $entityId)
    {
        self::$session['FormDepartmentModelsControlEntity'] = $entity;
        self::$session['FormDepartmentModelsControlEntityId'] = $entityId;
    }

    public function getEntity()
    {
        if (isset(self::$session['FormDepartmentModelsControlEntity']) && self::$session['FormDepartmentModelsControlEntity'] != null)
        {
            return array(
                'entity' => self::$session['FormDepartmentModelsControlEntity'],
                'entityId' => self::$session['FormDepartmentModelsControlEntityId']
            );
        }
        return null;
    }

    public function clear()
    {
        self::$session['FormDepartmentModelsControlEntity'] = null;
        self::$session['FormDepartmentModelsControlEntityId'] = null;
    }

}
