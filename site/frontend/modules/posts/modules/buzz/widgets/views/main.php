<?php
/**
 * @var site\frontend\modules\posts\modules\buzz\widgets\SidebarWidget $this
 * @var site\frontend\modules\posts\models\Content[] $posts
 */
?>

<?php foreach ($posts as $post): ?>
<p><?=$post->title?></p>
<?=$this->getHtml($post)?>
<?php endforeach; ?>