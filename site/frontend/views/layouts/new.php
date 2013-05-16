<?php $this->beginContent('//layouts/main'); ?>
<?php Yii::app()->clientScript->registerCssFile('/stylesheets/baby.css?r=349'); ?>
			<div id="baby">
				<div class="content-box clearfix">
					<div class="main main-right">
						<div class="main-in">
                            <?php echo $content; ?>
						</div>
					</div>
					
					<div class="side-left">

						<div class="banner-box">
                            <?php $this->renderPartial('//banners/adfox'); ?>
						</div>
						
					</div>
					
				</div>
			</div>
<?php $this->endContent(); ?>