<?php

class ProductController extends HController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/shop';

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
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view','create','update','admin','delete','addSubProduct','productList','product_fill','attributes','sendComment','showComments','showImage'),
				'users'=>array('*'),
			),
//			array('allow', // allow authenticated user to perform 'create' and 'update' actions
//				'actions'=>array('create','update'),
//				'users'=>array('@'),
//			),
//			array('allow', // allow admin user to perform 'admin' and 'delete' actions
//				'actions'=>array('admin','delete'),
//				'users'=>array('admin'),
//			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	public function actionAddSubProduct($id)
	{
		if(Yii::app()->getRequest()->getIsAjaxRequest())
			$this->layout = 'empty';
		
		if(isset($_POST['product_id'], $_POST['main_product_id']))
		{
			Product::model()->addSubProduct((int)$_POST['main_product_id'], (int)$_POST['product_id']);
			Y::redir(array('view', 'id' => (int)$_POST['main_product_id']));
		}
		$this->render('addSubProduct', array(
			'model'=>$this->loadModel($id),
		));
	}
	
	public function actionProductList($term)
	{
		$list = Product::model()->listsAll($term, 'product_id, product_title, product_image, product_description');
		foreach($list as $k=>$v)
		{
			$list[$k]['value'] = $v['product_title'];
			$list[$k]['image'] = UFiles::getFileInstance($v['product_image'])->getUrl('thumb');
		}
		Y::endJson($list);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$model = $this->loadModel($id);
		
		$criteriaImage = new CDbCriteria;
		$criteriaImage->compare('image_product_id', $id);
		$images = new ProductImage('search');
		
		$subProducts = Product::model()->getSubProductsByProductId((int)$id);
		$subProducts = CHtml::listData($subProducts, 'link_sub_product_id', 'link_sub_product_id');
		
		$criteriaSubProduct = new CDbCriteria;
		$criteriaSubProduct->addInCondition('product_id', $subProducts);
		$subProducts = new Product('search');
		$subProducts->unsetAttributes();
		

		$this->render('view',array(
			'model' => $model,
			'criteriaImage' => $criteriaImage,
			'images' => $images,
			'criteriaSubProduct' => $criteriaSubProduct,
            'subProducts' => $subProducts,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Product(Product::SCENARIO_SELECT_CATEGORY);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Product']))
		{
			$model->attributes=$_POST['Product'];
			if($model->validate())
				$this->redirect(array('product_fill','category_id'=>$model->product_category_id));
		}

		$this->render('product_category',array(
			'model'=>$model,
		));
	}
	
	public function actionProduct_fill($category_id)
	{
		$model = new Product(Product::SCENARIO_FILL_PRODUCT);
		$model->product_category_id = (int) $category_id;

		if(isset($_POST['Product']))
		{
			$model->attributes = $_POST['Product'];
			if($model->save())
			{
				$this->redirect(array('attributes','id'=>$model->product_id));
			}
		}
		$this->render('create', array('model' => $model));
	}
	
	/**
	 *
	 * @param int $id product_id
	 */
    /* TODO DELETE */
	/*public function actionAttributes($id)
	{
		$product = Product::model()->findByPk((int)$id);
		
		if(!$product)
			throw new CHttpException(404, 'The requested page does not exist.');
		
		$attribute = new AttributeAbstract;
		$attribute->initialize($product->product_category_id);
		$attribute->setProductValues((int)$id);
		$form = $attribute->getForm();
		
		if($form->submitted('submit') && $attribute->save())
		{
			Y::successFlash('Fttributes save succesfuly');
			$this->redirect(array('view','id'=>$id));
		}
		
		if(Y::isAjaxRequest())
			$this->layout = 'empty';
		
		$this->render('attributes', array(
			'form' => $attribute->getForm(),
		));
	}*/

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);
		$model->setScenario(Product::SCENARIO_FILL_PRODUCT);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Product']))
		{
			$model->attributes=$_POST['Product'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->product_id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$this->loadModel($id)->delete();

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Product');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Product('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Product']))
			$model->attributes=$_GET['Product'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Product::model()->with(array('category', 'videos', 'brand'))->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='product-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
	
	public function actionSendComment()
	{
		if (Yii::app()->request->isAjaxRequest)
		{
			$comment = new ProductComment;
			$comment->attributes = $_POST['ProductComment'];
			$comment->author_id = Yii::app()->user->id;
			if ($comment->save())
			{
				$response = array(
					'status' => 'ok',
				);
			}
			else
			{
				print_r($comment->getErrors());
				die;
				$response = array(
					'status' => 'error',
				);
			}
			echo CJSON::encode($response);
		}
	}
	
	public function actionShowComments()
	{
		if (Yii::app()->request->isAjaxRequest)
		{
			$product_id = $_POST['product_id'];
			$product = Product::model()->findByPk($product_id, array('select' => 'product_rate'));
			$rating = $this->renderPartial('rating', array('rating' => $product->product_rate), TRUE);
			$comments = ProductComment::model()->get($product_id);
			$list = $this->renderPartial('list', array('comments' => $comments), TRUE);
			$total = count($comments);
		
			$response = array(
				'list' => $list,
				'total' => $total,
				'rating' => $rating,
			);
		
			echo CJSON::encode($response);
		}
	}

}
