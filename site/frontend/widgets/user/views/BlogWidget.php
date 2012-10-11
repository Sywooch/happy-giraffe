<div class="user-blog">
    <div class="box-title">
        <?php if ($this->isMyProfile): ?><a class="btn btn-orange-smallest a-right" href="<?php echo Yii::app()->controller->createUrl('blog/add'); ?>"><span><span>Добавить запись</span></span></a><?php endif; ?>
        Блог <?php if ($this->count > 4): ?><a href="<?=Yii::app()->createUrl('/blog/list', array('user_id' => $user->id)) ?>">Все записи (<?=$this->count?>)</a><?php endif; ?>
    </div>
    <ul>
        <?php foreach ($this->user->blogWidget as $post): ?>
            <li>
                <a href="<?=$post->getUrl() ?>"><?=$post->title ?></a>
                <div class="date"><?php echo Yii::app()->dateFormatter->format("dd MMMM yyyy, HH:mm", $post->created); ?></div>
                <p><?=$post->getShort(140)?></p>
                <div class="meta">
                    <span class="views"><i class="icon"></i><?=PageView::model()->viewsByPath($post->url)?></span>
                    <?=CHtml::link('<i class="icon"></i>' . $post->commentsCount, $post->getUrl(true), array('class' => 'comments'))?>
                </div>
            </li>
        <?php endforeach; ?>

    </ul>
</div>