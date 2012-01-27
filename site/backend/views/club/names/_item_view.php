<div class="name_actions">
    <p class="title"><?php echo $model->value ?></p>
    <?php
    $this->widget('EditDeleteWidget', array(
        'model' => $model,
        'attribute' => 'value',
        'options'=> array(
            'edit_selector'=>'p.title',
            'ondelete'=>'$(this).parent().remove();'
        )
    ));?>
    <p>,</p>
</div>