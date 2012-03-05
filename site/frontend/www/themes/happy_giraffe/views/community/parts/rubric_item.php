<li<?php echo ($r->id == $current_rubric)?' class="active"':'' ?>>
    <?php
    if (Yii::app()->authManager->checkAccess('editCommunityRubric', Yii::app()->user->getId(), array('community_id' => $r->community->id))) {
        echo CHtml::hiddenField('rubric-' . $r->id, $r->id, array('class' => 'rubric-id'));
        echo CHtml::link('<i class="icon"></i>', '', array('class' => 'edit'));
    }

    $params = array('community_id' => $r->community->id, 'rubric_id' => $r->id);
    if (!empty($content_type_slug))
        $params['content_type_slug'] = $content_type_slug;
    echo CHtml::link($r->name, CController::createUrl('community/list', $params));
    ?>
</li>