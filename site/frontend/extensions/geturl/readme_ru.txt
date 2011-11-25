EGetUrlBehavior
===============

Поведение для простого получения URL модели (в конфигурации необходимо описать
соответствующие правила роутинга).

Использование
-------------
Добавляем поведение модели:
~~~
[php]
	public function behaviors()
	{
		return array(
			'getUrl' => array(
				'class' => 'ext.geturl.EGetUrlBehavior',
				'route' => 'site/city',
				'dataField' => array(
					'id' => 'city_id',
					'title' => 'city_slug',
				),
			),
		);
	}
~~~


Получение URL:
~~~
[php]
$model->getUrl();
~~~

или:
~~~
[php]
$model->url;
~~~