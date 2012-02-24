<?php

class SignalsController extends BController
{
    public $section = 'club';
    public $layout = '//layouts/club';

    public function actionIndex()
    {
        $filter = Yii::app()->request->getPost('filter');
        $criteria = new EMongoCriteria;

        $criteria->setSort(array(
            'priority' => EMongoCriteria::SORT_ASC,
            '_id' => EMongoCriteria::SORT_ASC,
        ));
        if (!empty($filter))
            $criteria->addCond('signal_type', '==', (int)$filter);

        $models = UserSignal::model()->findAll($criteria);
        if (Yii::app()->request->isAjaxRequest) {
            $this->renderPartial('_data', array(
                'models' => $models
            ));
        } else {
            $this->render('index', array(
                'models' => $models
            ));
        }
    }

    public function actionTake()
    {
        $signal_id = Yii::app()->request->getPost('id');
        $signal = $this->loadModel($signal_id);
        if ($signal->UserCanTake(Yii::app()->user->getId())) {
            $signal->AddExecutor(Yii::app()->user->getId());
            $response = array(
                'status' => 1,
            );
        } else {
            $response = array(
                'status' => 2,
            );
        }
        echo CJSON::encode($response);
    }

    public function actionDecline()
    {
        $signal_id = Yii::app()->request->getPost('id');
        $signal = $this->loadModel($signal_id);
        $signal->DeclineExecutor(Yii::app()->user->getId());
        $response = array(
            'status' => 1,
        );

        echo CJSON::encode($response);
    }

    /**
     * @param int $id model id
     * @return UserSignal
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = UserSignal::model()->findByPk(new MongoId($id));
        if ($model === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return $model;
    }
}
