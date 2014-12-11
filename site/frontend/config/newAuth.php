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
            'createPost',
            'manageOwnPhotoCollection',
            'createPhotoAlbum',
            'managePhotoAttach',
            'uploadPhoto',
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
            'managePost',
            'managePhotoAlbum',
            'editPhoto',
        ),
        'bizRule' => 'return \site\frontend\components\AuthManager::checkOwner($params["entity"], \Yii::app()->user->id);',
        'data' => null
    ),
    'createPost' => array(
        'type' => CAuthItem::TYPE_TASK,
        'description' => 'Добавление общих типов контента',
        'children' => array(
            'createPhotopost',
            'createStatus',
        ),
        'bizRule' => null,
        'data' => null
    ),
    'managePost' => array(
        'type' => CAuthItem::TYPE_TASK,
        'description' => 'Управление общими типами контента',
        'children' => array(
            'managePhotopost',
            'manageStatus',
        ),
        'bizRule' => null,
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
        'bizRule' => null,
        'data' => null
    ),
    'managePhotopost' => array(
        'type' => CAuthItem::TYPE_TASK,
        'description' => 'Управление фотопостом',
        'children' => array(
            'updatePhotopost',
            'removePhotopost',
        ),
        'bizRule' => null,
        'data' => null
    ),
    'createPhotopost' => array(
        'type' => CAuthItem::TYPE_TASK,
        'description' => 'Добавление фотопоста',
        'bizRule' => null,
        'data' => null
    ),
    'updatePhotopost' => array(
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Редактирование фотопоста',
        'bizRule' => null,
        'data' => null
    ),
    'removePhotopost' => array(
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Удаление фотопоста',
        'bizRule' => null,
        'data' => null
    ),
    'manageStatus' => array(
        'type' => CAuthItem::TYPE_TASK,
        'description' => 'Управление статусом',
        'children' => array(
            'updateStatus',
            'removeStatus',
        ),
        'bizRule' => null,
        'data' => null
    ),
    'createStatus' => array(
        'type' => CAuthItem::TYPE_TASK,
        'description' => 'Добавление статуса',
        'bizRule' => null,
        'data' => null
    ),
    'updateStatus' => array(
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Редактирование статуса',
        'bizRule' => null,
        'data' => null
    ),
    'removeStatus' => array(
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Удаление статуса',
        'bizRule' => null,
        'data' => null
    ),
    'createPhotoAlbum' => array(
        'type' => CAuthItem::TYPE_TASK,
        'description' => 'Создание альбома',
        'bizRule' => null,
        'data' => null,
    ),
    'managePhotoAlbum' => array(
        'type' => CAuthItem::TYPE_TASK,
        'description' => 'Управление альбомами',
        'children' => array(
            'editPhotoAlbum',
            'removePhotoAlbum',
            'restorePhotoAlbum',
        ),
        'bizRule' => null,
        'data' => null,
    ),
    'editPhotoAlbum' => array(
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Редактирование комментария',
        'bizRule' => null,
        'data' => null,
    ),
    'removePhotoAlbum' => array(
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Удаление комментария',
        'bizRule' => null,
        'data' => null,
    ),
    'restorePhotoAlbum' => array(
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Удаление комментария',
        'bizRule' => null,
        'data' => null,
    ),
    'managePhotoAttach' => array(
        'type' => CAuthItem::TYPE_TASK,
        'description' => 'Управление альбомами',
        'children' => array(
            'removePhotoAttach',
            'restorePhotoAttach',
        ),
        'bizRule' => 'return $params["entity"]->collection->getOwner()->id == \Yii::app()->user->id;',
        'data' => null,
    ),
    'removePhotoAttach' => array(
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Удаление комментария',
        'bizRule' => null,
        'data' => null,
    ),
    'restorePhotoAttach' => array(
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Удаление комментария',
        'bizRule' => null,
        'data' => null,
    ),
    'manageOwnPhotoCollection' => array(
        'type' => CAuthItem::TYPE_TASK,
        'description' => 'Управление своей фотоколлекцией',
        'children' => array(
            'addPhotos',
            'sortPhotoCollection',
            'setCover',
            'moveAttaches',
        ),
        'bizRule' => 'return $params["entity"]->getOwner()->id == \Yii::app()->user->id;',
        'data' => null,
    ),
    'sortPhotoCollection' => array(
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Сортировка коллекции',
        'bizRule' => null,
        'data' => null,
    ),
    'addPhotos' => array(
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Перемещение аттачей',
        'bizRule' => null,
        'data' => null,
    ),
    'setCover' => array(
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Изменение обложки',
        'bizRule' => null,
        'data' => null,
    ),
    'moveAttaches' => array(
        'type' => CAuthItem::TYPE_OPERATION,
        'description' => 'Перемещение аттачей',
        'bizRule' => null,
        'data' => null,
    ),
    'uploadPhoto' => array(
        'type' => CAuthItem::TYPE_TASK,
        'description' => 'Загрузка фотографий',
        'bizRule' => null,
        'data' => null
    ),
    'editPhoto' => array(
        'type' => CAuthItem::TYPE_TASK,
        'description' => 'Загрузка фотографий',
        'bizRule' => null,
        'data' => null
    ),
);