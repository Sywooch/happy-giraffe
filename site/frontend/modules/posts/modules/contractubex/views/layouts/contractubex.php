<?php $this->beginContent('//layouts/lite/main'); ?>
<div class="b-main_cont">
    <div class="b-main_col-hold clearfix">
        <?php
        echo $content;
        ?>
        <aside class="b-main_col-sidebar visible-md">
            <a class="fancy-top" href="<?=$this->createUrl('/blog/default/form', array('type' => 1, 'club_id' => \site\frontend\modules\posts\modules\contractubex\components\ContractubexHelper::getForum()->id, 'useAMD' => true))?>">
                <div class="sidebar-promo-banner">
                    <div class="sidebar-promo-banner_h-first">Поделись</div>
                    <div class="sidebar-promo-banner_h-second">советом!</div>
                    <div class="sidebar-promo-banner_img"></div>
                    <div class="sidebar-promo-banner_text">И получи значок признания!</div><span class="sidebar-promo-banner_button">Поделись советом!</span>
                </div>
            </a>

            <?php $this->widget('site\frontend\modules\posts\modules\contractubex\widgets\sidebarWidget\SidebarWidget', array('exclude' => array($this->post->id))); ?>
        </aside>
    </div>

    <?php $this->renderPartial('/_promo_info'); ?>
</div>
<?php $this->endContent(); ?>