<div class="<?=$decorationCssClass?>">
    <div class="<?=$titleCssClass?>">
        <?=$title?>
        <?php echo CHtml::link('e', array('settings', 'box_id' => $_id)); ?>
        <?php echo CHtml::link('d', array('delete', 'box_id' => $_id), array('class' => 'delete')); ?>
    </div>
</div>