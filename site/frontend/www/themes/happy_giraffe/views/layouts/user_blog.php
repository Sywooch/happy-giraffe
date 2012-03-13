<?php $this->beginContent('//layouts/user'); ?>

    <div class="user-cols clearfix">

        <div class="col-1">

            <?php echo CHtml::link('Добавить', array('user/blog/add')); ?>

            <div class="club-topics-all-link">
                <?php echo CHtml::link('Все записи', array('user/blog', 'user_id' => $this->user->id)); ?>
            </div>

            <div class="club-topics-list">

                <ul>
                    <?php
                        $items = array();
                        foreach ($this->user->blog_rubrics as $r) {
                            $items[] = array(
                                'label' => $r->name,
                                'url' => $this->getUrl(array('rubric_id' => $r->id)),
                                'active' => $r->id == $this->rubric_id,
                            );
                        }

                        $this->widget('zii.widgets.CMenu', array(
                                'items' => $items,
                            )
                        );
                    ?>
                </ul>
            </div>

        </div>

        <div class="col-23 clearfix">

            <?php echo $content; ?>

        </div>

    </div>

<?php $this->endContent(); ?>