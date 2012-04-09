<div id="categoryContent">

	<?php if($pages->pageCount > 1): ?>
		<div class="pagination pagination-center clearfix">
			<?php
			$this->widget('AlbumLinkPager', array(
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
			<?php
			$this->widget('AlbumLinkPager', array(
				'pages' => $pages,
				'id' => 'top_pages',
			));
			?>
		</div>
<?php endif; ?>

</div>