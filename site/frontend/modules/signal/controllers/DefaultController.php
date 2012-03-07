<?php

class DefaultController extends Controller
{
    public $layout = 'main';

    public function filters()
    {
        return array(
            'ajaxOnly + take, decline, history',
        );
    }

    public function beforeAction()
    {
        if (!Yii::app()->user->checkAccess('user_signals'))
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        return true;
    }

    public function actionIndex()
    {
        $filter = Yii::app()->request->getPost('filter');
        $criteria = new EMongoCriteria;
        $criteria->addCond('status', '==', UserSignal::STATUS_OPEN);
        $criteria->limit(5);

        $criteria->setSort(array(
            'priority' => EMongoCriteria::SORT_ASC,
            '_id' => EMongoCriteria::SORT_DESC,
        ));
        if (!empty($filter))
            $criteria->addCond('signal_type', '==', (int)$filter);

        $models = UserSignal::model()->findAll($criteria);

        if (Yii::app()->request->isAjaxRequest) {
            $this->renderPartial('_data', array(
                'models' => $models,
            ));
        } else {
            $history = UserSignal::model()->getHistory(Yii::app()->user->getId(), date("Y-m-d"));
            $this->render('index', array(
                'models' => $models,
                'history'=> $history
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

    public function actionHistory()
    {
        $date = Yii::app()->request->getPost('date');
        $history = UserSignal::model()->getHistory(Yii::app()->user->getId(), $date);

        $this->renderPartial('_history', array('history' => $history));
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