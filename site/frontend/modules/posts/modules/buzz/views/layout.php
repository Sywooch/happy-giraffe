<?php
/**
 * @var site\frontend\modules\posts\modules\buzz\controllers\DefaultController $this
 * @var string $content
 */
$this->beginContent('//layouts/lite/main');
?>
  	<div class="homepage__title_comment-wrapper">
    	<div class="homepage__title_buzz">Жизнь</div>
  	</div>

    <div class="b-main_cont b-main_cont-xs">
        <div class="b-main_col-hold clearfix">
            <?php
            echo $content;
            ?>
            <aside class="b-main_col-sidebar visible-md">
                <?php if ($this->beginCache('site\frontend\modules\posts\modules\buzz\widgets\SidebarWidget', array('duration' => 300))) { $this->widget('site\frontend\modules\posts\modules\buzz\widgets\SidebarWidget'); $this->endCache(); } ?>
            </aside>
        </div>
    </div>
<?php $this->endContent(); ?>