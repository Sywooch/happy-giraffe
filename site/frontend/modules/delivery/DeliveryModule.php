<?php

class DeliveryModule extends CWebModule
{
	/*
	 * Available Delivery methods
	 */

	public $components = array(
		'Gff' => array(
			'ext' => 'ext.delivery.Gruzovozoff.EGruzovozoff',
			'class_name' => 'EGruzovozoff',
			'show_name' => 'Грузовозофф',
		),
		'PickPoint' => array(
			'ext' => 'ext.delivery.PickPoint.EPickPoint',
			'class_name' => 'EPickPoint',
			'show_name' => 'PickPoint',
		),
		'DPD' => array(
			'ext' => 'ext.delivery.DPD.EDPD',
			'class_name' => 'EDPD',
			'show_name' => 'Dynamic Parcel Distribution',
		),
		'DZPM' => array(
			'ext' => 'ext.delivery.DZPM.EDZPM',
			'class_name' => 'EDZPM',
			'show_name' => 'Доставка за пределы МКАД',
		),
		'DPM' => array(
			'ext' => 'ext.delivery.DPM.EDPM',
			'class_name' => 'EDPM',
			'show_name' => 'Доставка по Москве в пределах МКАД',
		),
	);

	/*
	 * Здесь надо указать название и соответсвие функций модели заказа
	 */
	public $params = array(
		'OrderModel' => 'Order',
		'getPrice' => 'getPrice',
		'getWeight' => 'getWeight',
		'getVolume' => 'getVolume',
		'getCountry' => 'getCountry',
		'getRegion' => 'getRegion',
		'getCity' => 'getCity',
		'getAdress' => 'getAdress',
		'returnUrl' => '/',
		'order_id' => 'id',
	);
	public $returnUrl = '/';
	
	public $showResult = false;

	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application
		// import the module-level models and components
		$this->setImport(array(
			'delivery.models.*',
			'delivery.controllers.*',
		));

		if($this->returnUrl)
			$this->params['returnUrl'] = $this->returnUrl;

		//Проверяем и инсталлируем все установленные модели доставки
		$this->setComponents(
			$this->components
		);

		$this->setParams(
			$this->params
		);
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
			return true;
		}
		else
			return false;
	}
	
	public function done($OrderId, $name, $city, $orderCityId = null)
	{
		if(!$name) {
			return array();
		}
		//Получаем параметры модели заказа
		//и загружаем данные о модели
		$params = $this->getParams();
		$ext = $this->components[$name]['ext'];
		$mn = $this->components[$name]['class_name'];
		
		$modelOrder = CActiveRecord::model($params['OrderModel'])->findByPk($OrderId);
		//Создаем модель настройки параметров доставки
		Yii::import($ext);
		$modelDelivery = new $mn();

		if(isset($_POST['ajax']) && $_POST['ajax'] === 'settings-sel') {
			$modelDelivery->attributes = $_POST[$mn];
		}

		$price = $modelOrder->$params['getPrice']();
		$weight = $modelOrder->$params['getWeight']();

		//Получаем параметры заказа из модели заказа
		$parameter = array(
			'orderPrice' => $price,
			'orderWeight' => $weight,
			'orderCity' => array($city), //здесь указываем уже только конкретный город который выбрал пользователь
			'orderRegion' => $city, 0, 0);
		if ($orderCityId !== null) {
			$parameter['orderCityId'] = $orderCityId;
		}

		//Здесь проверка не требует ли модель ввода дополнительных данных
		//Если требует то выводим СФорм с необходимыми полями (при этом та форма сохраняет все в пост)
		//И после перезагрузки формы получаем дополнительные данные
		//В противном случае пропускаем этот шаг
		$model = new Delivery();
		$model->order_id = $OrderId;

		//Заново производим расчет стоимости доставки

		$delivery_prices = $modelDelivery->getDeliveryCost($parameter);
		$destination = $modelDelivery->getDestination();

		if($delivery_prices)
		{
			foreach($delivery_prices as $delivery_price)
			{
				$model->delivery_name = $name;
				$model->delivery_cost = $delivery_price['price'];
				$model->delivery_address = $destination;
			}
		}

		$bT = true;
		if($modelDelivery->additionPropretys)
		{
			$bT = false;
			if(isset($_POST[$mn]))
			{
				$bT = true;
				$modelDelivery->attributes = $_POST[$mn];
			}

			$config = $modelDelivery->getForm($parameter);
			$config['activeForm'] = array(
				'id' => 'settings-sel', // Important
				'class' => 'CActiveForm',
				'enableAjaxValidation' => true,
				'clientOptions' => array(
					'validateOnSubmit' => true,
				),
			);

			$form = new CForm($config, $modelDelivery);
		}
		if($bT)
		{
			if($modelDelivery->save())
			{
				$model->delivery_id = $modelDelivery->id;
				if($model->save())
				{
					if($this->showResult)
					{
						$url = $this->createUrl('/delivery/default/success', array('delivery_id' => $model->id));
					}
					else
					{
						$url = Yii::app()->createUrl($params['returnUrl'], array($params['order_id'] => $OrderId));
					}
					return array(
						'method'=>'redir',
						'url'=>$url,
					);
				}
			}
		}
		return array(
			'formDelivery' => (string)$form,
			'modelDelivery' => $modelDelivery,
			'price'=>$delivery_prices,
		);
	}
}
