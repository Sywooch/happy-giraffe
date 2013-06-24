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
        $this->objectName = 'new_comment_' . $this->entity . $this->entity_id . time();

        $basePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR;
        $baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
        Yii::app()->clientScript->registerScriptFile($baseUrl . '/comment.js', CClientScript::POS_HEAD);

        $this->render('list', array(
            'dataProvider' => $this->getDataProvider(),
        ));
    }

    private function getDataProvider()
    {
        $dataProvider = Comment::model()->get($this->entity, $this->entity_id, 'default', 1000);
        $dataProvider->getData();
        if (isset($_GET['lastPage'])) {
            $dataProvider->pagination->currentPage = $dataProvider->pagination->pageCount;
            $dataProvider->data = null;
            unset($_GET['lastPage']);
        }

        return $dataProvider;
    }
}