<?php $this->beginContent('//layouts/main'); ?>
<?php Yii::app()->clientScript->registerCssFile('/stylesheets/baby.css'); ?>
			<div id="baby">
				<div class="content-box clearfix">
					<div class="main main-right">
						<div class="main-in">
                            <?php echo $content; ?>
						</div>
					</div>
					
					<div class="side-left">

						<div class="banner-box">
                            <a href="/contest/1/"><img src="/images/banner_03.png"></a>
						</div>
						
					</div>
					
				</div>
			</div>
<?php $this->endContent(); ?>