<?php

/**
 * Description of ShopController
 *
 */
class ShopController extends HController {

	public $layout = 'shop';

	public function actionCities($term, $id = '') {
		$cities = GeoRusSettlement::model()->getCitiesByTitle($term, $id);
		Y::endJson($cities);
	}

	public function actionUserInfo($id) {
		$Order = $this->loadOrder($id);
		if (Yii::app()->user->isGuest) {
			$User = new User('signup_cart');
		} 
		else {
			$User = User::model()->findByPk(Yii::app()->user->id);
		}
		if (isset($_POST['User'])) {
			$User->attributes = $_POST['User'];
			if ($User->save()) {
				$Order->order_user_id = $User->id;
				if (Yii::app()->user->isGuest) {
					$identity = new CUserIdentity($User->getAttributes());
					$identity->authenticate();
					if ($identity->errorCode == UserIdentity::ERROR_NONE) {
						Yii::app()->user->login($identity);
					}
				}
			}
			else {
				$data = array(
					'method' => 'error',
					'user'	=> $User->getErrors()
				);
				$this->arrayReset($data, 'user');
			}
		}
		$validate = false;
		$Address = OrderAdress::model()->getOrderAddress($Order->order_id);
		if (isset($_POST['OrderAdress'])) {
			$Address->attributes = $_POST['OrderAdress'];
			$Address->adress_order_id = $Order->order_id;
			if (!Yii::app()->user->isGuest) {
				$validate = $Address->validate();
				if (!$validate) {
					$data = array(
						'method' => 'error',
						'adress' => $Address->getErrors(),
					);
					$this->arrayReset($data, 'adress');
				}
			} 
			else {
				$validate = false;
			}
		}
		if (isset($_POST['Order'])) {
			$Order->attributes = $_POST['Order'];
		}
		if ($validate) {
			if ($Order->save()) {
				$data = Yii::app()->getModule('delivery')->done($Order->order_id, $_POST['name'], $_POST['city'], $_POST['OrderAdress']['adress_city_id']);
				if ($data['method'] == 'redir') {
					$Address->save(false);
					Yii::app()->user->setState('create_order_id', $Order->order_id);
					$data['url'] = $this->createUrl('shopCartDelivery', array('id' => $Order->order_id));
				}
			} 
			else {
				$errors = $Order->getErrors();
			}
		}
		if (isset($data)) {
			Y::endJson($data);
		}
		$this->render('userInfo', array(
			'user' => $User,
			'adress' => $Address,
			'order' => $Order,
			'geo' => $this->toRender(),
		));
	}

	private function arrayReset(&$array, $field) {
		if (!isset($array[$field]) || !is_array($array[$field]))
			return;

		foreach ($array[$field] as $k => $v) {
			if (is_array($v)) {
				$array[$field][$k] = reset($v);
			}
		}
	}

