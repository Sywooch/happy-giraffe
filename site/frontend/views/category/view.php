<?php Yii::app()->clientScript->registerCssFile('/stylesheets/cusel.css'); ?>
<?php Yii::app()->clientScript->registerScriptFile('/javascripts/cusel.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile('/javascripts/checkbox.js'); ?>

<?php
$this->breadcrumbs = array(
	'Категории' => array('index'),
	$model->category_name
);

$pages = $products->pagination;
$data = $products->data;
?>

<?php if (!Y::isAjaxRequest()): ?>

	<div class="content-box clearfix">
		<div class="main">
			<div class="main-in">

				<div class="a-right fast-sort">
					Сортировать по:
					<?php
					$this->widget('ext.RSortDropDownListWidget.RSortDropDownListWidget', array(
						'sort' => $sort,
						'labels' => array(
							'product_price' => array(
								'asc' => 'По возврастанию цены',
								'deck' => 'По убыванию цены',
							),
							'product_time' => array(
								'deck' => 'Дате поступления',
							),
							'product_rate' => array(
								'desk' => 'Отзывам пользователей',
							),
						),
					));
					?>

				</div>

				<h1><?php echo $model->category_name; ?></h1>

			<?php endif; ?>

			<?php
			$this->renderPartial('_category', array(
				'pages' => $pages,
				'data' => $data,
			));
			?>
		<?php if (!Y::isAjaxRequest()): ?>
				</div>
			</div>
			<div class="side-left">
				<div class="side-filter">
					<div class="filter-title">
						<big>Фильтр</big>
					</div>
					<?php
					$this->widget('FilterWidget', array(
						'category_id' => $model->category_id,
						'descendants' => $descendants,
					));
					?>
				</div>
			</div>

		</div>

<!--			<ul>-->
<!--				<li><a href=""><img src="/images/f-banner1.jpg"></a></li>
				<li><a href=""><img src="/images/f-banner1.jpg"></a></li>
				<li><a href=""><img src="/images/f-banner1.jpg"></a></li>
				<li><a href=""><img src="/images/f-banner1.jpg"></a></li>
				<li><a href=""><img src="/images/f-banner1.jpg"></a></li>-->
<!--			</ul>-->


	<?php endif; ?>