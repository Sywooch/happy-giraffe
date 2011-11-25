SImageUploadBehavior
===============

Поведение для работы с изображениями

Использование
-------------

~~~
[php]
	public function behaviors()
	{
		return array(
			'SImageUploadBehavior' => array(
				'class' => 'ext.SImageUploadBehavior.SImageUploadBehavior',
				'fileAttribute' => 'restaurant_logo',
				'nameAttribute' => 'restaurant_slug',
				'folder' => 'upload/restaurant',
				'mkdir' => true,
				'useDateForName' => false,
				'useUrlForName' => false,
				'imagesRequired' => array(
					'thumb' => array('width' => 68, 'height' => 68, 'folder' => 'thumb'),
					'middle' => array('width' => 150, 'height' => 150, 'folder' => 'middle'),
					'big' => array('width' => 250, 'height' => 250, 'folder' => 'big'),
					'full' => array('width' => 800, 'height' => 600, 'folder' => 'full', 'smartResize' => false),
				),
			),
		);
	}
~~~

~~~
[php]
	public function rules()
	{
		return array(
//----------------------SImageUploadBehavior------------------------
			array('restaurant_logo', 'file', 'types'=>'jpg, gif, png','allowEmpty'=>true,'message'=>'Трабла'), //Опционально
			array('restaurant_logo', 'unsafe'), //Обязательно
//----------------------SImageUploadBehavior------------------------
		);
	}

~~

Не забываем о:
~~~
[php]
	'htmlOptions'=>array(
		'enctype'=>'multipart/form-data',
	),
~~~