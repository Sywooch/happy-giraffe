<?php
/**
 * Author: alexk984
 * Date: 10.01.13
 */
class HEmailSender extends CApplicationComponent
{
    const LIST_OUR_USERS = 'our_users';
    const LIST_MAILRU_USERS = 'mailru_users';
    const LIST_TEST_LIST = 'test_list';

    public $subjects = array(
        'newMessages' => 'Вам пришли сообщения - Весёлый Жираф',
        'passwordRecovery' => 'Напоминание пароля - Весёлый Жираф',
        'confirmEmail' => 'Подтверждение e-mail - Весёлый Жираф',
        'resendConfirmEmail' => 'Подтверждение e-mail - Весёлый Жираф',
    );

    public function send($user, $action, $params = array(), $controller = null)
    {
        if (is_int($user))
            $user = User::model()->findByPk($user);
        if (is_string($user))
            $user = User::model()->findByAttributes(array('email' => $user));
        if ($user === null)
            return false;

        if ($controller === null)
            $controller = Yii::app()->controller;

        $params['user'] = $user;
        $html = $controller->renderFile(Yii::getPathOfAlias('site.common.tpl') . DIRECTORY_SEPARATOR . $action . '.php', $params, true);

        return ElasticEmail::send($user->email, $this->subjects[$action], $html, 'noreply@happy-giraffe.ru', 'Весёлый Жираф');
    }

    public function sendCampaign($body, $list)
    {
        ElasticEmail::sendCampaign($body, $list);
    }

    /**
     * Add contact to list
     *
     * @param $email
     * @param $first_name
     * @param $last_name
     * @param $list
     */
    public function addContact($email, $first_name, $last_name, $list)
    {
        ElasticEmail::addContact($email, $first_name, $last_name, $list);
    }

    /**
     * Update users list
     */
    public static function updateUserList()
    {
        Yii::import('site.seo.models.mongo.*');
        $last_id = SeoUserAttributes::getAttribute('import_email_last_user_id', 1);
        echo 'last_id: ' . $last_id . "\n";

        $criteria = new CDbCriteria;
        $criteria->with = array('mail_subs');
        $criteria->condition = '(t.group < 5 AND t.group > 0 OR t.group = 6) OR (t.group = 0 AND t.register_date >= "2012-05-01 00:00:00")';
        $criteria->scopes = array('active');
        $criteria->limit = 100;
        $criteria->condition = 'id > ' . $last_id;
        $criteria->offset = 0;

        $models = array(0);
        while (!empty($models)) {
            $models = User::model()->findAll($criteria);

            foreach ($models as $model) {
                Yii::app()->email->addContact($model->email, $model->first_name, $model->last_name, HEmailSender::LIST_OUR_USERS);
                SeoUserAttributes::setAttribute('import_email_last_user_id', $model->id, 1);
            }

            $criteria->offset += 100;
        }
    }

    public static function updateMailruUsers()
    {
        $emails = Yii::app()->db->createCommand()
                    ->select('email')
                    ->from('users')
                    ->queryColumn();

        Yii::import('site.seo.models.mongo.*');
        $last_id = 0;
        echo 'last_id: ' . $last_id . "\n";

        $criteria = new CDbCriteria;
        //$criteria->limit = 30000;
        $criteria->condition = 'id > ' . $last_id . ' AND status = 1';
        $criteria->offset = 0;

        $models = array(0);

        $i = 0;
//        while (!empty($models)) {
            $models = MailruUser::model()->findAll($criteria);

            $fp = fopen('file_'.$i.'.csv', 'w');
            fputcsv($fp, array('Email Address', 'First Name', 'Last Name'));

            foreach ($models as $model) {
                if (!in_array($model->email, $emails)) {
                    fputcsv($fp, array($model->email, $model->name, ' '));
//                    Yii::app()->email->addContact($model->email, $model->name, '', HEmailSender::LIST_MAILRU_USERS);
                }
//                SeoUserAttributes::setAttribute('import_email_contest_last_user_id', $model->id, 1);
            }
            fclose($fp);

//            $i++;
//            $criteria->offset += 30000;
//        }

    }
}
