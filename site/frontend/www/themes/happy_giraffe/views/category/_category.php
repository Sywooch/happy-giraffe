<div id="categoryContent">

	<?php if($pages->pageCount > 1): ?>
		<div class="pagination pagination-center clearfix">
			<span class="text">
				Показано: <?php echo $pages->currentPage * $pages->pageSize + 1; ?>-<?php echo ($pages->currentPage + 1) * $pages->pageSize; ?> из <?php echo $pages->itemCount; ?>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				Страницы:
			</span>
			<?php
			$this->widget('LinkPager', array(
				'pages' => $pages,
				'id' => 'top_pages',
			));
			?>
		</div>
<?php endif; ?>

	<div class="product-list">
		<ul>
			<?php foreach($data as $sp): ?>
				<?php
				$this->renderPartial('_product', array(
					'sp' => $sp,
				))
				?>
<?php endforeach; ?>
		</ul>
	</div>

<?php if($pages->pageCount > 1): ?>
		<div class="pagination pagination-center clearfix">
			<span class="text">
				Показано: <?php echo $pages->currentPage * $pages->pageSize + 1; ?>-<?php echo ($pages->currentPage + 1) * $pages->pageSize; ?> из <?php echo $pages->itemCount; ?>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				Страницы:
			</span>
			<?php
			$this->widget('LinkPager', array(
				'pages' => $pages,
				'id' => 'top_pages',
			));
			?>
		</div>
<?php endif; ?>

</div>