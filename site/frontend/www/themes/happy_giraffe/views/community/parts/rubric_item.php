<li<?=($r->id == $this->rubric_id)?' class="active"':''?>>
    <?php if (
        ($type == 'community' && Yii::app()->authManager->checkAccess('editCommunityRubric', Yii::app()->user->id, array('community_id' => $this->community->id)))
        ||
        ($type == 'blog' && $this->user->id == Yii::app()->user->id)
    ): ?>
        <?=CHtml::hiddenField('rubric-' . $r->id, $r->id, array('class' => 'rubric-id'))?>
        <?=CHtml::link('<i class="icon"></i>', '', array('class' => 'edit'))?>
    <?php endif; ?>
    <div class="in">
        <?=CHtml::link($r->name, $this->getUrl(array('rubric_id' => $r->id)))?>
        <span class="count"><?=$r->contentsCount?></span>
    </div>
</li>