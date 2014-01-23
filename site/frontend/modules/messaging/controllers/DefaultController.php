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

    public $layout = '//layouts/new/main';
    public $tempLayout = true;
    public $showAddBlock = false;

    public function filters()
    {
        return array(
            'accessControl',
            //'ajaxOnly - index',
        );
    }

    public function accessRules()
    {
        return array(
            array('deny',
                'users' => array('?'),
            ),
        );
    }

    public function actionIndex($interlocutorId = null)
    {
		$model = new DialogForm($interlocutorId);
		//$this->renderText(CHtml::tag('pre', array(), var_export($model->toJSON(), true)));
        $this->pageTitle = 'Мои диалоги';
        $this->render('index_v2', array('data' => CJSON::encode($model->toJSON())));
    }

    public function actionGetContacts($type, $offset = 0)
    {
        $contacts = ContactsManager::getContactsByUserId(Yii::app()->user->id, $type, DialogForm::CONTACTS_PER_PAGE, $offset);
        $data = compact('contacts');
        echo CJSON::encode($data);
    }
	
	public function actionGetUserInfo($id)
	{
		echo CJSON::encode(ContactsManager::getContactByUserId(Yii::app()->user->id, $id));
	}

    public function actionWysiwyg()
    {
        $this->render('wysiwyg');
    }
}
