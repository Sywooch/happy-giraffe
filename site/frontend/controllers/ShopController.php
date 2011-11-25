<?php

/**
 * Description of ShopController
 *
 * @author Вячеслав
 */
class ShopController extends Controller
{
	public $layout='//layouts/column2';
	
	public function actionCities($term, $id='')
	{
		$where = array('and');
		$term=strtr($term, array('%'=>'\%', '_'=>'\_'));
		$where[] = array('like','name',"%$term%");
		
		if($id)
		{
			$where[] = array('in','region_id', array($id));
		}
		
		$cities = Y::command()
			->select('id, name AS value, name AS label')
			->from(GeoRusSettlement::model()->tableName())
			->where($where)
			->order('name')
			->limit(30)
			->queryAll();
		
		Y::endJson($cities);
	}

	public function actionUserInfo($id)
	{
//		if(Y::isAjaxRequest())
//		{
//			Y::endJson($_POST);
//		}
		
		$this->layout = 'shop';
		$order = $this->loadOrder($id);
		
		$user = '';
		if(Y::user()->getIsGuest())
		{
			$user = new User('signup_cart');
		}
		else
		{
			$user = User::model()->findByPk(Y::userId());
		}
		
		if(isset($_POST['User']))
		{
			$user->attributes = $_POST['User'];
			if($user->save())
			{
				$order->order_user_id = $user->id;
				if(Y::user()->getIsGuest())
				{
					$identity = new UserIdentity($user->getAttributes());
					$identity->authenticate();
					if ($identity->errorCode == UserIdentity::ERROR_NONE)
					{
						Yii::app()->user->login($identity);
					}
				}
			}
			else
			{
				$data = array(
					'method'=>'error',
					'user'=>$user->getErrors(),
				);

				$this->arrayReset($data, 'user');
			}
		}
		
		$validate = false;
		
		$adress = OrderAdress::model()->find('adress_order_id=:adress_order_id', array(
			':adress_order_id'=>$order->order_id,
		));
		
		if(!$adress)
		{
			$adress = new OrderAdress;
		}
		if(isset($_POST['OrderAdress']))
		{
			$adress->attributes = $_POST['OrderAdress'];
			$adress->adress_order_id = $order->order_id;
			if(!Y::user()->getIsGuest())
			{
				$validate = $adress->validate();
				if(!$validate)
				{
					$data = array(
						'method'=>'error',
						'adress'=>$adress->getErrors(),
					);
					$this->arrayReset($data, 'adress');
				}
			}
			else
			{
				$validate = false;
			}
		}
		
		if(isset($_POST['Order']))
		{
			$order->attributes = $_POST['Order'];
		}

		if($validate)
		{
			if($order->save())
			{
				$data = Yii::app()->getModule('delivery')->done($order->order_id, $_POST['name'], $_POST['city']);

				if($data['method']=='redir')
				{
					$adress->save(false);

					Y::user()->setState('create_order_id', $order->order_id);

					$data['url'] = $this->createUrl('shopCartDelivery', array('id'=>$order->order_id));
				}
			}
			else
			{
				$errors = $order->getErrors();
			}
		}
		if(isset($data))
			Y::endJson($data);
		
		$this->render('userInfo', array(
			'user'=>$user,
			'adress'=>$adress,
			'order'=>$order,
			'geo'=>$this->toRender(),
		));
	}
	
	private function arrayReset(&$array, $field)
	{
		if(!isset($array[$field]) || !is_array($array[$field]))
			return;
		
		foreach($array[$field] as $k=>$v)
		{
			if(is_array($v))
			{
				$array[$field][$k] = reset($v);
			}
		}
	}


	private function toRender()
	{
		Yii::import('delivery.models.*');
		
		$modelRegions = new GeoRusRegion('searchRegions');
		$modelRegions->unsetAttributes();  // clear any default values

		$modelDistrict = new GeoRusDistrict();
		$modelDistrict->unsetAttributes();  // clear any default values

		$modelCities = new GeoRusSettlement();
		$modelCities->unsetAttributes();

		$this->renderPartial('delivery.views.default.actionSelectDestination', array(
			'modelCities' => $modelCities,
			'modelRegions' => $modelRegions,
			'modelDistrict' => $modelDistrict,
			'OrderId' => 0,
			), true, true
		);
		
		return array(
			'cities'=>$modelCities,
			'regions'=>$modelRegions,
			'district'=>$modelDistrict,
		);
	}

	public function actionPutInAjax($id, $count=1)
	{
		$product = $this->loadProduct($id);
		
		Yii::app()->shoppingCart->put($product, (int)$count);
		
		Y::endJson(array(
			'msg'=>'Ok',
			'count'=>Yii::app()->shoppingCart->getItemsCount(),
			'cost'=>Yii::app()->shoppingCart->getCost(),
		));
	}

