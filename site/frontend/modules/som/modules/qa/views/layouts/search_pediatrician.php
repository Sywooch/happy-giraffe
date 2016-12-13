<?php
/**
 * @var $this site\frontend\modules\som\modules\qa\controllers\DefaultController
 * @var string $content
 */
$this->beginContent('//layouts/lite/new_main');
$this->renderSidebarClip();
?>
 <div class="b-col__container">
	<?=$content?>
     <aside class="b-main__aside b-col b-col--3 b-hidden-md">
        <?php $this->renderPartial('/_sidebar/new_ask');?>
       	<?php $this->renderPartial('/_sidebar/new_menu');?>
        <?php $this->widget('site\frontend\modules\som\modules\qa\widgets\Statistic\CommonStatistic'); ?>
    </aside>
</div>
<?php $this->endContent(); ?>