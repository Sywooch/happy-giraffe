<?php

class DefaultController extends HController
{
    public $layout = 'main';

    public function filters()
    {
        return array(
            'ajaxOnly + take, decline, history',
        );
    }

    public function beforeAction($action)
    {
        if (!Yii::app()->user->checkAccess('user_signals'))
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        $this->pageTitle = 'Сигналы';
        $filter = Yii::app()->request->getPost('filter');
        if ($filter == 'null' || empty($filter))
            $filter = null;

        //5 новых статей
        $criteria = new EMongoCriteria;
        $criteria->addCond('status', '==', UserSignal::STATUS_OPEN);
        $criteria->addCond('success', '<>', (int)Yii::app()->user->id);
        $criteria->addCond('executors', '<>', (int)Yii::app()->user->id);
        $criteria->addCond('full', '==', false);
        if (Yii::app()->user->checkAccess('administrator'))
            $criteria->limit(5);
        else
            $criteria->limit(5);

        $criteria->setSort(array(
            'priority' => EMongoCriteria::SORT_ASC,
            //'user_priority' => EMongoCriteria::SORT_ASC,
            '_id' => EMongoCriteria::SORT_DESC,
        ));
        if (!empty($filter))
            $criteria->addCond('signal_type', '==', (int)$filter);

        $models = UserSignal::model()->findAll($criteria);

        //плюс те, которые он выполняет
        $criteria = new EMongoCriteria;
        $criteria->addCond('status', '==', UserSignal::STATUS_OPEN);
        $criteria->addCond('executors', '==', (int)Yii::app()->user->id);
        $criteria->addCond('success', '<>', (int)Yii::app()->user->id);
        $criteria->limit(5);

        $criteria->setSort(array(
            'priority' => EMongoCriteria::SORT_ASC,
            '_id' => EMongoCriteria::SORT_DESC,
        ));
        if (!empty($filter))
            $criteria->addCond('signal_type', '==', (int)$filter);

        $models2 = UserSignal::model()->findAll($criteria);
        $models = array_merge($models2, $models);
        if (Yii::app()->request->isAjaxRequest) {
            $history = UserSignal::model()->getHistory(Yii::app()->user->id, date("Y-m-d"), 5);
                $response = array(
                    'status' => true,
                    'tasks'=> $this->renderPartial('_data', array('models' => $models), true),
                    'history'=> $this->renderPartial('_history', array('history' => $history), true)
                );

            echo CJSON::encode($response);
        } else {
            $history = UserSignal::model()->getHistory(Yii::app()->user->id, date("Y-m-d"), 5);
            $this->render('index', array(
                'models' => $models,
                'history' => $history
            ));
        }
    }

    public function actionTake()
    {
        $signal_id = Yii::app()->request->getPost('id');
        $signal = $this->loadModel($signal_id);
        if (!$signal->full) {
            $signal->AddExecutor(Yii::app()->user->id);
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
        $signal->DeclineExecutor(Yii::app()->user->id);
        $response = array(
            'status' => 1,
        );

        echo CJSON::encode($response);
    }

    public function actionHistory()
    {
        $date = Yii::app()->request->getPost('date');
        $history = UserSignal::model()->getHistory(Yii::app()->user->id, $date);

        $this->renderPartial('_history', array('history' => $history));
    }

    public function actionCalendar()
    {
        $this->renderPartial('_calendar', array(
            'month' => Yii::app()->request->getPost('month'),
            'year' => Yii::app()->request->getPost('year'),
            'activeDate' => Yii::app()->request->getPost('current_date'),
        ));
    }

    public function actionRemoveAll()
    {
        if (Yii::app()->user->checkAccess('administrator')){
            UserSignal::model()->deleteAll();
            UserSignalHistory::model()->deleteAll();
            UserSignalResponse::model()->deleteAll();
        }
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
            throw new CHttpException(404, 'Ошибка, обратитесь к разработчикам.');
        return $model;
    }
}