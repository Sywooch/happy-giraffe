<?php
/**
 * Created by JetBrains PhpStorm.
 * User: solivager
 * Date: 3/28/13
 * Time: 2:00 PM
 * To change this template use File | Settings | File Templates.
 */
class DefaultController extends HController
{
    public function actionIndex()
    {
        $contacts = ContactsManager::getContactsByUserId(Yii::app()->user->id);
        echo CJSON::encode($contacts);
    }
}
