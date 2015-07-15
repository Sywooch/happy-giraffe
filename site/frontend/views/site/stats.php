<?php
$this->metaNoindex = true;
$this->widget('zii.widgets.grid.CGridView', array(
    'dataProvider'=>$dp,
    'columns' => array(
        array(
            'header' => 'Дата',
            'name' => 'id',
            'value' => '$data["id"]',
        ),
        array(
            'header' => 'Комментариев',
            'name' => 'comments',
            'value' => '$data["comments"]',
        ),
        array(
            'header' => 'Постов',
            'name' => 'posts',
            'value' => '$data["posts"]',
        ),
        array(
            'header' => 'Пользователей',
            'name' => 'users',
            'value' => '$data["users"]',
        ),
    ),
));
?>