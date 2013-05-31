<?php
$this->breadcrumbs=array(
	'Бренды',
);
?>

<h1>Бренды</h1>

<div class="items">
	<?php foreach($brands as $brand): ?>
	<div class="item" style="padding-top: 10px;">
			<?php echo CHtml::image(UFiles::getFileInstance($brand->brand_image)->getUrl(), $brand->brand_title, array(
				'align'=>'left',
				'style'=>'padding:5px',
			)); ?>
			<h3>
				<?php echo CHtml::link($brand->brand_title, array('brand', 'id'=>$brand->brand_id)); ?>
			</h3>
			<p><?php echo $brand->brand_text; ?></p>
		</div>
		<div class="clear"></div>
	<?php endforeach; ?>
</div>
