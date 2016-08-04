<?php
/**
 * @var site\frontend\modules\comments\modules\contest\controllers\DefaultController $this
 * @var string $content
 */
?>
<?php $this->beginContent('//layouts/lite/common_menu'); ?>
<div class="layout-loose_hold clearfix">
<div class="contest">
<div class="contest-header contest-header_blue textalign-c">
    <div class="b-contest-container">
        <div class="contest-header__box">
            <div class="contest-header__descr visible-md"> КОНКУРС ПРОВОДИТСЯ ЕЖЕМЕСЯЧНО</div>
            <div class="contest-header__title"> <?= $this->contest->name; ?></div>
            <div class="textalign-c padding-t20"><a href="#" class="btn btn-ml btn-yellow hidden-lg">Принять участие</a></div>
        </div>
        <div class="contest-header__footer visible-md">
<!--                <li class="contest-header__li"><a class="contest-header__link contest-header__link-active">Главная</a></li>-->
<!--                <li class="contest-header__li"><a class="contest-header__link">Пульс</a></li>-->
<!--                <li class="contest-header__li"><a class="contest-header__link">Мои баллы</a></li>-->
<!--                <li class="contest-header__li"><a class="contest-header__link">Задания</a></li>-->
<!--                <li class="contest-header__li"><a class="contest-header__link">Победители</a></li>-->
<!--                <li class="contest-header__li"><a class="contest-header__link">Правила</a></li>-->
                    <?php
                        $this->widget('zii.widgets.CMenu', array(
                            'items' => array(
                                array(
                                    'label' => 'Главная',
                                    'url' => array('/comments/contest/default/index'),
                                    'linkOptions' => array('class' => 'contest-header__link'),
                                ),
                                array(
                                    'label' => 'Пульс',
                                    'url' => array('/comments/contest/default/pulse'),
                                    'linkOptions' => array('class' => 'contest-header__link'),
                                ),
                                array(
                                    'label' => 'Мои баллы',
                                    'url' => array('/comments/contest/default/my'),
                                    'linkOptions' => array('class' => 'contest-header__link'),
                                    'visible' => !\Yii::app()->user->isGuest,
                                ),
                                array(
                                    'label' => 'Задания',
                                    'url' => array('/comments/contest/default/quests'),
                                    'linkOptions' => array('class' => 'contest-header__link'),
                                    'visible' => !\Yii::app()->user->isGuest,
                                ),
                                array(
                                    'label' => 'Победители',
                                    'url' => array('/comments/contest/default/winners'),
                                    'linkOptions' => array('class' => 'contest-header__link'),
                                ),
                                array(
                                    'label' => 'Правила',
                                    'url' => array('/comments/contest/default/rules'),
                                    'linkOptions' => array('class' => 'contest-header__link'),
                                ),
                            ),
                            'encodeLabel' => false,
                            'itemCssClass' => 'contest-header__li',
                            //добавлятся к li, нужно к a. Лучший вариант перепилить класс, чтобы он работал на li.
                            'activeCssClass' => 'contest-header__link-active',
                            'htmlOptions' => array(
                                'class' => 'textalign-c',
                            ),
                            'activateItems' => true,
                        ));
                    ?>
        </div>
    </div>
</div>
<?=$content?>
<?php $this->endContent(); ?>
</div>
