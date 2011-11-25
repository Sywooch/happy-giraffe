<?php

class DefaultController extends Controller
{
    public $layout = '//layouts/main';

    public function actionIndex()
    {
        $date = null;

        $this->render('index', array(
            'date' => $date
        ));
    }

    public function actionVaccineTable(){
        if (isset($_POST['day']) && isset($_POST['month']) && isset($_POST['year'])) {
            $date = strtotime($_POST['day'] . '-' . $_POST['month'] . '-' . $_POST['year']);

            $this->renderPartial('_data_table', array(
                'date' => $date,
                'baby_id'=>$_POST['baby_id'],
            ));
        }
    }

    public function actionSaveDate($date)
    {
        if (Yii::app()->request->isAjaxRequest) {
            if (Yii::app()->user->isGuest) {
                echo 'You are nor authorized';
                Yii::app()->end();
            }
            if (isset($date)) {
                $vaccine_date_save = new VaccineSave;
                $vaccine_date_save->date = date("Y-m-d", $date);
                $vaccine_date_save->user_id = Yii::app()->user->getId();
                if ($vaccine_date_save->save())
                    echo CJavaScript::encode(true);
                else
                    echo CJavaScript::encode(false);
            }
        }
    }

    public function actionVote($id, $vote, $baby_id)
    {
        if (Yii::app()->request->isAjaxRequest) {
            if (Yii::app()->user->isGuest) {
                echo CJSON::encode(array(
                    'success'=>false,
                ));
                Yii::app()->end();
            }
            $vaccineDate = $this->LoadVaccineDate($id);
            if ($vaccineDate->ChangeVote(Yii::app()->user->getId(),$vote, $baby_id))
                echo CJSON::encode(array(
                    'success'=>true,
                    'decline'=>array($vaccineDate->vote_decline,$vaccineDate->DeclinePercent()),
                    'agree'=>array($vaccineDate->vote_agree,$vaccineDate->AgreePercent()),
                    'did'=>array($vaccineDate->vote_did,$vaccineDate->DidPercent()),
                ));
            else
                echo CJSON::encode(array('success'=>false));
        }
    }

    /**
     * @param $id
     * @return VaccineDate
     */
    public function LoadVaccineDate($id){
        return VaccineDate::model()->findByPk($id);
    }
}