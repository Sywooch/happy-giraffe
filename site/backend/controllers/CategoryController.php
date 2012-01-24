<?php

class CategoryController extends BController
{
    public function actionIndex()
    {
        $tree = Category::model()->roots()->findAll(array('order' => 'category_root, category_lft'));

        $count = array(
            'total' => Category::model()->count(),
            'on' => Category::model()->count('active = 1'),
            'off' => Category::model()->count('active = 0'),
        );

        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.ui.nestedSortable.js');

        $this->render('index', array(
            'tree' => $tree,
            'count' => $count,
        ));
    }

    public function actionAdd($type)
    {
        if (Yii::app()->request->isAjaxRequest)
        {
            if (isset($_POST['Category']))
            {
                $category = new Category;
                $category->attributes = $_POST['Category'];

                if ($type == 'root')
                {
                    $result = $category->saveNode();
                }
                else
                {
                    $prependTo = Yii::app()->request->getPost('prependTo');
                    $node = Category::model()->findByPk($prependTo);
                    $result = $category->prependTo($node);
                }

                if ($result)
                {
                    $response = array(
                        'status' => true,
                        'attributes' => $category->attributes,
                        'modelPk' => $category->primaryKey,
                    );
                }
                else
                {
                    $response = array(
                        'status' => false,
                    );
                }

                echo CJSON::encode($response);
            }
        }
    }

    public function getTreeItems($model)
    {
        if(!$model || count($model) == 0)
            return '';
        $html = '';
        $html .= CHtml::openTag('ul');
        foreach($model as $item)
        {
            $html .= $this->renderPartial('_tree_item', array(
                'model' => $item,
            ), true);
        }
        $html .= CHtml::closeTag('ul');
        return $html;
    }
}
