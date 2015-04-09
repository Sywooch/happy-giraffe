<?php
/**
 * @var LiteController $this
 */
$this->beginContent('//layouts/lite/common');
?>

<div class="layout-loose_hold clearfix">
    <div class="b-main">
        <div class="b-main_cont b-main_cont__wide">
            <div class="postAdd b-main_col-hold clearfix"><a href="<?=Yii::app()->request->urlReferrer?>" class="ico-close6">×</a>
                <?=$content?>
                <!-- /основная колонка -->
                <!-- сайдбар-->
                <div class="b-main_col-sidebar"></div>
                <!-- /сайдбар-->
            </div>
        </div>
    </div>
</div>

<?php $this->endContent(); ?>