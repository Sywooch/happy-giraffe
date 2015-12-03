<?php
/**
 * @var $this site\frontend\modules\som\modules\qa\controllers\MyController
 * @var string $content
 */
$this->beginContent('//layouts/lite/common');
$this->renderSidebarClip();
?>

    <div class="layout-loose_hold clearfix">
        <div class="b-main">
            <div class="b-main">
                <div id="my-widget">
                    <div class="popup-widget">
                        <div class="popup-widget_heading">
                            <div class="popup-widget_heading_icon"></div>
                            <?php $this->widget('site\frontend\modules\som\modules\qa\widgets\my\MyPersonalWidget', array('userId' => Yii::app()->user->id)); ?>
                            <div class="popup-widget_heading_close-btn"></div>
                        </div>
                        <div class="popup-widget_wrap">
                            <div class="popup-widget_cont">
                                <?=$content?>
                            </div>
                            <div class="popup-widget_sidebar">
                                <?=$this->clips['sidebar']?>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- # Личный кабинет-->
        </div>

        <?php $this->renderPartial('//_footer'); ?>

    </div>

<?php $this->endContent(); ?>