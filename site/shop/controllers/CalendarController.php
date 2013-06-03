<?php

class CalendarController extends HController
{

	public $layout = '//layouts/main';

	public function actionIndex()
	{
		$contents = CommunityContent::model()->with('rubric.community', 'type')->findAll(array(
            'order' => 'RAND()',
            'limit' => 5,
        ));

        $communities = Community::model()->findAll(array(
            'order' => 'RAND()',
            'limit' => 4,
        ));
		
		$products = Product::model()->findAll(array(
			'condition' => 'product_category_id = :category_id',
			'params' => array(':category_id' => 7),
		));
		
		$this->render('index', array(
			'products' => $products,
			'contents' => $contents,
            'communities' => $communities,
		));
	}

}