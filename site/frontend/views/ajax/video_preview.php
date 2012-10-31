<?php echo CHtml::hiddenField('player_favicon', $favicon); ?>
<?php echo CHtml::hiddenField('player_title', $video->title); ?>
<?php echo CHtml::image($video->image, $video->title); ?>