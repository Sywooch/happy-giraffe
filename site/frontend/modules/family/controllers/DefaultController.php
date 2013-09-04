<?php

class DefaultController extends HController
{
    public function actionIndex($userId)
    {
        $user = User::model()->findByPk($userId);
        $json = $user->getFamilyData();
        $json['currentYear'] = date("Y");
        $json['canEdit'] = $user->id == Yii::app()->user->id;
        $this->render('index', compact('json', 'user'));
    }

	public function actionSignup()
	{
        $redirectUrl = Yii::app()->user->getState('redirectUrl');
        if (! empty($redirectUrl)) {
            $url = $redirectUrl;
            Yii::app()->user->setState('redirectUrl', null);
        } else
            $url = Yii::app()->createAbsoluteUrl('profile/default/index', array('user_id' => Yii::app()->user->id));
        $json = Yii::app()->user->model->getFamilyData();
        $json['callback'] = 'window.location.href = \'' . $url . '\';';
        $this->layout = '//layouts/simple';
        $this->render('signup', compact('json'));
	}

    public function actionSave()
    {
        $user = Yii::app()->user->model;

        $createPartner = CJSON::decode(Yii::app()->request->getPost('createPartner'));
        if ($createPartner) {
            $relationshipStatus = Yii::app()->request->getPost('relationshipStatus');

            $transaction = Yii::app()->db->beginTransaction();
            try {
                $partner = new UserPartner();
                $partner->user_id = $user->id;

                $user->relationship_status = $relationshipStatus;

                if($partner->save() && $user->save(true, array('relationship_status')))
                    $transaction->commit();
                else
                    $transaction->rollback();
            }
            catch(Exception $e)
            {
                $transaction->rollback();
                throw $e;
            }
        }

        $babies = Yii::app()->request->getPost('babies');
        if ($babies !== null)
            foreach ($babies as $babyData) {
                $baby = new Baby();
                $baby->attributes = $babyData;
                $baby->parent_id = $user->id;
                $baby->save();
            }

        $data = $user->getFamilyData();
        $data['currentYear'] = date("Y");
        $data['canEdit'] = $user->id == Yii::app()->user->id;
        $response = compact('data');
        echo CJSON::encode($response);
    }
}