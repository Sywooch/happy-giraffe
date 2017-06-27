<?php

namespace site\frontend\modules\specialists\controllers;

use site\frontend\components\HCollection;
use site\frontend\modules\signup\components\UserIdentity;
use site\frontend\modules\som\modules\qa\components\QaManager;
use site\frontend\modules\specialists\components\SpecialistsManager;
use site\frontend\modules\specialists\models\ProfileForm;
use site\frontend\modules\specialists\models\RegisterForm;
use site\frontend\modules\specialists\models\SpecialistProfile;
use site\frontend\modules\specialists\models\SpecialistsCareer;
use site\frontend\modules\specialists\models\SpecialistsEducation;
use site\frontend\modules\specialists\models\SpecialistsUniversities;

/**
 * @author Никита
 * @date 22/08/16
 */
class ApiController extends \site\frontend\components\api\ApiController
{
    /**
     * Получить профиль специалиста
     *
     * @author Sergey Gubarev
     */
    public function actionGetCurrent()
    {
        $form = new ProfileForm();
        $form->initialize(\Yii::app()->user->id);

        $this->data = [
            'profile'   => $form,
            'errors'    => $form->errors
        ];
    }

    public function actionRegister(array $attributes)
    {
        if (\Yii::app()->db instanceof \DbConnectionMan) {
            // Отключим слейвы, чтобы UserIdentity нашла пользователя
            \Yii::app()->db->enableSlave = false;
        }

        $form = new RegisterForm();
        $form->attributes = $attributes;
        $this->success = $form->validate() && $form->save();
        if ($this->success) {
            $identity = new UserIdentity($form->email, $form->password);
            if ($identity->authenticate()) {
                \Yii::app()->user->login($identity);
            }
            $this->data = array(
                'returnUrl' => \Yii::app()->createUrl('/specialists/pediatrician/default/questions'),
            );
        } else {
            $this->data = array(
                'errors' => $form->getErrors(),
            );
        }
    }

    public function actionValidateRegister(array $attributes)
    {
        $form = new RegisterForm();
        $form->attributes = $attributes;
        $form->validate();
        $this->success = true;
        $this->data = array(
            'errors' => $form->getErrors(),
        );
    }

    public function actionUpdateProfile($profileId, array $data)
    {
        $form = new ProfileForm();
        $form->initialize($profileId);
        if (! \Yii::app()->user->checkAccess('editSpecialistProfileData', ['entity' => $form->getProfile()])) {
            throw new \CHttpException(403);
        }
        $form->attributes = $data;
        $this->success = $form->validate() && $form->save();
        $this->data = [
            'form' => $form,
            'errors' => $form->errors,
        ];
    }

    /**
     * Обновить карьеру
     *
     * @param integer   $profileId  ID профиля
     * @param array     $data       Данные
     * @throws \CHttpException
     * @author Sergey Gubarev
     */
    public function actionUpdateCareer($profileId, array $data)
    {
        $form = new ProfileForm();
        $form->initialize($profileId);

        if (! \Yii::app()->user->checkAccess('editSpecialistProfileData', ['entity' => $form->getProfile()]))
        {
            throw new \CHttpException(403);
        }

        if (!count($data))
        {
            throw new \CHttpException(400, 'Data is empty');
        }

        try
        {
            $resp = [];

            foreach ($data as $attrs)
            {
                $attrs['profile_id'] = $profileId;

                $isExists = isset($attrs['id']) && SpecialistsCareer::model()->exists('id = ' . $attrs['id']);

                $model = !$isExists ? new SpecialistsCareer() : SpecialistsCareer::model()->findByPk($attrs['id']);
                $model->setAttributes($attrs);

                if ($model->save())
                {
                    $resp[] = $model->toJSON();
                }
            }

            $this->success  = true;
            $this->data     = [
                'data' => $resp
            ];
        }
        catch (\CDbException $e)
        {
            $this->data     = [
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Обновить образование
     *
     * @param $profileId
     * @param array $data
     * @throws \CHttpException
     */
    public function actionUpdateEducation($profileId, array $data)
    {
        $form = new ProfileForm();
        $form->initialize($profileId);

        if (! \Yii::app()->user->checkAccess('editSpecialistProfileData', ['entity' => $form->getProfile()]))
        {
            throw new \CHttpException(403);
        }

        try
        {
            $resp = [];
            
            foreach ($data as $attrs)
            {
                $attrs['profile_id'] = $profileId;

                $isExists = isset($attrs['id']) && SpecialistsEducation::model()->exists('id = ' . $attrs['id']);

                $model = !$isExists ? new SpecialistsEducation() : SpecialistsEducation::model()->findByPk($attrs['id']);
                $model->setAttributes($attrs);

                if ($model->save())
                {
                    $resp[] = $model->toJSON();
                }
            }

            $this->success  = true;
            $this->data     = $resp;
        }
        catch (\CDbException $e)
        {
            $this->data     = [
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Удалить место работы
     *
     * @param $profileId    ID профиля
     * @param $id           ID записи
     * @throws \CHttpException
     * @author Sergey Gubarev
     */
    public function actionRemoveCareer($profileId, $id)
    {
        $form = new ProfileForm();
        $form->initialize($profileId);

        if (! \Yii::app()->user->checkAccess('editSpecialistProfileData', ['entity' => $form->getProfile()]))
        {
            throw new \CHttpException(403);
        }

        try
        {
            SpecialistsCareer::model()->deleteByPk($id);

            $this->success = true;
        }
        catch (\CDbException $e)
        {
            $this->data = [
                'error' => $e->getMessage()
            ];
        }
    }

    public function actionRemoveEducation($profileId, $id)
    {
        $form = new ProfileForm();
        $form->initialize($profileId);

        if (! \Yii::app()->user->checkAccess('editSpecialistProfileData', ['entity' => $form->getProfile()]))
        {
            throw new \CHttpException(403);
        }

        try
        {
            SpecialistsEducation::model()->deleteByPk($id);

            $this->success = true;
        }
        catch (\CDbException $e)
        {
            $this->data = [
                'error' => $e->getMessage()
            ];
        }
    }

    /**
     * Получить список мед. учереждений
     *
     * @return array
     * @author Sergey Gubarev
     */
    public function actionGetUniversities()
    {
        $arr = (new HCollection(SpecialistsUniversities::model()->findAll()))->toArray();

        $this->success  = true;
        $this->data     = $arr;
    }
    
    /**
     * Отправить почту - ВУЗ не найден
     *
     * @param string $name Название ВУЗа
     * @author Sergey Gubarev
     */
    public function actionSendUniversityEmail($name)
    {
        $to         = 'info@happy-giraffe.ru';
        $subject    = 'Не нашли Ваш ВУЗ?';
        $message    = strip_tags($name);

        $this->success = mail($to, $subject, $message);
    }
    
    public function actionValidate(array $data)
    {
        $form = new ProfileForm();
        $form->attributes = $data;
        $form->validate();
        $this->success = true;
        $this->data = array(
            'errors' => $form->getErrors(),
        );
    }

    public function actionMakeSpecialist($userId = null, array $specializations = [])
    {
        if ($userId === null) {
            $userId = \Yii::app()->user->id;
        }

        $this->success = SpecialistsManager::makeSpecialist($userId, $specializations);
    }

    // @todo Sergey Gubarev: убрать
    public function actionGetAnswers($questionId)
    {
        $answersData = QaManager::getAnswersByQuestion($questionId);

        $this->success  = true;
        $this->data     = [
            'answers' => $answersData
        ];
    }
}