<li<?php echo ($r->id == $this->rubric_id)?' class="active"':'' ?>>
    <?php
    if (
        ($type == 'community' && Yii::app()->authManager->checkAccess('editCommunityRubric', Yii::app()->user->id, array('community_id' => $this->community->id)))
        ||
        ($type == 'blog' && $this->user->id == Yii::app()->user->id)
    ) {
            echo CHtml::hiddenField('rubric-' . $r->id, $r->id, array('class' => 'rubric-id'));
            echo CHtml::link('<i class="icon"></i>', '', array('class' => 'edit'));
        }

        echo CHtml::link($r->name . CHtml::tag('span', array('class' => 'count'), $r->contentsCount), $this->getUrl(array('rubric_id' => $r->id)));
    ?>
</li>