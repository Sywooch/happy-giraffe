<?php
/**
 * Created by PhpStorm.
 * User: Изыгин
 * Date: 13.10.2014
 * Time: 11:27
 */
$this->beginContent('//layouts/lite/common');
?>
<div class="layout-loose_hold clearfix">
    <div class="user-menu">
        <div class="user-menu_ava">
            <!-- ava--><a class="ava ava__middle ava__female" href="#"><span class="ico-status ico-status__online"></span><img class="ava_img" src="http://img.happy-giraffe.ru/thumbs/200x200/167771/ava9a3e33bd8a5a29146175425a5281390d.jpg" alt=""></a>
        </div>
        <ul class="user-menu_ul">
            <li class="user-menu_li"><a class="user-menu_i">
                    <div class="user-menu_ico user-menu_ico__profile"></div>
                    <div class="user-menu_tx">Анкета
                    </div></a></li>
            <li class="user-menu_li active"><a class="user-menu_i">
                    <div class="user-menu_ico user-menu_ico__family"></div>
                    <div class="user-menu_tx">Семья
                    </div></a></li>
            <li class="user-menu_li"><a class="user-menu_i">
                    <div class="user-menu_ico user-menu_ico__blog"></div>
                    <div class="user-menu_tx">Блог
                    </div></a></li>
            <li class="user-menu_li"><a class="user-menu_i">
                    <div class="user-menu_ico user-menu_ico__photo"></div>
                    <div class="user-menu_tx">Фото
                    </div></a></li>
            <li class="user-menu_li"><a class="user-menu_i">
                    <div class="user-menu_ico user-menu_ico__interest"></div>
                    <div class="user-menu_tx">Интересы
                    </div></a></li>
        </ul>
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
                <?= $content ?>
            </div>
        </div>
        <div class="layout-footer clearfix">
            <?php $this->renderPartial('//_footer'); ?>
        </div>
    </div>
</div>
<?php $this->endContent(); ?>