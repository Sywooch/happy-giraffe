<?php
/**
 * Created by PhpStorm.
 * User: Изыгин
 * Date: 13.10.2014
 * Time: 11:27
 */
$this->beginContent('//layouts/lite/common');
?>
<?php if (Yii::app()->user->isGuest): ?>
    <?=$content?>
<?php else: ?>
    <div class="layout-loose_hold clearfix">
        <div class="user-menu">
            <div class="user-menu_ava">
                <?php $this->widget('Avatar', array(
                    'user' => Yii::app()->user->model,
                    'size' => Avatar::SIZE_SMALL,
                )); ?>
            </div>
            <?php
            $this->widget('zii.widgets.CMenu', array(
                'encodeLabel' => false,
                'htmlOptions' => array(
                    'class' => 'user-menu_ul',
                ),
                'itemCssClass' => 'user-menu_li',
                'items' => array(
                    array(
                        'label' => '<div class="user-menu_ico user-menu_ico__profile"></div><div class="user-menu_tx">Анкета</div>',
                        'url' => array('/profile/default/index', 'user_id' => Yii::app()->user->id),
                        'linkOptions' => array('class' => 'user-menu_i'),
                    ),
                    array(
                        'label' => '<div class="user-menu_ico user-menu_ico__family"></div><div class="user-menu_tx">Семья</div>',
                        'url' => array('/family/default/index', 'userId' => Yii::app()->user->id),
                        'linkOptions' => array('class' => 'user-menu_i'),
                    ),
                    array(
                        'label' => '<div class="user-menu_ico user-menu_ico__photo"></div><div class="user-menu_tx">Фото</div>',
                        'url' => array('/photo/default/index', 'userId' => Yii::app()->user->id),
                        'linkOptions' => array('class' => 'user-menu_i'),
                    ),
                ),
            ));
            ?>
        </div>
        <div class="page-col page-col__user">
            <div class="page-col_cont page-col_cont__in b-main">
                <div class="b-main_col-hold clearfix">
                    <?php
                    $this->widget('zii.widgets.CBreadcrumbs', array(
                        'tagName' => 'ul',
                        'separator' => ' ',
                        'htmlOptions' => array('class' => 'b-crumbs_ul'),
                        'homeLink' => '<li class="b-crumbs_li"><a href="' . $this->createUrl('/site/index') . '" class="b-crumbs_a">Главная </a></li>',
                        'activeLinkTemplate' => '<li class="b-crumbs_li"><a href="{url}" class="b-crumbs_a">{label}</a></li>',
                        'inactiveLinkTemplate' => '<li class="b-crumbs_li b-crumbs_li__last"><span class="b-crumbs_last">{label}</span></li>',
                        'links' => $this->breadcrumbs,
                        'encodeLabel' => false,
                    ));
                    ?>
                    <?=$content?>
                </div>
            </div>
            <div class="layout-footer clearfix">
                <?php $this->renderPartial('//_footer'); ?>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php $this->endContent(); ?>