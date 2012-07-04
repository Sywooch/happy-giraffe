<?php

class DefaultController extends HController
{
	public $layout = '//layouts/new';
    public $pageTitle = 'Сумка в роддом';

    public function filters()
    {
        return array(
            'accessControl',
            'addOffer,putIn,vote + ajaxOnly'
        );
    }

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
			'count' => count($bag),
		));
	}
	
	public function actionAddOffer()
	{
        if (isset($_POST['BagItem']) && !Yii::app()->user->isGuest)
		{
            $item = new BagItem;
            $item->attributes = $_POST['BagItem'];

            if (isset($_POST['ajax']) && $_POST['ajax'] == 'addOffer'){
                $item->attributes = $_POST['BagItem'];
                echo CActiveForm::validate($item);
                Yii::app()->end();
            }
			$offer = new BagOffer;
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
			$this->renderPartial('_comment',array(
                'model'=>$offer,
                'i'=>$_POST['i']
            ));
		}
	}
	
	public function actionPutIn()
	{
		if (Yii::app()->request->isAjaxRequest)
		{
			$id = $_POST['id'];
			$bag = Yii::app()->user->getState('hospitalBag', array());
			$bag[] = $id;
			Yii::app()->user->setState('hospitalBag', $bag);
			
			$response = array(
				'success' => true,
				'count' => count($bag),
			);
			
			echo CJSON::encode($response);
		}
	}
	
	public function actionVote()
	{
		if (Yii::app()->request->isAjaxRequest && ! Yii::app()->user->isGuest)
		{
			$offer_id = $_POST['offer_id'];
			$vote = $_POST['vote'];
			$offer = BagOffer::model()->findByPk($offer_id);
			if ($offer)
			{
				$offer->vote(Yii::app()->user->id, $vote);
				$offer->refresh();
				
				$response = array(
					'success' => true,
					'votes_pro' => $offer->votes_pro,
					'votes_con' => $offer->votes_con,
					'pro_percent' => $offer->getPercent(1),
					'con_percent' => $offer->getPercent(0),
				);
			}
			else
			{
				$response = array(
					'success' => false,
				);
			}
			
			echo CJSON::encode($response);
		}
	}
}