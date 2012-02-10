<?php
class UsersController extends BController
{
    public $layout = 'shop';

    public function actionIndex()
    {
        if(Yii::app()->request->getQuery('user-list-check') && Yii::app()->request->getQuery('workWithItemsSelected'))
        {
            switch(Yii::app()->request->getQuery('workWithItemsSelected'))
            {
                case 'delete' :
                    Yii::app()->db->createCommand()->update('user', array('deleted' => 1), 'id in (' . implode(',', Yii::app()->request->getQuery('user-list-check')) . ')');
            }
        }

        $criteria = new CDbCriteria;

        if(Yii::app()->request->getQuery('gender'))
        {
            $criteria->addCondition('t.gender = :gender');
            $criteria->params[':gender'] = Yii::app()->request->getQuery('gender');
        }

        $dataProvider = new CActiveDataProvider('User', array(
            'criteria' => $criteria,
            'pagination' => array(

            ),
        ));

        $list_type = 'table';
        if (Yii::app()->request->isAjaxRequest && isset($_GET['list_type']))
            $list_type = $_GET['list_type'];

        $viewData = array(
            'dataProvider' => $dataProvider,
            'list_type' => $list_type,
        );

        if (!isset($_GET['change_view']))
            $this->render('index', $viewData);
        else
        {
            Yii::app()->clientScript->scriptMap = array(
                'jquery.js' => false,
                'jquery.min.js' => false,
                'jquery-ui.js' => false,
                'jquery-ui.min.js' => false,
                'jquery.ba-bbq.js' => false,
                'jquery-ui.css' => false,
            );
            $this->renderPartial('_' . $list_type, $viewData, false, true);
        }

    }
}
