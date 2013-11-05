<?php
/**
 * @var $data BlogContent
 */
$collection = new PhotoPostPhotoCollection(array('contentId' => $data->id));

?><div class="b-photopost">
    <h2 class="b-photopost_t"><?=CHtml::encode($data->gallery->title) ?></h2>
    <?php $this->widget('blog.widgets.PhotoPostWidget', array('post' => $data)); ?>
</div>