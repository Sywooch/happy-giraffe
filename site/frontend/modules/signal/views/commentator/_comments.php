<?php
/* @var $this HController
 * @var Comment[] $comments
 */
?>

1. 100 комментариев <?php if (count($comments) < 100):?>(еще <?= 100 - count($comments)?>)<?php endif ?>
<br>
<?php foreach ($comments as $comment): ?>
<div>
    <?=$comment->getLink(); ?>
</div>
<?php endforeach; ?>