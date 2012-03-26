<?php $this->beginContent('//layouts/user'); ?>

<div class="user-cols clearfix">

    <div class="col-1">

        <div class="club-topics-all-link">
            <a href="">Все записи</a> <span class="count">458</span>
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