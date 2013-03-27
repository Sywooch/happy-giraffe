<?php
/**
 * $var $section string раздел отчетности
 */
?>
<div class="nav-hor clearfix">
    <?php $this->widget('zii.widgets.CMenu', array(
        'encodeLabel' => false,
        'htmlOptions' => array('class' => 'nav-hor_ul'),
        'itemCssClass'=>'nav-hor_li',
        'items' => array(
            array(
                'label' => '<span class="nav-hor_tx">Новые <br> друзья</span>',
                'url' => $this->createUrl('commentator/reports', array('section' => 'friends')),
                'linkOptions' => array('class' => 'nav-hor_i'),
                'active' => (Yii::app()->controller->action->id == 'reports' && $section == 'friends')
            ),
            array(
                'label' => '<span class="nav-hor_tx">Посетителей <br> анкеты</span>',
                'url' => $this->createUrl('commentator/reports', array('section' => 'visitors')),
                'linkOptions' => array('class' => 'nav-hor_i'),
                'active' => (Yii::app()->controller->action->id == 'reports' && $section == 'visitors')
            ),
            array(
                'label' => '<span class="nav-hor_tx">Заходов из <br> поискоков</span>',
                'url' => $this->createUrl('commentator/reports', array('section' => 'traffic')),
                'linkOptions' => array('class' => 'nav-hor_i'),
                'active' => (Yii::app()->controller->action->id == 'reports' && $section == 'traffic')
            ),
            array(
                'label' => '<span class="nav-hor_tx">Личные <br> сообщения</span>',
                'url' => $this->createUrl('commentator/reports', array('section' => 'messages')),
                'linkOptions' => array('class' => 'nav-hor_i'),
                'active' => (Yii::app()->controller->action->id == 'reports' && $section == 'messages')
            ),
            array(
                'label' => '<span class="nav-hor_tx">Выполнение <br> плана</span>',
                'url' => $this->createUrl('commentator/reports', array('section' => 'plan')),
                'linkOptions' => array('class' => 'nav-hor_i'),
                'active' => (Yii::app()->controller->action->id == 'reports' && $section == 'plan')
            ),
        ),
    ));
    ?>
</div>