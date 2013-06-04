<?php

class DefaultController extends HController
{

	public $scenario = NULL;

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow', // allow all users to perform 'index' and 'view' actions
				'actions' => array('*'),
				'users' => array('*'),
			),
		);
	}

	public function init()
	{
		
	}

	public function actionIndex()
	{
		$dataProvider = new CActiveDataProvider('Delivery', array());
		$directories = glob('protected\\modules\\delivery\\modules\\*', GLOB_ONLYDIR);
		$modules = array();
		foreach($directories as $dir)
		{
			$modname = substr($dir, strlen('protected\\modules\\delivery\\modules\\'));
			$b = false;
			foreach($dataProvider->data as $dname)
			{
				if($modname == $dname->delivery_name)
				{
					$b = true;
					break;
				}
			}
			if(!$b)
				$modules[$modname] = $modname;
		}
		$model = new Delivery();

		if(isset($_POST['Delivery']))
		{
			$model->attributes = $_POST['Delivery'];
			$model->save();
		}
		$this->render(__FUNCTION__, array(
			'modules' => $modules,
			'dataProvider' => $dataProvider,
			'model' => $model,
			)
		);
	}

	/*
	 * Функция получает выбор пользователя о типе доставки
	 * проверяет ИД полученного ордера
	 * и передает ордерИД и delivery_name
	 */

	public function actionSelectDelivery($OrderId = 1)
	{
		$modules = array();
		foreach($this->module->components as $k => $dir)
		{
			$modules[$k] = $dir['show_name'];
		}

		$model = new Delivery();
		$model->order_id = $OrderId;

		if(isset($_POST['Delivery']))
		{
			$model->attributes = $_POST['Delivery'];
			$params = $this->module->getParams();
			$b = false;
			if(isset($OrderId))
			{
				$modelOrder = CActiveRecord::model($params['OrderModel'])->findByPk($OrderId);
				if(!isset($modelOrder))
					$b = true;
			}
			else
				$b = true;
			if(!$b) {
				$url = $this->createUrl('/delivery/default/createD', array( 'OrderId' => $OrderId, 'DeliveryName' => $model->delivery_name));
			}
			else
				echo 'Error with order #' . $OrderId;
		}

		$this->render(__FUNCTION__, array(
				'modules' => $modules,
				'model' => $model,
			)
		);
	}

	public function actionSelectDestination($OrderId)
	{
		if(isset($_POST['OrderId']))
			$OrderId = $_POST['OrderId'];

		if(isset($OrderId))
		{
			$params = $this->module->getParams();
			$modelOrder = CActiveRecord::model($params['OrderModel'])->findByPk($OrderId);
			if(isset($modelOrder))
			{
				$city = GeoRusSettlement::model()->findAllByPk($modelOrder->$params['getCity']());
				$modelRegions = new GeoRusRegion('searchRegions');
				$modelRegions->unsetAttributes();  // clear any default values
				if(isset($_POST['GeoRusRegion']))
					$modelRegions->id = $_POST['GeoRusRegion']['id'];

				$modelDistrict = new GeoRusDistrict();
				$modelDistrict->unsetAttributes();  // clear any default values
				if(isset($_POST['GeoRusDistrict']))
					$modelDistrict->id = $_POST['GeoRusDistrict']['id'];

				$modelCities = new GeoRusSettlement();
				$modelCities->unsetAttributes();  // clear any default values
				if(isset($_POST['GeoRusSettlement']))
				{
					$modelCities->id = $_POST['GeoRusSettlement']['id'];

					$this->redirect(array(
						'/delivery/default/showDeliveryTable',
						'city_id' => $modelCities->id,
						'region_id' => $modelRegions->id,
						'district_id' => $modelDistrict->id,
						'OrderId' => $OrderId));
					return;
				}

				$modelCities->id = $city[0]['id'];
				$modelDistrict->id = $city[0]['district_id'];
				$modelRegions->id = $city[0]['region_id'];

				$render = Y::isAjaxRequest() ? 'renderPartial' : 'render';

				$this->$render(__FUNCTION__, array(
					'modelCities' => $modelCities,
					'modelRegions' => $modelRegions,
					'modelDistrict' => $modelDistrict,
					'OrderId' => $OrderId,
					)
				);
			}
			else
			{
				$this->redirect($this->createUrl($params['returnUrl']));
			}
		}
	}

	public function actionShowDeliveryTable(/* $city_id, $OrderId */)
	{
		$OrderId = Y::getGet('OrderId', Y::getPost('OrderId'));
		$city_id = Y::getGet('city_id', Y::getPost('city_id', Y::getPost('GeoRusSettlement.id')));
		$district_id = Y::getGet('district_id', Y::getPost('district_id', Y::getPost('GeoRusDistrict.id')));
		$region_id = Y::getGet('region_id', Y::getPost('region_id', Y::getPost('GeoRusRegion.id')));

		$modelCity = GeoRusSettlement::model()->findByPk($city_id);

		$modules = array();

		$model = new Delivery();
		$model->order_id = $OrderId;

		//Получаем параметры модели заказа
		//и загружаем данные о модели
		$params = $this->module->getParams();

		$cnt = 0;

		$modelOrder = CActiveRecord::model($params['OrderModel'])->findByPk($model->order_id);

		foreach($this->module->components as $k => $dir)
		{
			//Получаем имя класса расширения доставки
			//и подключаем его к модулю доставки
			$mn = $dir['class_name'];
			Yii::import($dir['ext']);

			//Создаем модель настройки параметров доставки
			$modelDelivery = CActiveRecord::model($mn);

			//Получаем параметры заказа из модели заказа
			//Определяем три города по которым будем искать способы доставки
			$city1 = false;
			$city2 = false;
			$city3 = false;
			if($modelCity)
			{
			    $city1 = explode(" ", $modelCity->getSettlementName());
			    $city2 = explode(" ", $modelCity->district ? $modelCity->district->getSettlementName() : false);
			    $city3 = explode(" ", $modelCity->region ? $modelCity->region->getSettlementName() : false);
			}

			$cityarr = array();
			if(strlen($city1[0]) > 3)
				array_push($cityarr, $city1[0]);
			if(strlen($city2[0]) > 3)
				array_push($cityarr, $city2[0]);
			if(strlen($city3[0]) > 3)
				array_push($cityarr, $city3[0]);

			$price = ShopCart::getCost();
			$weight = 1;
			if($modelOrder)
			{
				$price = $modelOrder->$params['getPrice']();
				$weight = $modelOrder->$params['getWeight']();
			}
			$parameter = array(
				'orderPrice' => $price,
				'orderWeight' => $weight,
				'orderCity' => $cityarr,
				'orderCityId' => $city_id,
				'orderRegion' => $city3[0], 0, 0);

			$delivery_prices = $modelDelivery->getDeliveryCost($parameter);
			if($delivery_prices)
			{
				foreach($delivery_prices as $delivery_price)
				{
					if($delivery_price['price'] !== null)
					{
						$cnt++;
						$modules[$cnt]['id'] = $k;
						$modules[$cnt]['name'] = $dir['show_name'];
						$modules[$cnt]['class_name'] = $dir['class_name'];
						$modules[$cnt]['price'] = $delivery_price['price'];
						$modules[$cnt]['destination'] = $delivery_price['destination'];
						$modules[$cnt]['htmlclass'] = ($modelDelivery->additionPropretys) ? "BTC" : "noBTC";
						if (isset($delivery_price['orderCityId'])) {
							$modules[$cnt]['orderCityId'] = $delivery_price['orderCityId'];
						}
					}
				}
			}
		}
		$dataProvider = new CArrayDataProvider($modules, array(
				'id' => 'id',
				'pagination' => array(
					'pageSize' => 10,
				),
			));

		$render = Y::isAjaxRequest() ? 'renderPartial' : 'render';

		$this->$render(__FUNCTION__, array(
				'modules' => $modules,
				'modelCities' => $modelCity,
				'OrderId' => $OrderId,
				'dataProvider' => $dataProvider,
			)
		);
	}

	public function actionSelectDeliveryModule($OrderId, $name, $city, $orderCityId = null)
	{
		$data = $this->getModule()->done($OrderId, $name, $city, $orderCityId);
		
		if(isset($data['method']) && $data['method']=='redir')
		{
			Y::endJson($data);
		}
		
		$data = array_merge($data, array(
			'name'=>$name,
			'city'=>$city,
		));

		$render = Y::isAjaxRequest() ? 'renderPartial' : 'render';
		
		$price = reset($data['price']);
		
		Y::endJson(array(
			'method'=>'show',
			'html'=>$this->$render(__FUNCTION__, $data, true),
			'price'=>intval($price['price']),
		));
	}

	public function actionGetDistrictNames()
	{
		if(Yii::app()->request->isPostRequest)
		{

			if(!empty($_POST['regval']) && intval($_POST['regval']) != 0)
			{
				$pid = (int) $_POST['regval'];
			}
			else
			{
				echo CJSON::encode(array('val' => 0, 'data' => '', 'submit' => false, 'attrs' => ''));
				Yii::app()->end();
			}

			$data = GeoRusDistrict::model()->getDistrict($pid);

			if(!empty($data))
			{
				$opt = CHtml::tag('option', array('value' => '-1'), '...', true);
				foreach($data as $value => $name)
				{
					$opt.=CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
				}
				$arr = array('val' => $pid, 'data' => $opt, 'submit' => false, 'attrs' => '');
			}
			else
			{
				$arr = array('val' => $pid, 'data' => 'empty', 'submit' => true, 'attrs' => '');
			}
			echo CJSON::encode($arr);
			Yii::app()->end();
		}
	}

	public function actionGetCityNames()
	{
		if(Yii::app()->request->isPostRequest)
		{

			if(!empty($_POST['regval']) && intval($_POST['regval']) != 0)
			{
				$pid = (int) $_POST['regval'];
			}
			if(($_POST['regval'] == 0))
			{
				echo CJSON::encode(array('val' => 0, 'data' => '', 'submit' => false, 'attrs' => ''));
				Yii::app()->end();
			}

			$data2 = GeoRusSettlement::model()->getCities(null, $pid);

			if(!empty($data) || !empty($data2))
			{
				$opt = CHtml::tag('option', array('value' => '-1'), '...', true);
				if(!empty($data))
				{
					foreach($data as $value => $name)
					{
						$opt.=CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
					}
				}
				if(!empty($data2))
				{
					foreach($data2 as $value => $name)
					{
						$opt.=CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
					}
				}
				$arr = array('val' => $pid, 'data' => $opt, 'submit' => false, 'attrs' => '');
			}
			else
			{
				$arr = array('val' => $pid, 'data' => 'empty', 'submit' => true, 'attrs' => $this->attrsFields($pid));
			}
			echo CJSON::encode($arr);
			Yii::app()->end();
		}
	}

	/*
	 * Создаем форму настройки доставки
	 */

	public function actionCreateD()
	{
		$model = new Delivery();
		$model->delivery_name = $_POST['Delivery']['delivery_name'];
		$model->order_id = $_POST['Delivery']['order_id'];

		//Получаем имя класса расширения доставки
		//и подключаем его к модулю доставки
		$mn = $this->module->components[$model->delivery_name]['class_name'];
		Yii::import($this->module->components[$model->delivery_name]['ext']);

		//Создаем модель настройки параметров доставки
		$modelDelivery = CActiveRecord::model($mn);

		//Получаем параметры модели заказа
		//и загражаем данные о модели
		$params = $this->module->getParams();

		$b = false; //Переменная ошибки при загрузке модели заказа
		if(isset($model->order_id))
		{
			$modelOrder = CActiveRecord::model($params['OrderModel'])->findByPk($model->order_id);
			if(isset($modelOrder))
			{
				//Получаем параметры заказа из модели заказа
				$parameter = array(
						'orderPrice' => $modelOrder->$params['getPrice'](),
						'orderWeight' => $modelOrder->$params['getWeight'](),
						'orderCity' => $modelOrder->$params['getCity'](), 0, 0, 0
					);
			}
			else {
				$b = true;
			}
		}
		else {
			$b = true;
		}

		if(isset($_POST[$mn]))
		{
			$modelDelivery->attributes = $_POST[$mn];

			//Проводим валидацию полученных параметров модели и проверяем были ли ошибки при загрузке заказа
			if(($modelDelivery->validate()) && (!$b))
			{
				//Производим расчет стоимости доставки
				$model->delivery_cost = $modelDelivery->getDeliveryCost($parameter);
				$form = $modelDelivery->getHiddenForm($parameter);
				$dform = $model->getForm();
				$form['action'] = $this->createUrl('/delivery/default/showResults');
			}
			else {
				$form = $modelDelivery->getForm($parameter);
				$dform = $model->getHiddenForm();
			}
			$form['buttons'] = array(
				'back' => array(
					'type' => 'button',
					'attributes' => array('onclick' => 'js:window.history.go(-1);'),
					'label' => 'Ох ничего себе, давай обратно',
				),
				'login' => array(
					'type' => 'submit',
					'label' => 'Я согласен!',
				),
			);
		}
		else
		{

			$form = $modelDelivery->getForm($parameter);
			$dform = $model->getHiddenForm();
			$form['buttons'] = array(
				'back' => array(
					'type' => 'button',
					'attributes' => array('onclick' => 'js:window.history.go(-1);'),
					'label' => 'Не-не-не давай обратно',
				),
				'login' => array(
					'type' => 'submit',
					'label' => 'Дальше (посмотреть сколько стоит)',
				),
			);
		}

		$form['elements'] = array_merge($form['elements'], $dform['elements']);


		$form = new CForm($form);

		$form[$model->getClassName()]->model = $model;
		$form[$mn]->model = $modelDelivery;

		$this->render(__FUNCTION__, array(
			'formDelivery' => $form,
			)
		);
	}

	public function actionShowResults()
	{
		$model = new Delivery();

		if(isset($_POST['Delivery']))
		{
			$model->delivery_name = $_POST['Delivery']['delivery_name'];
			$model->order_id = $_POST['Delivery']['order_id'];
			$model->delivery_cost = $_POST['Delivery']['delivery_cost'];
		}

		$mn = $this->module->components[$model->delivery_name]['class_name'];
		Yii::import($this->module->components[$model->delivery_name]['ext']);
		$modelDelivery = new $mn();

		if(isset($_POST[$mn]))
			$modelDelivery->attributes = $_POST[$mn];

		if($model->validate() && $modelDelivery->validate())
		{
			$modelDelivery->save();
			$model->delivery_id = $modelDelivery->id;
			$model->save();
			$params = $this->module->getParams();
			$url = $this->createUrl('/delivery/default/success', array('delivery_id' => $model->id));
			$this->redirect($url);
		}

		$this->render(__FUNCTION__, array(
				'model' => $model,
				'modelDelivery' => $modelDelivery
			)
		);
	}

	public function actionSuccess($delivery_id)
	{

		$model = (isset($delivery_id)) ? Delivery::model()->findByPk($delivery_id) : null;
		if($model !== null)
		{
			$ext = $this->module->components[$model->delivery_name]['ext'];
			$mn = $this->module->components[$model->delivery_name]['class_name'];

			Yii::import($ext);
			//Создаем модель настройки параметров доставки
			$modelDelivery = CActiveRecord::model($mn)->findByPk($model->delivery_id);

			$form = $modelDelivery->getSuccessForm($parameter);
			$dform = $model->getForm();
			$params = $this->module->getParams();
			$form['action'] = $this->createUrl($params['returnUrl'], array($params['order_id'] => $modelDelivery->order_id));

			$form['buttons'] = array(
				'forvard' => array(
					'type' => 'submit',
					'label' => 'Дальше!',
				),
			);

			$form['elements'] = array_merge($form['elements'], $dform['elements']);
			$form = new CForm($form);

			$form[$model->getClassName()]->model = $model;
			$form[$mn]->model = $modelDelivery;
		}
		$this->render(__FUNCTION__, array(
				'formDelivery' => $form,
				'model' => $model
			)
		);
	}

	protected function performAjaxValidation($model)
	{
		Y::dump($_POST, false);
		if(isset($_POST['ajax']) && $_POST['ajax'] === 'fuck')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	protected function getOrderDeliveryModel($OrderId)
	{
		if(isset($OrderId))
		{
			$condition = new CDbCriteria;
			$condition->compare('order_id', $OrderId);
			$modelDelivery = Delivery::model()->find($condition);
			if(isset($modelDelivery))
			{
				return $modelDelivery;
			}
		}
		return NULL;
	}

	protected function checkDeliveryAvailable($OrderId)
	{
		$model = $this->getOrderDeliveryModel($OrderId);
		if(isset($model))
		{
			$ext = $this->module->components[$model->delivery_name]['ext'];
			$mn = $this->module->components[$model->delivery_name]['class_name'];

			Yii::import($ext);
			//Создаем модель настройки параметров доставки
			$modelDelivery = CActiveRecord::model($mn)->findByPk($model->delivery_id);

			$form = $modelDelivery->getSuccessForm($parameter);
			$dform = $model->getShowForm();
			$params = $this->module->getParams();

			$form['buttons'] = array(
				'back' => array(
					'type' => 'link',
					'attributes' => array('href' => $this->createUrl($params['returnUrl'])),
					'label' => 'Назад',
				),
				'update' => array(
					'type' => 'submit',
					'label' => 'Изменить',
				),
			);

			$form['elements'] = array_merge($dform['elements'], $form['elements']);

			$form = new CForm($form);

			$form[$model->getClassName()]->model = $model;
			$form[$mn]->model = $modelDelivery;

			return $form;
		}

		return NULL;
	}

	public function actionValidateDeliveryModule()
	{
		if(isset($_POST['ajax']) && $_POST['ajax'] === 'settings-sel')
		{
			foreach($_POST as $key => $val)
			{
				if(is_array($val))
				{
					$ext = Yii::app()->getModule('delivery')->components[$key]['ext'];
					$mn = Yii::app()->getModule('delivery')->components[$key]['class_name'];
					Yii::import($ext);
					$model = CActiveRecord::model($mn);
					$model->attributes = $val;
					echo CActiveForm::validate($model);
					Yii::app()->end();
				}
			}
		}
	}
}

?>
