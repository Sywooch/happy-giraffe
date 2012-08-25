<?php
/* @var $this HController
 * @var CommunityContent[] $posts
 */
?>
1. Posts to comment
<br>
<?php foreach ($posts as $post): ?>
<div>
    <?=CHtml::link($post->title, $post->url, array('target'=>'_blank')) ?>
</div>
<?php endforeach; ?>