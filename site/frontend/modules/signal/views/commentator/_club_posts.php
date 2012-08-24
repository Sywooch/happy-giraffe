<?php
/* @var $this HController
 * @var CommunityContent[] $club_posts
 */
?>

1. Record in club
<br>
<?php foreach ($club_posts as $post): ?>
<div>
    <?=CHtml::link($post->title, $post->url, array('target'=>'_blank')) ?>
</div>
<?php endforeach; ?>