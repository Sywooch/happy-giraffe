<?php

$this->beginContent('//layouts/lite/main');
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

echo $content;

$this->endContent();
