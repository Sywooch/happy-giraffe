<p>
    Нарушитель: <?php echo $breaker->fullName ?>,
    зарегистрирован <?php echo $breaker->register_date; ?>
</p>
    <?php if($breaker->blocked == 0): ?>
        <p><?php echo CHtml::link('Заблокировать', array('reports/blockUser', 'id' => $breaker->id)); ?></p>
    <?php elseif($breaker->blocked == 1): ?>
        <p>Пользователь заблокирован</p>
    <?php  endif;?>
    <?php
    $this->widget('zii.widgets.grid.CGridView', array(
        'dataProvider'=>$model->search(),
        'columns' => array(
            'id',
            array(
                'name' => 'author.fullName',
                'header' => 'Пожаловался',
                'type' => 'html',
                'value' => '$data->author ? $data->author->fullName : "Гость"',
            ),
            array(
                'name' => 'path',
                'type' => 'raw',
                'value' => 'CHtml::link($data->path, Yii::app()->params["frontend_url"] . $data->path)'
            ),
            array(
                'header' => 'Текст нарушения',
                'type' => 'html',
                'value' => '$data->model->text',
            ),
            array(
                'name' => 'text',
                'type' => 'raw',
                'value' => 'Str::truncate(trim(strip_tags($data->text)), 100, "...");'
            ),
            'created',
        )
    ));
    ?>
