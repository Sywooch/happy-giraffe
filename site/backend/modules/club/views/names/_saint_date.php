<div class="list">
    <?php
    $this->widget('DeleteWidget', array(
        'modelPk' => $model->id,
        'modelName' => get_class($model),
        'modelAccusativeName' => $model->accusativeName,
        'selector'=>'div.list'
    ));
    ?>
    <span><?php echo $model->day ?></span><?php echo HDate::ruMonthShort($model->month) ?>
</div>