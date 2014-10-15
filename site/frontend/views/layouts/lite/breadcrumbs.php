<?php
/**
 * Created by PhpStorm.
 * User: Изыгин
 * Date: 13.10.2014
 * Time: 11:27
 */
$this->beginContent('//layouts/new/mainNew'); ?>
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
<?php $this->endContent(); ?>