	private function toRender() {
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
			'cities' => $modelCities,
			'regions' => $modelRegions,
			'district' => $modelDistrict,
		);
	}

	public function actionPutInAjax($id, $count=1) {
        $model = ShopCart::add($id, (int) $count);
		Y::endJson(array(
			'msg' => 'Ok',
			'count' => ShopCart::getItemsCount(),
			'cost' => ShopCart::getCost(),
            'itemCount' => $model->count,
            'itemCost' => $model->getSumPrice(),
		));
	}


    /**
     * @param int  $id product primaryKey
     * @param int  $count product count
     * @param bool $put kakya to hren'
     */
    public function actionPutIn($id, $count=1, $put = false)
    {
		$product = $this->loadProduct($id);

        $attributes = array();
        if($put == false)
        {
            $attributeSetMap = $product->category->GetAttributesMap();
            foreach ($attributeSetMap as $attribute)
            {

                if ($attribute->map_attribute->attribute_in_price == 1) {
                    $attribute_values = $product->GetCardAttributeValues($attribute->map_attribute->attribute_id);
                    if(count($attribute_values) == 0)
                        continue;
                    $attributes[$attribute->map_attribute->attribute_id] = array(
                        'attribute' => $attribute,
                        'items' => array(),
                    );
                    foreach($attribute_values as $attribute_value)
                        $attributes[$attribute->map_attribute->attribute_id]['items'][$attribute_value['eav_id']] = $attribute_value['eav_attribute_value'];
                }
            }
        }

        if(count($attributes) == 0)
            $put = true;

        if(isset($_POST['Attribute']))
        {
            $product->cart_attributes = $_POST['Attribute'];
        }

        if($put !== false)
        {
            $cart = ShopCart::add($product, (int) $count);
        }
		if (Y::isAjaxRequest()) {
            if($put !== false)
            {
                $this->renderPartial('putIn', array(
                    'model' => $product,
                    'cart' => $cart,
                ));
            }
            else
            {
                $this->renderPartial('putInAttributes', array(
                    'model' => $product,
                    'attributes' => $attributes
                ));
            }
		} 
		else {
			$this->redirect(Y::request()->urlReferrer);
		}
	}

	public function actionUpdate($id, $count) {
		$product = $this->loadProduct($id);

		Yii::app()->shoppingCart->update($product, (int) $count);

		if (Y::isAjaxRequest())
			Y::endJson(array('msg' => 'Ok'));

		$this->redirect(Y::request()->urlReferrer);
	}

	public function actionRemove($sid) {
		ShopCart::remove($sid);
		if (Y::isAjaxRequest())
			Y::endJson(array('msg' => 'Ok'));

		$this->redirect(Y::request()->urlReferrer);
	}

	public function actionClear() {
		ShopCart::clear();

		if (Y::isAjaxRequest())
			Y::endJson(array('msg' => 'Ok'));

		$this->redirect(Y::request()->urlReferrer);
	}

	public function actionShopCart() {
		$this->render('shopCart');
	}

	public function actionShopCartDelivery() {
		if (!Y::user()->hasState('create_order_id')) {
			throw new CHttpException(404, 'The requested page does not exist.');
		}
		Yii::import('delivery.models.Delivery');
		$id = Y::user()->getState('create_order_id');
		$Order = Order::model()->findByPk($id);
		if ($Order === null) {
			throw new CHttpException(404, 'The requested page does not exist.');
		}
		$delivery = Delivery::getOrderInformation($Order->order_id);
		/** Update order with delivery information */
		$Order->order_price_delivery = $delivery['cost'];
		$Order->order_delivery_adress = $delivery['adress'];
		$Order->save();
		
		/** Get formatted address of order */
		$address = OrderAdress::model()->getFormattedOrderAddress($Order->order_id);
		Y::user()->setState('billing_url_next', $this->createAbsoluteUrl('/shop/thank'));
		$this->render('shopCartDelivery', array(
			'delivery' => $delivery,
			'Order' => $Order,
			'address' => $address,
			'ps' => Yii::app()->getModule('billing')->paymentSystems(),
		));
	}

	public function actionThank() {
		if (!Y::user()->hasState('billing_url_next')) {
			throw new CHttpException(404, 'The requested page does not exist.');
		}

		Y::user()->setState('billing_url_next', null);
		Y::user()->setState('vaucher', null);
		
		$id = Y::user()->getState('create_order_id');
		
		ShopCart::clear();
		$this->render('thank', array(
			'order_id' => $id,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 * @return Product
	 */
	public function loadProduct($id) {
		$model = Product::model()->findByPk($id);
		if ($model === null) {
			throw new CHttpException(404, 'The requested page does not exist.');
		}
		return $model;
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 * @return Order
	 */
	public function loadOrder($id) {
		$model = Order::model()->findByPk($id);
		if ($model === null) {
			throw new CHttpException(404, 'The requested page does not exist.');
		}
		return $model;
	}

	public function actionUseVaucher($code) {
		if (($vaucher = Vaucher::isActive($code))) {
			Y::user()->setState('vaucher', $vaucher);
			$msg = array('msg' => 'Ok');
		} 
		else {
			$msg = array('msg' => 'Ваучер с указанным кодом не найден');
		}
		if (Y::isAjaxRequest()) {
			Y::endJson($msg);
		}
		$this->redirect(Y::request()->urlReferrer);
	}
}