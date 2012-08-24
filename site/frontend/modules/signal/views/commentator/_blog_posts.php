<?php
/* @var $this HController
 * @var CommunityContent[] $blog_posts
 */
?>

1. Record in blog
<br>
<?php foreach ($blog_posts as $post): ?>
<div>
    <?=CHtml::link($post->title, $post->url, array('target'=>'_blank')) ?>
</div>
<?php endforeach; ?>