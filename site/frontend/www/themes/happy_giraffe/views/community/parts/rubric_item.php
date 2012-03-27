<li<?php echo ($r->id == $this->rubric_id)?' class="active"':'' ?>>
    <?php
        if (Yii::app()->authManager->checkAccess('editCommunityRubric', Yii::app()->user->id, array('community_id' => $r->community->id))) {
            echo CHtml::hiddenField('rubric-' . $r->id, $r->id, array('class' => 'rubric-id'));
            echo CHtml::link('<i class="icon"></i>', '', array('class' => 'edit'));
        }

        echo CHtml::link($r->name, $this->getUrl(array('rubric_id' => $r->id)));
    ?>
</li>