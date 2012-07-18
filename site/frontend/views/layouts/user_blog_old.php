<?php $this->beginContent('//layouts/user'); ?>

<div class="user-cols clearfix">

    <div class="col-1">

        <?php if ($this->user->id == Yii::app()->user->id): ?>
            <div class="club-fast-add">
                <a href="<?=$this->getUrl(array('content_type_slug' => null), 'blog/add')?>" class="btn btn-green" rel="nofollow"><span><span>Добавить запись</span></span></a>
            </div>
        <?php endif; ?>

        <div class="club-topics-all-link">
            <a href="<?=$this->getUrl(array('rubric_id' => null))?>">Все записи</a> <span class="count"><?=$this->user->blogPostsCount?></span>
        </div>

        <div class="club-topics-list">
            <?php
                $this->renderPartial('/community/parts/rubrics',array(
                    'rubrics' => $this->user->blog_rubrics,
                    'type' => 'blog',
                ));
            ?>
        </div>

    </div>

    <div class="col-23 clearfix">
        <?=$content?>
    </div>
</div>

<?php $this->endContent(); ?>