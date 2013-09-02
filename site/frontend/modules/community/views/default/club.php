<div class="col-1">
    <?php $this->renderPartial('_users'); ?>
    <?php if (count($this->club->communities) == 1)
        $this->renderPartial('_rubrics', array('rubrics' => $this->club->communities[0]->rubrics)); ?>
</div>
<div class="col-23-middle ">
    <?php $this->renderPartial('list'); ?>
</div>
