<?php $this->beginContent('//layouts/lite/main'); ?>
<div class="b-main_cont">
    <div class="b-main_col-hold clearfix">
        <?php
        echo $content;
        ?>
        <aside class="b-main_col-sidebar visible-md">
            <?php $this->widget('site\frontend\modules\posts\modules\contractubex\widgets\sidebarWidget\SidebarWidget', array('exclude' => array($this->post->id))); ?>
        </aside>
    </div>

    <?php $this->renderPartial('/_promo_info'); ?>
</div>
<?php $this->endContent(); ?>