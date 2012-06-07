<?php $this->beginContent('//layouts/main');

if (Yii::app()->user->checkAccess('admin'))
    /*$this->widget('zii.widgets.CMenu', array(
        'items' => array(
            array(
                'label' => 'Таблица',
                'url' => array('/competitors/default/'),
            ),
            array(
                'label' => 'Сайты',
                'url' => array('/competitors/site/'),
            ),
            array(
                'label' => 'Парсинг',
                'url' => array('/competitors/parse/'),
            ),
        )));*/

echo $content;

$this->endContent();