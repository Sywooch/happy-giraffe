<?php

class DefaultController extends Controller
{
    public $layout = '//layouts/new';

    /**
     * @sitemap
     */
    public function actionIndex()
    {
        $this->pageTitle = 'Календарь прививок ребенка. Какие прививки делают детям?';

        $date = null;

        $this->render('index', array(
            'date' => $date
        ));
    }

    public function actionVaccineTable()
    {
        if (isset($_POST['day']) && isset($_POST['month']) && isset($_POST['year'])) {
            $date = strtotime($_POST['day'] . '-' . $_POST['month'] . '-' . $_POST['year']);

            $this->renderPartial('_data_table', array(
                'date' => $date,
                'baby_id' => $_POST['baby_id'],
            ));
        }
        if (isset($_POST['baby_id'])) {
            $baby = Baby::model()->findByPk($_POST['baby_id']);
            if (empty($baby))
                Yii::app()->end();
            $date = strtotime($baby->birthday);

            $this->renderPartial('_data_table', array(
                'date' => $date,
                'baby_id' => $_POST['baby_id'],
            ));
        }
    }

    public function actionVote($id, $vote, $baby_id)
    {
        if (Yii::app()->request->isAjaxRequest) {
            if (Yii::app()->user->isGuest) {
                echo CJSON::encode(array(
                    'success' => false,
                ));
                Yii::app()->end();
            }
            $vaccineDate = $this->LoadVaccineDate($id);
            $vaccineDate->vote(array(
                'user_id' => Yii::app()->user->getId(),
                'baby_id' => $baby_id), $vote);
            $vaccineDate->refresh();

            echo CJSON::encode(array(
                'success' => true,
                'decline' => $vaccineDate->vote_decline . ' (' . $vaccineDate->getPercent(0) . '%)',
                'agree' => $vaccineDate->vote_agree . ' (' . $vaccineDate->getPercent(1) . '%)',
                'did' => $vaccineDate->vote_did . ' (' . $vaccineDate->getPercent(2) . '%)',
            ));
            //            else
            //                echo CJSON::encode(array('success' => false));
        }
    }

    /**
     * @param $id
     * @return VaccineDate
     */
    public function LoadVaccineDate($id)
    {
        return VaccineDate::model()->findByPk($id);
    }
}