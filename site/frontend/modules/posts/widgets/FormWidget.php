<?php

namespace site\frontend\modules\posts\widgets;

/**
 * Виджет для добавления формы на страницу, позволяющую добавлять контент разных типов.
 *
 * @author Кирилл
 */
class FormWidget extends \CWidget
{

    public $formTheme = 'main';

    /**
     *
     * @var string|null Вкладка, открытая по-умолчанию
     */
    public $default = 'article';

    /**
     *
     * @var string get'овый параметр, который будет добавлен при переключении между формами
     */
    public $formArgument = 'form';

    /**
     *
     * @var array Список типов контента
     */
    public $list = array(
        'article',
        'status',
        'video',
        'photopost',
    );

    public function run()
    {
        $this->render($this->formTheme);
    }

    public function getFormView()
    {
        $form = \Yii::app()->request->getParam($this->formArgument, $this->default);
        if (in_array($form, $this->list)) {
            return $form;
        }
        return $this->default;
    }

}
