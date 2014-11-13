<?php
$this->beginContent('//layouts/lite/main');
if (!Yii::app()->user->isGuest && $this->user->id == Yii::app()->user->id) {
    ?>
    <!-- userAddRecord-->
    <div class="userAddRecord clearfix  userAddRecord__blog">
        <div class="userAddRecord_hold">
            <div class="userAddRecord_tx"> Я хочу добавить</div>
            <a href="<?= Yii::app()->createUrl('/blog/tmp/index', array('type' => 1)); ?>" data-theme="transparent" title="Статью" class="userAddRecord_ico userAddRecord_ico__article"></a>
            <a href="<?= Yii::app()->createUrl('/blog/tmp/index', array('type' => 3)); ?>" data-theme="transparent" title="Фото" class="userAddRecord_ico userAddRecord_ico__photo"></a>
            <a href="<?= Yii::app()->createUrl('/blog/tmp/index', array('type' => 2)); ?>" data-theme="transparent" title="Видео" class="userAddRecord_ico userAddRecord_ico__video"></a>
            <a href="<?= Yii::app()->createUrl('/blog/tmp/index', array('type' => 5)); ?>" data-theme="transparent" title="Статус" class="userAddRecord_ico userAddRecord_ico__status"></a>
        </div>
    </div>
    <!-- /userAddRecord-->
    <?php
}
else {
    ?>
    <section class="userSection visible-md-block">
        <div class="userSection_hold">
            <a href="<?= $this->user->profileUrl ?>" class="ava ava__<?= $this->user->gender ? 'male' : 'female' ?> ava__small-xxs ava__middle-xs ava__middle-sm-mid"><?= CHtml::image($this->user->avatarUrl, $this->user->fullName, array('class' => 'ava_img')) ?></a>
            <h2 class="userSection_name"><?= $this->user->fullName ?></h2>
        </div>
        <div class="userSection_panel">
            <?php
            $this->widget('zii.widgets.CMenu', array(
                'htmlOptions' => array(
                    'class' => 'userSection_panel-ul',
                ),
                'itemCssClass' => 'userSection_panel-li',
                'items' => array(
                    array(
                        'label' => 'Анкета',
                        'url' => array('/profile/default/index', 'user_id' => $this->user->id),
                        'linkOptions' => array('class' => 'userSection_panel-a'),
                    ),
                    array(
                        'label' => 'Семья',
                        'url' => array('/family/default/index', 'userId' => $this->user->id),
                        'linkOptions' => array('class' => 'userSection_panel-a'),
                    ),
                    array(
                        'label' => 'Блог',
                        'url' => array('/blog/default/index', 'user_id' => $this->user->id),
                        'linkOptions' => array('class' => 'userSection_panel-a'),
                        'active' => Yii::app()->controller->module !== null && in_array(Yii::app()->controller->module->id, array('posts', 'blog')),
                    ),
                    array(
                        'label' => 'Фото',
                        'url' => array('/photo/default/index', 'userId' => $this->user->id),
                        'linkOptions' => array('class' => 'userSection_panel-a'),
                    ),
                ),
            ));
            ?>
        </div>
    </section>
    <?php
}
echo $content;

$this->endContent();
