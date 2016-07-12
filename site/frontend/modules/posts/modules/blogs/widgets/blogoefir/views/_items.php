<?php foreach ($rows as $row): ?>
        		
<li class="b-widget-content__item">
	<div class="b-widget-content__ava">
		<img src="<?php echo $row->user->avatarUrl; ?>" alt="">
	</div>
	
	<?php
	
	echo CHtml::link($row->user->fullName, $row->user->profileUrl, [
	    'class' => 'b-widget-content__username'
	]);
	
	?>
	
	<div class="b-widget-content__date">
		<?php echo HHtml::timeTag($row, ['class' => '']); ?>
	</div>
	
	<div class="b-widget-content__title">
		<?php 
		
		echo CHtml::link($row->title, $row->parsedUrl, [
		    'class' => 'b-widget-content__link'
		]);
		
		?>
	</div>
</li>

<?php endforeach; ?>