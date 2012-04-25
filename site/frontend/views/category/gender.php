<?php
$this->breadcrumbs=array(
	'Возраст и пол' => array('ages'),
	'Пол: '.$gender
);

	$pages = $products->pagination;
	$data = $products->data;
?>

<?php if(!Y::isAjaxRequest()): ?>

<div class="content-box clearfix">
	<div class="main">
		<div class="main-in">
			
			<div class="a-right fast-sort">
				Сортировать по:
<?php $this->widget('ext.RSortDropDownListWidget.RSortDropDownListWidget', array(
	'sort'=>$sort,
	'labels'=>array(
		'product_price'=>array(
			'asc'=>'По возврастанию цены',
			'deck'=>'По убыванию цены',
		),
		'product_time'=>array(
			'deck'=>'Дате поступления',
		),
		'product_rate'=>array(
			'desk'=>'Отзывам пользователей',
		),
	),
));?>
				
			</div>
			
			<h1>Пол: <?php echo $gender; ?></h1>

<?php endif; ?>
			
			
			<?php
			$this->renderPartial('_category', array(
				'pages'=>$pages,
				'data'=>$data,
			));
			?>
			
			
<?php if(!Y::isAjaxRequest()): ?>

		</div>
	</div>
	
	<div class="side-left">
		<div class="side-filter">
			<div class="filter-title">
				<big>Фильтр</big>
			</div>
			
			
<?php
$this->widget('FilterWidget', array(
	'category_id' => -2,
	'descendants' => $descendants,
));
?>
		</div>
	</div>

</div>

<!--<div class="b-banners">
	<ul>
		<li><a href=""><img src="/images/f-banner1.jpg"></a></li>
		<li><a href=""><img src="/images/f-banner1.jpg"></a></li>
		<li><a href=""><img src="/images/f-banner1.jpg"></a></li>
		<li><a href=""><img src="/images/f-banner1.jpg"></a></li>
		<li><a href=""><img src="/images/f-banner1.jpg"></a></li>
	</ul>
</div>-->

<?php endif; ?>