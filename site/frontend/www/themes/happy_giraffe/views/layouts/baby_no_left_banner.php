<?php $this->beginContent('//layouts/main'); ?>
<?php Yii::app()->clientScript->registerCssFile('/stylesheets/baby.css'); ?>
			<div id="baby">
				<div class="content-box clearfix">

                    <?php echo $content; ?>

				</div>
			</div>
<?php $this->endContent(); ?>