<?php
	$cs = Yii::app()->clientScript;
	$cs->registerCssFile('/stylesheets/profile.css');
?>
<?php $this->beginContent('//layouts/user'); ?>
<div class="user-cols clearfix">
    <div class="col-1">
        <div class="side-nav">
            <?php
                $this->widget('zii.widgets.CMenu', array(
                'items' => array(
                    array('label' => 'Личная информация', 'url' => array('/profile/index'), 'active' => $this->action->id == 'index'),
                    //array('label' => 'Ваша фотография', 'url' => array('/profile/photo'), 'active' => $this->action->id == 'photo'),
                    //array('label' => 'Моя семья', 'url' => array('/profile/family'), 'active' => $this->action->id == 'family'),
                    //array('label' => 'Доступ', 'url' => array('/profile/access'), 'active' => $this->action->id == 'access'),
                    //array('label' => 'Черный список', 'url' => array('/profile/blacklist'), 'active' => $this->action->id == 'blacklist'),
                    //array('label' => 'Подписка', 'url' => array('/profile/subscription'), 'active' => $this->action->id == 'subscription'),
                    array('label' => 'Социальные сети', 'url' => array('/profile/socials'), 'active' => $this->action->id == 'socials'),
                    array('label' => 'Изменить пароль', 'url' => array('/profile/password'), 'active' => $this->action->id == 'password'),
                )));
            ?>
        </div>
    </div>
    <div class="col-23 clearfix">
        <div class="content-title">Мои настройки</div>
        <div id="profile" class="clearfix">
            <?php echo $content; ?>
        </div>
    </div>
</div>
<?php $this->endContent(); ?>