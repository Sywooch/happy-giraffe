<div class="user-blog">
    <div class="box-title">Блог <a href="<?=Yii::app()->createUrl('/blog/list', array('user_id' => $user->id)) ?>">Все записи (<?=$this->user->blogPostsCount?>)</a></div>
    <ul>
        <?php foreach ($this->user->blogWidget as $post): ?>
            <li>
                <a href="<?=$post->getUrl() ?>"><?=$post->title ?></a>
                <div class="date"><?php echo Yii::app()->dateFormatter->format("dd MMMM yyyy, HH:mm", $post->created); ?></div>
                <p><?=$post->short?></p>
            </li>
        <?php endforeach; ?>

    </ul>
</div>