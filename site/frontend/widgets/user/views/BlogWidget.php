<div class="user-blog">
    <div class="box-title">Блог <a href="<?=Yii::app()->createUrl('user/blog', array('user_id' => $user->id)) ?>">Все записи (<?=$this->count ?>)</a></div>
    <ul>
        <?php foreach ($this->articles as $post): ?>
            <li>
                <a href="<?=$post->getUrl() ?>"><?=$post->name ?></a>
                <div class="date"><?php echo Yii::app()->dateFormatter->format("dd MMMM yyyy, HH:mm", $post->created); ?></div>
                <p><?=Str::truncate($post->post->text, 140) ?></p>
            </li>
        <?php endforeach; ?>

    </ul>
</div>