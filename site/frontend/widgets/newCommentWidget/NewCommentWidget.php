<?php

class NewCommentWidget extends CWidget
{
    /**
     * @var HActiveRecord модель, к которой привязываются комментарии
     */
    public $model;
    /**
     * @var string Название класса модели
     */
    public $entity;
    /**
     * @var int Primary key модели
     */
    public $entity_id;
    /**
     * @var bool Имя созданного js объекта
     */
    public $objectName = false;
    /**
     * @var bool показываем ли все комментарии
     */
    public $full = true;
    /**
     * @var bool Только загрузить скрипты
     */
    public $registerScripts = false;

    public function init()
    {
        if ($this->model) {
            $this->entity = get_class($this->model);
            $this->entity_id = $this->model->primaryKey;
        } elseif ($this->entity) {
            $model = call_user_func(array($this->entity, 'model'));
            $this->model = $model->findByPk($this->entity_id);
        }
    }

    public function run()
    {
        self::registerScripts();

        if ($this->registerScripts === false) {
            $this->objectName = 'new_comment_' . $this->entity . $this->entity_id . time();
            $this->render('view', array('comments' => $this->getComments()));
        }
    }

    public static function registerScripts()
    {
        $basePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR;
        $baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
        Yii::app()->clientScript
            ->registerScriptFile($baseUrl . '/comment.js', CClientScript::POS_HEAD)
            ->registerScriptFile('/javascripts/knockout-2.2.1.js')
            ->registerScriptFile('/javascripts/knockout.mapping-latest.js');
    }

    private function getComments()
    {
        if ($this->full) {
            $dataProvider = Comment::model()->get($this->entity, $this->entity_id, 1000);
            return $dataProvider->getData();
        } else {
            $criteria = new CDbCriteria(array(
                'condition' => 't.entity=:entity AND t.entity_id=:entity_id',
                'params' => array(':entity' => $this->entity, ':entity_id' => $this->entity_id),
                'with' => array(
                    'author' => array(
                        'select' => 'id, gender, first_name, last_name, online, avatar_id, deleted',
                        'with' => 'avatar',
                    )
                ),
                'order' => 't.created DESC',
                'limit' => 3,
            ));
            return Comment::model()->findAll($criteria);
        }
    }
}