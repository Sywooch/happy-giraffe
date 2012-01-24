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

    public function actionMoveNode($id, $parent = false, $prev = false)
    {
        $model = Category::model()->findByPk($id);
        if($model === null)
            Yii::app()->end();
        if($parent !== false)
            $parent = Category::model()->findByPk($parent);
        if($prev !== false)
            $prev = Category::model()->findByPk($prev);

        if($prev && !$prev->isRoot())
            $model->moveAfter($prev);
        elseif($parent)
            $model->moveAsFirst($parent);
        else
            $model->moveAsRoot();
    }

    public function actionAdd()
    {
        if (Yii::app()->request->isAjaxRequest)
        {
            if (isset($_POST['Category']))
            {
                $category = new Category;
                $category->attributes = $_POST['Category'];

                if ($_POST['type'] == 'root')
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
                        'html' => $this->renderPartial('_tree_item', array('model' => $category), true),
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

    protected function getTreeItems($model, $root = false)
    {
        $html = '';
        $html .= CHtml::openTag('ul', array('class' => 'descendants'.($root ? ' sortable' : '')));
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
