<?php

namespace site\frontend\modules\editorialDepartment\models;

/**
 * Description of Comment
 *
 * @author Кирилл
 * @property \site\frontend\modules\editorialDepartment\models\Meta $meta Мета-информация
 * @property \site\frontend\modules\editorialDepartment\models\Social $meta Данные для кнопки репоста
 */
class Content extends \EMongoDocument
{

    public $entity;
    public $entityId;
    public $clubId;
    public $forumId;
    public $rubricId;
    public $title;
    public $markDownPreview;
    public $htmlTextPreview;
    public $markDown;
    public $htmlText;
    public $authorId;
    public $fromUserId;
    public $dtimeCreate;
    public $dtimeUpdate;

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
    
    public function rules()
    {
        return array(
            // Проверим, что пользователь может писать от имени указанного им пользователя
            array('fromUserId', 'in', 'allowEmpty' => false, 'range' => \site\frontend\modules\editorialDepartment\components\UsersControl::getUsersList()),
        );
    }

        public function embeddedDocuments()
    {
        return array(
            'meta' => '\site\frontend\modules\editorialDepartment\models\Meta',
            'social' => '\site\frontend\modules\editorialDepartment\models\Social',
        );
    }
    
    public function behaviors()
    {
        return array(
            'converter' => array(
                'class' => '\site\frontend\modules\editorialDepartment\behaviors\ConvertBehavior',
            ),
        );
    }

    public function getCollectionName()
    {
        return 'editorialDepartmentContent';
    }

}

?>
