<?php $this->beginContent('//layouts/user'); ?>

<div class="user-cols clearfix">

    <div class="col-1">

        <?php if ($this->user->id == Yii::app()->user->id): ?>
            <div class="club-fast-add">
                <a href="<?=$this->createUrl('/blog/add')?>" class="btn btn-green"><span><span>Добавить запись</span></span></a>
            </div>
        <?php endif; ?>

        <div class="club-topics-all-link">
            <a href="<?=$this->createUrl('/blog/list', array('user_id' => $this->user->id))?>">Все записи</a> <span class="count"><?=$this->user->blogPostsCount?></span>
        </div>

        <div class="club-topics-list">
            <?php
                $items = array();
                foreach ($this->user->blog_rubrics as $r) {
                    $items[] = array(
                        'label' => $r->name . CHtml::tag('span', array('class' => 'count'), $r->contentsCount),
                        'url' => array('/blog/list', 'user_id' => $this->user->id, 'rubric_id' => $r->id),
                    );
                }

                $this->widget('zii.widgets.CMenu', array(
                        'items' => $items,
                        'encodeLabel' => false,
                    )
                );
            ?>
        </div>

    </div>

    <div class="col-23 clearfix">
        <?=$content?>
    </div>
</div>

<?php $this->endContent(); ?>