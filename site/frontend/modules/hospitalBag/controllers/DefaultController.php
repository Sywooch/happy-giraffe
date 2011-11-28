<?php

class DefaultController extends Controller
{
	public function actionIndex()
	{	
		$item = new BagItem;
	
		$bag = Yii::app()->user->getState('hospitalBag', array());
		$visible_items = BagCategory::model()->getVisibleItems($bag);
		$offers = BagOffer::model()->getOffers(Yii::app()->user->id);
		
		$this->render('index', array(
			'visible_items' => $visible_items,
			'offers' => $offers,
			'item' => $item,
		));
	}
	
	public function actionAddOffer()
	{
		if (isset($_POST['BagItem']) && ! Yii::app()->user->isGuest)
		{
			$item = new BagItem;
			$offer = new BagOffer;
			$item->attributes = $_POST['BagItem'];
			$item->for = BagItem::FOR_MUM;
			$item->category_id = 5;
			$offer->user_id = Yii::app()->user->id;
			$transaction = Yii::app()->db->beginTransaction();
			try
			{
				$item->save();
				$offer->item_id = $item->id;
				$offer->save();
				$transaction->commit();
			}
			catch (Exception $e)
			{
				$transaction->rollBack();
			}
		}
	}
	
	public function actionPutIn($id)
	{
		if (Yii::app()->request->isAjaxRequest)
		{
			$bag = Yii::app()->user->getState('hospitalBag', array());
			$bag[] = $id;
			Yii::app()->user->setState('hospitalBag', $bag);
			
			$response = array(
				'success' => TRUE,
				'count' => count($bag),
			);
			
			echo CJSON::encode($response);
		}
	}
}