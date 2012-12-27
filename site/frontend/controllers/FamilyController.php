<?php
/**
 * Author: alexk984
 * Date: 30.03.12
 *
 * @property User $user
 */
class FamilyController extends HController
{
    public $user;
    public $layout = 'user_new';

    public function filters()
    {
        return array(
            'accessControl',
            'addBaby,removeBaby,removePhoto,removeFutureBaby + onlyAjax'
        );
    }

    public function accessRules()
    {
        return array(
            array('allow',
                'users' => array('@'),
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

    public function actionIndex()
    {
        $this->loadUser();
        $this->pageTitle = 'Семья';

        if ($this->user->partner == null) {
            $partner = new UserPartner();
            $partner->user_id = $this->user->id;
            $partner->save();
            $this->user->partner = $partner;
        }

        $future_babies = array(null, null);
        $i = 0;
        foreach ($this->user->babies as $baby) {
            if (!empty($baby->type)) {
                $future_babies[$i] = $baby;
                $i++;
            }
        }

        Yii::import('application.widgets.user.UserCoreWidget');
        $this->render('index', array('user' => $this->user, 'future_babies' => $future_babies));
    }

    public function actionAddBaby()
    {
        $name = Yii::app()->request->getPost('name');
        $sex = Yii::app()->request->getPost('sex');
        $type = Yii::app()->request->getPost('type');

        $count = Baby::model()->count('parent_id='.Yii::app()->user->id);
        if ($count > 5)
            Yii::app()->end();

        if ($type == 1 || $type == 2) {
            $model = new Baby();
            $model->sex = $sex;
            $model->type = $type;
        } else
            $model = new Baby('realBaby');

        $model->parent_id = Yii::app()->user->id;
        $model->name = $name;

        if ($model->save()) {
            $response = array(
                'status' => true,
                'id' => $model->id,
            );
        } else {
            $response = array(
                'status' => false,
                'error' => $model->getErrors()
            );
        }
        echo CJSON::encode($response);
    }

    public function actionRemoveBaby()
    {
        $ids = Yii::app()->request->getPost('ids');

        foreach ($ids as $id)
            if (!empty($id)) {
                $baby = Baby::model()->findByPk($id);
                if ($baby->parent_id == Yii::app()->user->id) {
                    $baby->delete();
                    $response = array(
                        'status' => true,
                    );
                }
                else {
                    $response = array(
                        'status' => false,
                    );
                }
            }

        echo CJSON::encode($response);
    }

    public function actionUploadPhoto()
    {
        //check limit 4 photo
        $this->user = User::model()->with(array(
            'partner', 'partner.photosCount'
        ))->findByPk(Yii::app()->user->id);
        if ($this->user->partner->photosCount >= 4) {
            Yii::app()->end();
        }

        $photo = new AlbumPhoto;
        $photo->file = CUploadedFile::getInstanceByName('partner-photo');
        $photo->author_id = Yii::app()->user->id;
        if (!$photo->create()) {
            var_dump($photo->getErrors());
            Yii::app()->end();
        }

        $attach = new AttachPhoto;
        $attach->entity = 'UserPartner';
        $attach->entity_id = Yii::app()->user->getModel()->partner->id;
        $attach->photo_id = $photo->id;
        $attach->save();

        if ($attach->save()) {
            $response = array(
                'status' => true,
                'url' => $photo->getPreviewUrl(180, 180),
                'id' => $attach->id
            );
        }
        else {
            $response = array(
                'status' => false,
            );
        }
        echo "<script type='text/javascript'>
                document.domain = document.location.host;
                </script>";

        echo CJSON::encode($response);
    }

    public function actionUploadBabyPhoto()
    {
        if (isset($_POST['baby_id'])) {
            $baby = Baby::model()->with(array('photosCount'))->findByPk($_POST['baby_id']);
            if ($baby->parent_id != Yii::app()->user->id)
                Yii::app()->end();

            //check limit 4 photo
            if ($baby->photosCount >= 4)
                Yii::app()->end();

            $photo = new AlbumPhoto;
            $photo->file = CUploadedFile::getInstanceByName('baby-photo');
            $photo->author_id = Yii::app()->user->id;
            if (!$photo->create())
                Yii::app()->end();

            $attach = new AttachPhoto;
            $attach->entity = 'Baby';
            $attach->entity_id = $baby->id;
            $attach->photo_id = $photo->id;
            $attach->save();

            if ($attach->save()) {
                $response = array(
                    'status' => true,
                    'url' => $photo->getPreviewUrl(180, 180),
                    'id' => $attach->id
                );
            }
            else {
                $response = array(
                    'status' => false,
                );
            }
            echo "<script type='text/javascript'>
                document.domain = document.location.host;
                </script>";

            echo CJSON::encode($response);
        }
    }

    public function actionRemovePhoto()
    {
        $id = Yii::app()->request->getPost('id');
        $attach = AttachPhoto::model()->findByPk($id);
        if ($attach !== null && $attach->photo->author_id == Yii::app()->user->id) {
            if ($attach->delete()) {
                echo CJSON::encode(array('status' => true));
                Yii::app()->end();
            }
        }
        echo CJSON::encode(array('status' => false));
    }

    public function actionRemoveFutureBaby()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('parent_id', Yii::app()->user->id);
        $criteria->compare('type', array(Baby::TYPE_PLANNING, Baby::TYPE_WAIT));
        $response = array(
            'status' => Baby::model()->deleteAll($criteria) > 0,
        );

        echo CJSON::encode($response);
    }

    public function actionRemoveAllBabies()
    {
        $criteria = new CDbCriteria;
        $criteria->condition = 'type IS NULL';
        $criteria->compare('parent_id', Yii::app()->user->id);
        $count = Baby::model()->deleteAll($criteria);
        if ($count > 0) {
            $response = array('status' => true);
        } else
            $response = array('status' => false);

        echo CJSON::encode($response);
    }

    public function actionUpdateWidget(){
        $this->loadUser();
        Yii::import('application.widgets.user.UserCoreWidget');
        $this->widget('application.widgets.user.FamilyWidget', array(
            'user' => $this->user,
        ));
    }

    public function loadUser(){
        $this->user = User::model()->with(array('partner', 'babies'))->findByPk(Yii::app()->user->id);
        if ($this->user === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
    }
}