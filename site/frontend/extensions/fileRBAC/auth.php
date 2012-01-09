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
		),
		'bizRule' => null,
		'data' => null
	),
	'moder' => array(
		'type' => CAuthItem::TYPE_ROLE,
		'description' => 'Модератор',
		'children' => array(
			'user',
		),
		'bizRule' => null,
		'data' => null
	),
	'editor' => array(
		'type' => CAuthItem::TYPE_ROLE,
		'description' => 'Редактор',
		'children' => array(
			'moder',
		),
		'bizRule' => null,
		'data' => null
	),
);