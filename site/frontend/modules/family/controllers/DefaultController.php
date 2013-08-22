<?php

class DefaultController extends HController
{
    public function actionIndex()
    {
        $this->render('index');
    }

	public function actionSignup()
	{
        $json = Yii::app()->user->model->getFamilyData();
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
    }
}