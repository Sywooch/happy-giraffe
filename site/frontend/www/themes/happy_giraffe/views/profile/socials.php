<?php $this->breadcrumbs = array(
	'Профиль' => array('/profile'),
	'<b>Социальные сети</b>',
); ?>

<div class="row row-social">
    Быстрый вход:
    &nbsp;
    <?php Yii::app()->eauth->renderWidget(array('mode' => 'profile', 'action' => 'site/login')); ?>
</div>