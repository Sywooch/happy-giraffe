<?php

namespace site\frontend\modules\posts\widgets;

/**
 * Description of compilerWidget
 *
 * @author Кирилл
 */
class СompilerWidget extends \CWidget
{

    /**
     *
     * @var string Имя представления, которое должно соответствовать файлам в
     * compiler\<имя>.php и compiler\<имя>_preview.php,
     * если false, то будет использована таблица $views
     */
    public $view = false;

    /**
     *
     * @var object Модель, которая должна быть скомпилирована.
     */
    public $model;

    /**
     *
     * @var bool true - будет использовано представление для анонса
     */
    public $preview = false;

    /**
     *
     * @var array Массив соответствия классов моделей и их представлений
     */
    public $views = array(
        'site\frontend\modules\som\modules\status\models\Status' => 'status',
        'site\frontend\modules\som\modules\photopost\models\Photopost' => 'photopost',
    );

    public function getView($preview = false)
    {
        return 'compiler/' . ($this->view ? : $this->getViewByClass(get_class($this->model))) . ($this->preview ? '_preview' : '');
    }

    public function getViewByClass($class)
    {
        return $this->views[$class];
    }

    public function run()
    {
        $this->render($this->getView($this->preview), array('model' => $this->model));
    }

}
