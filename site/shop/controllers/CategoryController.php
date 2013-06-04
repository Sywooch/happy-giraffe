<?php

class CategoryController extends HController {
	
	public $layout='shop';
	
	public $CQtreeGreedView  = array (
        'modelClassName' => 'Category', //название класса
        'adminAction' => 'admin', //action, где выводится QTreeGridView. Сюда будет идти редирект с других действий.
    );

	public function actions() {
        return array (
            'create'=>'ext.QTreeGridView.actions.Create',
            'update'=>'ext.QTreeGridView.actions.Update',
            'delete'=>'ext.QTreeGridView.actions.Delete',
            'moveNode'=>'ext.QTreeGridView.actions.MoveNode',
            'makeRoot'=>'ext.QTreeGridView.actions.MakeRoot',
        );
    }

	/**
	 * @return array action filters
	 */
	public function filters() {
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules() {
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view','new','brands','brand','ages','age','gender'),
				'users'=>array('*'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete','create','update','moveNode','makeRoot','root','up','down','connectAttributes','connectAttributesSet','attributeList','attributeListSet','unconnectAttribute','addAttributeInSearch','remAttributeInSearch','attributeInSearch'),
//				'users'=>array('@'),
				'roles'=>array('admin'),
				'roles'=>array('guest'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}
	
	public function actionAges() {
		$ages = AgeRange::model()->getAgesArray();
		$this->render('ages', array(
			'ages' => $ages,
			'sexList' => AgeRange::model()->getGenderList(),
		));
	}

	public function actionGender($id) {
		$gender = AgeRange::model()->getGender((int)$id);
		if($gender === null) {
			throw new CHttpException(404,'The requested page does not exist.');
		}
		$descendants = CHtml::listData(Category::model()->findAll(), 'category_id', 'category_name');
		
		$criteria = new CDbCriteria;
		$criteria->compare('product_sex', (int)$id);
		$criteria->compare('product_status', '<> 0');
		$this->getFilter($criteria, $descendants, -2);
		$sort = new CSort;
		$sort->modelClass = 'Product';
		$sort->attributes = array(
			'product_price',
			'product_time',
			'product_rate',
			'product_title',
		);
		
		$products = new CActiveDataProvider('Product', array(
			'criteria' => $criteria,
			'sort' => $sort,
			'pagination' => array(
				'pageSize' => 3,
			),
		));
		$render = Y::isAjaxRequest() ? 'renderPartial'	: 'render';
		
		$this->$render('gender',array(
			'criteria' => $criteria,
			'parents' => array(),
			'products' => $products,
			'descendants' => $descendants,
			'sort' => $sort,
			'gender' => $gender,
		));
	}

	public function actionAge($id) {
		$age = AgeRange::model()->findByPk((int)$id);
		if(empty($age)) {
			throw new CHttpException(404,'The requested page does not exist.');
		}
		$descendants = CHtml::listData(Category::model()->findAll(), 'category_id', 'category_name');
		$criteria = new CDbCriteria;
		$criteria->compare('product_age_range_id', (int)$id);
		$criteria->compare('product_status', '<> 0');
		$this->getFilter($criteria, $descendants, -3);
		
		$sort = new CSort;
		$sort->modelClass = 'Product';
		$sort->attributes = array(
			'product_price',
			'product_time',
			'product_rate',
			'product_title',
		);
		
		$products = new CActiveDataProvider('Product', array(
			'criteria' => $criteria,
			'sort' => $sort,
			'pagination' => array(
					'pageSize' => 3,
				),
			));
		$render = Y::isAjaxRequest() ? 'renderPartial' : 'render';
		$this->$render('age',array(
			'criteria' => $criteria,
			'parents' => array(),
			'products' => $products,
			'descendants' => $descendants,
			'sort' => $sort,
			'age' => $age,
		));
	}
	
	public function actionBrands() {
		Y::dump(Yii::app()->format->formatTime(time()));
		$ct = new CDbCriteria();
		$ct->order = 'brand_title';
		$brands = ProductBrand::model()->findAll($ct);
		$this->render('brands', array(
			'brands' => $brands,
		));
	}
	
	public function actionBrand($id) {
		$brand = ProductBrand::model()->find('brand_id = :brand_id', array(':brand_id' => (int)$id));
		if(empty($brand)) {
			throw new CHttpException(404,'The requested page does not exist.');
		}
		$descendants = CHtml::listData(Category::model()->findAll(), 'category_id', 'category_name');
		$criteria = new CDbCriteria;
		$criteria->compare('product_brand_id', (int)$id);
		$criteria->compare('product_status', '<> 0');
		$this->getFilter($criteria, $descendants, -1);
		$sort = new CSort;
		$sort->modelClass = 'Product';
		$sort->attributes = array(
			'product_price',
			'product_time',
			'product_rate',
			'product_title',
		);
		
		$products = new CActiveDataProvider('Product', array(
			'criteria' => $criteria,
			'sort' => $sort,
			'pagination' => array(
					'pageSize' => 3,
				),
			));
		
		$render = Y::isAjaxRequest() ? 'renderPartial' : 'render';
		$this->$render('brand',array(
			'criteria' => $criteria,
			'parents' => array(),
			'products' => $products,
			'descendants' => $descendants,
			'sort' => $sort,
			'brand' => $brand,
		));
	}
	
	public function actionNew() {
		$descendants = CHtml::listData(Category::model()->findAll(), 'category_id', 'category_name');
		$criteria = new CDbCriteria;
		$criteria->compare('product_status', '<> 0');
		$this->getFilter($criteria, $descendants, 0);
		
		$sort = new CSort;
		$sort->modelClass = 'Product';
		$sort->attributes = array(
			'product_price',
			'product_time',
			'product_rate',
			'product_title',
		);
		
		$products = new CActiveDataProvider('Product', array(
			'criteria' => $criteria,
			'sort' => $sort,
			'pagination' => array(
					'pageSize' => 3,
				),
			));
		$render = Y::isAjaxRequest() ?  'renderPartial'	: 'render';
		$this->$render('new',array(
			'criteria' => $criteria,
			'parents' => array(),
			'products' => $products,
			'descendants' => $descendants,
			'sort' => $sort,
		));
	}

	public function actionAttributeInSearch($id) {
		if(!isset($_POST['insearch'])) {
			CategoryAttributesMap::model()->categoryNotInSearch((int)$id);
			Y::successFlash('All deleted');
			$this->redirect(Y::request()->urlReferrer);
		}
		$maps = CategoryAttributesMap::model()->getCategoryAttributesInSearch((int)$id);
		
		$map = array();
		foreach ($maps as $value)
			$map[$value['map_attribute_id']] = $value['map_attribute_id'];
		$map = CHtml::listData($map, 0, 0);
		
		$to_del = array_diff($map, $_POST['insearch']);
		$to_ins = array_diff($_POST['insearch'], $map);
		
		
		if($to_ins) {
			$exist = Y::command()
				->select('COUNT(*)')
				->from('shop_product_attribute')
				->where(array('in','attribute_id',$to_ins))
				->queryScalar();

			if(count($to_ins) != $exist) {
				Y::errorFlash('Hack');
				$this->redirect(Y::request()->urlReferrer);
			}
			CategoryAttributesMap::model()->setCategoryMapsAttributesInSearch((int)$id, $to_ins);
		}
		
		if($to_del)
			CategoryAttributesMap::model()->setCategoryMapsAttributesInSearch((int)$id, $to_del);
		Y::successFlash('All saved');
		$this->redirect(Y::request()->urlReferrer);
	}
	
	public function actionUnconnectAttribute($id,$categiry_id)
	{
		if(Y::isPostRequest())
		{
			CategoryAttributesMap::model()->unconnectAttribute((int)$id, (int)$categiry_id);
			if(!Y::isAjaxRequest())
				Y::redir(array('view', 'id'=>$categiry_id));
		}
	}
	
	/**
	 * @param int $id attribute ID
	 * @param int $categiry_id category ID
	 */
	public function actionAddAttributeInSearch($id, $categiry_id)
	{
		CategoryAttributesMap::model()->addAttributeInSearch((int)$id, (int)$categiry_id);
		if(Y::isAjaxRequest())
			Y::end('Ok');
		$this->redirect(array('view','id'=>$categiry_id));
	}
	
	/**
	 * @param int $id attribute ID
	 * @param int $categiry_id category ID
	 */
	public function actionRemAttributeInSearch($id, $categiry_id)
	{
		CategoryAttributesMap::model()->removeAttributeFromSearch((int)$id, (int)$categiry_id);
		if(Y::isAjaxRequest())
			Y::end('Ok');
		
		$this->redirect(array('view','id'=>$categiry_id));
	}


	/**
	 * 
	 * @param int $id category ID
	 */
	public function actionConnectAttributes($id)
	{
		if(isset($_POST['attribute_id']))
		{
			$map = new CategoryAttributesMap;
			$map->map_attribute_id = (int)$_POST['attribute_id'];
			$map->map_category_id = (int)$id;
			$map->save();
			Y::redir(array('view', 'id' => $id));
		}
		
		if(Y::isAjaxRequest())
			$this->layout = 'empty';

		$this->render('connectAttributes', array(
			'model'=>$this->loadModel($id),
		));
	}
	
	/**
	 * 
	 * @param int $id category ID
	 */
	public function actionConnectAttributesSet($id)
	{
		if(isset($_POST['set_id']))
		{
			CategoryAttributesMap::model()->connectAttributesSet($id, (int) $_POST['set_id']);
			Y::redir(array('view', 'id'=>$id));
		}
		if(Y::isAjaxRequest())
			$this->layout = 'empty';

		$this->render('connectAttributesSet',array(
			'model'=>$this->loadModel($id),
		));
	}
	
	public function actionAttributeListSet($term = '') {
		Yii::import('attribute.models.AttributeSet');
		$sets = AttributeSet::model()->listAll($term, array('set_title','set_text'));
		foreach($sets as $k=>$v)
		{
			$sets[$k]['value']=$v['set_title'];
		}
		
		if(!$sets)
		{
			$sets[] = array(
				'set_id'=>0,
				'set_title'=>'Not found',
				'set_text'=>'',
				'value'=>'Not found',
			);
		}
		Y::endJson($sets);
	}
	
	public function actionAttributeList($term = '') {
		Yii::import('attribute.models.Attribute');
		$sets = Attribute::model()->listAll($term, array('attribute_title','attribute_text'));
		foreach($sets as $k=>$v)
		{
			$sets[$k]['value']=$v['set_title'];
		}
		
		if(!$sets)
		{
			$sets[] = array(
				'attribute_id'=>0,
				'attribute_title'=>'Not found',
				'attribute_text'=>'',
				'value'=>'Not found',
			);
		}
		Y::endJson($sets);
	}

	public function actionUp($id)
	{
		$model = $this->loadModel($id);
		$prevSubling = $model->prevSibling;

		if(!$prevSubling)
			Y::errorFlash('This category is first');
		else
			$model->moveBefore($prevSubling);

		$this->redirect(array('admin'));
	}

	public function actionDown($id)
	{
		$model = $this->loadModel($id);
		$nextSubling = $model->nextSibling;

		if(!$nextSubling)
			Y::errorFlash('This category is last');
		else
			$model->moveAfter($nextSubling);

		$this->redirect(array('admin'));
	}


	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$id = (int) $id;
		$model = $this->loadModel($id);
		$criteriaParams = array(
			':category_lft' => $model->category_lft,
			':category_rgt' => $model->category_rgt,
			':category_root' => $model->category_root,
		);
		$attridute_ids = CategoryAttributesMap::model()->getByCategory($id);
		
		$ct = new CDbCriteria;
		$ct->addCondition('category_lft < :category_lft');
		$ct->addCondition('category_rgt > :category_rgt');
		$ct->addCondition('category_root = :category_root');
		$ct->params = $criteriaParams;
		$parents = CHtml::listData(Category::model()->findAll($ct), 'category_id', 'category_name');
		
		$ct = new CDbCriteria;
		$ct->addCondition('category_lft >= :category_lft');
		$ct->addCondition('category_rgt <= :category_rgt');
		$ct->addCondition('category_root = :category_root');
		$ct->params = $criteriaParams;
		$descendants = CHtml::listData(Category::model()->findAll($ct), 'category_id', 'category_name');
		
		$criteria = new CDbCriteria;
		$criteria->addInCondition('product_category_id', array_keys($descendants));
		$criteria->compare('product_status', ' <> 0');
		
		$this->getFilter($criteria, $descendants, $id);
		
		$sort = new CSort;
		$sort->modelClass = 'Product';
		$sort->attributes = array(
			'product_price',
			'product_time',
			'product_rate',
			'product_title',
		);
		$sort->defaultOrder = array(
			'product_price' => true,
		);
		
		$products = new CActiveDataProvider('Product', array(
			'criteria' => $criteria,
			'sort' => $sort,
			'pagination' => array(
					'pageSize' => 15,
				),
			));
		
		Yii::import('attribute.models.Attribute');
		$attributes=new Attribute('search');
		$attributes->unsetAttributes();  // clear any default values
		if(isset($_GET['Attribute']))
		{
			$attributes->attributes=$_GET['Attribute'];
		}
		
		$criteria = new CDbCriteria;
		
		if($attridute_ids)
		{
			$attridute_ids = CHtml::listData($attridute_ids, 'map_attribute_id', 'map_attribute_id');

			$criteria->addInCondition('attribute_id', $attridute_ids);
		}
		else {
			$criteria->condition = 'attribute_id=0';
		}
		
		$render = Y::isAjaxRequest() ? 'renderPartial' : 'render';
		
		$this->$render('view',array(
			'model'=>$model,
			'attrs'=>$attributes,
			'criteria'=>$criteria,
			'parents'=>$parents,
			'products'=>$products,
			'descendants'=>$descendants,
			'sort'=>$sort,
		));
	}
	
	protected function getFilter(&$criteria, $descendants, $id) {
		
		if(isset($_POST['resetFilter_x'])) {
			unset ($_POST['AttributeAbstract']);
			unset ($_POST['AttributeSearchForm']);
			Y::user()->setState("AttributeAbstract_{$id}", null);
			Y::user()->setState("AttributeSearchForm_{$id}", null);
		}
		
		if(Y::user()->hasState("AttributeAbstract_{$id}") || isset($_POST['AttributeAbstract'])) {
			if(isset($_POST['AttributeAbstract'])) {
				Y::user()->setState("AttributeAbstract_{$id}", $_POST['AttributeAbstract']);
			}
			$attributes = new AttributeAbstract;
			$attributes->initialize($id);
			
			if(($product_ids = $attributes->getFilter())!==false) {
				$criteria->addInCondition('product_id', $product_ids);
			}
		}
		if(Y::user()->hasState("AttributeSearchForm_{$id}") || isset($_POST['AttributeSearchForm'])) {
			if(isset($_POST['AttributeSearchForm'])) {
				Y::user()->setState("AttributeSearchForm_{$id}", $_POST['AttributeSearchForm']);
			}
			$attributes = new AttributeSearchForm;
			$attributes->initialize($id, $descendants);
			if(($crit = $attributes->getCriteria()) !== false) {
				$criteria->mergeWith($crit);
			}
		}
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionRoot()
	{
		$model = new Category;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Category']))
		{
			$model->attributes = $_POST['Category'];
			if($model->saveNode())
				$this->redirect(array('view','id'=>$model->category_id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate($id)
	{
		$model = new Category;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Category']))
		{
			$model->attributes=$_POST['Category'];
			$parent = $this->loadModel($id);
			if($model->appendTo($parent))
				$this->redirect(array('admin'));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Category']))
		{
			$model->attributes=$_POST['Category'];
			if($model->save())
				$this->redirect(array('view'));
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
			$this->loadModel($id)->NestedSetBehavior->delete();

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
	public function actionIndex() {
		$ct = new CDbCriteria;
		$ct->order = 'category_lft';
		$categories = Category::model()->findByPk(1)->descendants()->findAll($ct);
		$this->render('index', array(
			'categories' => $categories,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model = new Category('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Category']))
			$model->attributes=$_GET['Category'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 * @return Category
	 */
	public function loadModel($id)
	{
		$model = Category::model()->findByPk($id);
		if($model === null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='category-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