	public function actionPutIn($id, $count=1)
	{
		$product = $this->loadProduct($id);
		
		Yii::app()->shoppingCart->put($product, (int)$count);
		
		if(Y::isAjaxRequest())
		{
			$this->renderPartial('putIn', array(
				'model'=>$product,
			));
		}else{
			$this->redirect(Y::request()->urlReferrer);
		}
	}
	
	public function actionUpdate($id, $count)
	{
		$product = $this->loadProduct($id);
		
		Yii::app()->shoppingCart->update($product, (int)$count);
		
		if(Y::isAjaxRequest())
			Y::endJson(array('msg'=>'Ok'));
		
		$this->redirect(Y::request()->urlReferrer);
	}
	
	public function actionRemove($id)
	{
		$product = $this->loadProduct($id);
		
		Yii::app()->shoppingCart->remove($product->getId());
		
		if(Y::isAjaxRequest())
			Y::endJson(array('msg'=>'Ok'));
		
		$this->redirect(Y::request()->urlReferrer);
	}

	public function actionClear()
	{
		Yii::app()->shoppingCart->clear($product);
		
		if(Y::isAjaxRequest())
			Y::endJson(array('msg'=>'Ok'));
		
		$this->redirect(Y::request()->urlReferrer);
	}
	
	public function actionShopCart()
	{
		$this->layout = 'shop';
		$this->render('shopCart');
	}
	
	public function actionShopCartDelivery()
	{
//		Y::dump(Yii::app()->getModule('billing')->paymentSystems());
		
		$this->layout = 'shop';
		
		if(!Y::user()->hasState('create_order_id'))
			throw new CHttpException(404, 'The requested page does not exist.');

		Yii::import('delivery.models.Delivery');

		$id = Y::user()->getState('create_order_id');
		
		$order = Y::command()
			->select()
			->from(Order::model()->tableName())
			->where('order_id=:order_id', array(
				':order_id'=>$id,
			))
			->limit(1)
			->queryRow();
		
		if(!$order)
			throw new CHttpException(404, 'The requested page does not exist.');

		$delivery = array(
			'cost' => Delivery::getCostByOrder($order['order_id']),
			'adress' => Delivery::getAdressByOrder($order['order_id']),
			'method' => Delivery::getMethodByOrder($order['order_id']),
		);
		
		Y::command()
			->update(Order::model()->tableName(), array(
				'order_price_delivery' => $delivery['cost'],
				'order_delivery_adress' => $delivery['adress'],
			),'order_id=:order_id', array(
				':order_id'=>$order['order_id'],
			));
		
		$order = Y::command()
			->select()
			->from(Order::model()->tableName())
			->where('order_id=:order_id', array(
				':order_id'=>$order['order_id'],
			))
			->limit(1)
			->queryRow();
		
		$adress = Y::command()
			->select('adress_index, adress_street, adress_house, adress_corps, adress_room, adress_porch, adress_floor, geo_rus_region.name AS region_name, geo_rus_settlement.name AS city_name')
			->from('shop_order_adress')
			->where('adress_order_id=:adress_order_id', array(
				':adress_order_id'=>$id,
			))
			->leftJoin('geo_rus_region', 'geo_rus_region.id=adress_region_id')
			->leftJoin('geo_rus_settlement', 'geo_rus_settlement.id=adress_city_id')
			->order('adress_id DESC')
			->limit(1)
			->queryRow();
		
//		$items = Y::command()
//			->select()
//			->from('shop_order_item')
//			->leftJoin(Product::model()->tableName(), 'item_product_id=product_id')
//			->where('item_order_id=:item_order_id', array(
//				':item_order_id'=>$order['order_id'],
//			))
//			->queryAll();
		
		Y::user()->setState('billing_url_next', $this->createAbsoluteUrl('/shop/thank'));

		$this->render('shopCartDelivery', array(
			'delivery' => $delivery,
			'order' => $order,
			'adress' => $adress,
			'ps' => Yii::app()->getModule('billing')->paymentSystems(),
//			'items' => $items,
		));
	}
	
	public function actionThank()
	{
		if(!Y::user()->hasState('billing_url_next'))
			throw new CHttpException(404, 'The requested page does not exist.');
		
		Y::user()->setState('billing_url_next', null);
		Y::user()->setState('vaucher', null);
		
		$id = Y::user()->getState('create_order_id');
		
		Yii::app()->shoppingCart->clear();
		
		$this->render('thank', array(
			'order_id'=>$id,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 * @return Product
	 */
	public function loadProduct($id)
	{
		$model=Product::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	
	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 * @return Order
	 */
	public function loadOrder($id)
	{
		$model=Order::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
	
	public function actionUseVaucher($code)
	{
		if(($vaucher = Vaucher::isActive($code)))
		{
			Y::user()->setState('vaucher', $vaucher);
			$msg = array('msg'=>'Ok');
		}else{
			$msg = array('msg'=>'Ваучер с указанным кодом не найден');
		}
		
		if(Y::isAjaxRequest())
			Y::endJson($msg);
		
		$this->redirect(Y::request()->urlReferrer);
	}
}