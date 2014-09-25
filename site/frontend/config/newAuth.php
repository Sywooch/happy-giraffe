<?php
return array(
    'guest' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Гость',
        'bizRule' => null,
        'data' => null
    ),
    'user' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Пользователь',
        'children' => array(
            'guest',
            'manageOwnContent',
            'createComment',
        ),
        'bizRule' => null,
        'data' => null
    ),
    'moderator' => array(
        'type' => CAuthItem::TYPE_ROLE,
        'description' => 'Модератор',
        'children' => array(
            'user',
        ),
        'bizRule' => null,
        'data' => null
    ),
    'manageOwnContent' => array(
        'type' => CAuthItem::TYPE_TASK,
        'description' => 'Управление своим контентом (где автор)',
        'children' => array(
            'manageComment',
        ),
        'bizRule' => 'return $params["entity"]->author_id == \Yii::app()->user->id;',
        'data' => null
    ),
    'manageComment' => array(
        'type' => CAuthItem::TYPE_TASK,
        'description' => 'Управление комментариями',
        'children' => array(
            'updateComment',
            'removeComment',
        ),
        'bizRule' => null,
        'data' => null
    ),
    'createComment' => array(
        'type' => CAuthItem::TYPE_TASK,
        'description' => 'Добавление комментария',
        'bizRule' => null,
        'data' => null
    ),
    'updateComment' => array(
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Редактирование комментария',
        'bizRule' => null,
        'data' => null
    ),
    'removeComment' => array(
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Удаление комментария',
        'children' => array(
            'manageComment',
        ),
        'bizRule' => null,
        'data' => null
    ),
);