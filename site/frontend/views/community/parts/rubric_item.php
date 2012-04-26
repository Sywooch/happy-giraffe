<li<?=($r->id == $this->rubric_id)?' class="active"':''?>>
    <?php if ($edit_on): ?>
        <?=CHtml::hiddenField('rubric-' . $r->id, $r->id, array('class' => 'rubric-id'))?>
        <?=CHtml::link('<i class="icon"></i>', '', array('class' => 'edit'))?>
    <?php endif; ?>
    <div class="in">
        <?=CHtml::link($r->title, $this->getUrl(array('rubric_id' => $r->id)))?>
        <span class="count"><?=$r->contentsCount?></span>
    </div>
</li>