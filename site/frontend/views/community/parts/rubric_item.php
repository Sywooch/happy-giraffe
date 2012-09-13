<li<?=($r->id == $this->rubric_id)?' class="active"':''?>>
    <?php if ($edit_on): ?>
        <?=CHtml::hiddenField('rubric-' . $r->id, $r->id, array('class' => 'rubric-id'))?>
        <?=CHtml::link('<i class="icon"></i>', '', array('class' => 'edit'))?>
    <?php endif; ?>
    <div class="in">
        <?php
            $params = array('rubric_id' => $r->id);
            if ($this->action->id == 'view') $params['content_type_slug'] = null;
        ?>
        <?=HHtml::link(CHtml::encode($r->title), $this->getUrl($params), array(), true)?>
        <span class="count"><?=$r->contentsCount?></span>
    </div>
</li>