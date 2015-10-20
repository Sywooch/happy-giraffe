<?php
/**
 * @var site\frontend\modules\posts\modules\buzz\widgets\SidebarWidget $this
 * @var site\frontend\modules\posts\models\Content[] $posts
 */
?>

<?php foreach ($posts as $post): ?>
    <div class="article-anonce article-anonce__s">
        <a href="<?=$post->url?>" class="article-anonce_hold">
            <?=$this->getHtml($post)?>
            <div class="article-anonce_bottom">
                <div class="article-anonce_t"><?=$post->title?></div>
            </div>
        </a>
    </div>
<?php endforeach; ?>