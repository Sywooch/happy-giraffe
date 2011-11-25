<?php

class CalendarController extends Controller
{

	public $layout = '//layouts/main';

	public function actionIndex()
	{
		$content = CommunityContent::model()->community(5)->findAll(array(
			'limit' => 5,
		));
		
		$products = Product::model()->findAll(array(
			'condition' => 'product_category_id=:category_id',
			'params' => array(':category_id' => 7),
		));
		
		$this->render('index', array(
			'products' => $products,
			'content' => $content,
		));
	}

}