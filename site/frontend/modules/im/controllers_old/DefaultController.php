<?php

class DefaultController extends HController
{
    public function filters()
    {
        return array(
            'accessControl',
            'ajaxDialog,SetRead,CreateMessage,MoreMessages,RemoveMessage,RemoveActiveDialog,
            RemoveDialog,UserTyping,OpenedDialog + ajaxOnly'
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

    public $layout = 'im';

    public function actionIndex()
    {
        $this->pageTitle = 'Диалоги';
        $dialogs = Dialog::GetUserDialogs();

        $this->render('index', array(
            'dialogs' => $dialogs
        ));
    }

    public function actionNew()
    {
        $this->pageTitle = 'Новые Сообщения';
        $dialogs = Dialog::GetUserNewDialogs();

        $this->render('index', array(
            'dialogs' => $dialogs
        ));
    }

    public function actionOnline()
    {
        $this->pageTitle = 'Кто онлайн';
        $dialogs = Dialog::GetUserOnlineDialogs();

        $this->render('index', array(
            'dialogs' => $dialogs
        ));
    }

    public function actionDialog($id)
    {
        $this->pageTitle = 'Просмотр диалогов';
        $this->loadModel($id);
        ActiveDialogs::model()->addDialog($id);
        ActiveDialogs::model()->SetLastDialogId($id);
        $messages = Message::GetLastMessages($id);

        $this->render('dialog', array(
            'messages' => $messages,
            'id' => $id
        ));
    }

    public function actionAjaxDialog()
    {
        $id = Yii::app()->request->getPost('id');
        $this->loadModel($id);
        $messages = Message::GetLastMessages($id);
        $response = array(
            'status' => true,
            'html' => $this->renderPartial('_dialog_content', array(
                'messages' => $messages,
                'id' => $id
            ), true)
        );

        echo CJSON::encode($response);
        ActiveDialogs::model()->SetLastDialogId($id);
    }

    public function actionCreate($id)
    {
        if ($id == Yii::app()->user->id)
            throw new CHttpException(404, 'Вы не можете создать диалог с собой.');

        $user = User::getUserById($id);

        //find if dialog with this user exist
        $dialog_id = Im::model()->getDialogIdByUser($id);
        if (empty($dialog_id)) {
            $dialog = new Dialog;
            $dialog->title = $user->getFullName();
            if (!$dialog->save())
                throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

            $um = new DialogUser;
            $um->dialog_id = $dialog->id;
            $um->user_id = $id;
            if (!$um->save())
                throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

            $um = new DialogUser;
            $um->dialog_id = $dialog->id;
            $um->user_id = Yii::app()->user->id;
            if (!$um->save())
                throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

            $dialog_id = $dialog->id;
        }
        $this->redirect($this->createUrl('/im/default/dialog', array('id' => $dialog_id)));
    }

    public function actionSetRead()
    {
        $dialog = Yii::app()->request->getPost('dialog');
        $last_message_id = Yii::app()->request->getPost('id');
        Dialog::SetRead($dialog, $last_message_id);
    }

    public function actionCreateMessage()
    {
        $dialog = Yii::app()->request->getPost('dialog');
        $text = Yii::app()->request->getPost('text');
        $message = Message::NewMessage($dialog, Yii::app()->user->getId(), $text);

        $response = array(
            'id' => $message->id,
            'status' => true,
            'html' => $this->renderPartial('_message', array('message' => $message->attributes, 'read' => 0), true)
        );
        echo CJSON::encode($response);
    }

    public function actionMoreMessages()
    {
        $dialog_id = Yii::app()->request->getPost('dialog_id');
        $id = Yii::app()->request->getPost('id');
        $messages = Message::GetMessagesBefore($dialog_id, $id);

        if (!empty($messages))
            $response = array(
                'status' => true,
                'count' => count($messages),
                'html' => $this->renderPartial('_messages', array('messages' => $messages, 'read' => true), true)
            );
        else $response = array('status' => false);

        echo CJSON::encode($response);
    }

    public function actionAjaxSearchByName($term)
    {
        echo CJSON::encode(Im::model()->findDialogUserNames($term));
    }

    public function actionGetDialog($dialog_name)
    {
        $id = Im::model()->findDialog($dialog_name);
        if (empty($id))
            throw new CHttpException(404, 'Диалог не найден.');
        else
            $this->redirect($this->createUrl('dialog', array('id' => $id)));
    }

    public function actionRemoveMessage()
    {
        Message::removeMessage(Yii::app()->request->getPost('id'));
    }

    public function actionRemoveActiveDialog()
    {
        $id = Yii::app()->request->getPost('id');
        if (ActiveDialogs::model()->deleteDialog($id)) {
            $response = array(
                'status' => true,
            );
        } else {
            $response = array(
                'status' => false,
            );
        }

        echo CJSON::encode($response);
    }

    public function actionRemoveDialog()
    {
        $id = Yii::app()->request->getPost('id');
        $dialog = $this->loadModel($id);

        if ($dialog->deleteDialog()) {
            //change active url when some dialog removed
            $last_dialog = ActiveDialogs::model()->GetLastDialogId();
            if (empty($last_dialog))
                $url = '';
            else
                $url = $this->createUrl('/im/default/dialog', array('id' => ActiveDialogs::model()->GetLastDialogId()));

            $response = array(
                'status' => true,
                'active_dialog_url' => $url
            );
        } else {
            $response = array(
                'status' => false,
            );
        }

        echo CJSON::encode($response);
    }

    public function actionUserTyping()
    {
        $dialog_id = Yii::app()->request->getPost('dialog_id');
        $user_to = Im::model()->GetDialogUser($dialog_id);

        $comet = new CometModel();
        $comet->type = CometModel::TYPE_USER_TYPING;
        $comet->attributes = array('dialog_id' => $dialog_id);
        $comet->send($user_to->id);
    }

    public function actionOpenedDialog()
    {
        $dialog_id = Yii::app()->request->getPost('id');
        $this->loadModel($dialog_id);
        ActiveDialogs::model()->addDialog($dialog_id);

        $response = array(
            'status' => true,
            'html' => $this->renderPartial('_dialog_preview', array(
                'dialog'=>Im::model()->getDialog($dialog_id),
                'current_dialog_id'=>0
            ), true)
        );

        echo CJSON::encode($response);
    }

    /**
     * @param int $id model id
     * @return Dialog
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = Dialog::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        foreach($model->dialogUsers as $dialogUser)
            if ($dialogUser->user_id == Yii::app()->user->id)
                return $model;

        throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
    }

    public function actionTest()
    {
        $contacts = User::model()->findAll(Im::model()->getUserContactsCriteria(Yii::app()->user->id, IM::IM_CONTACTS_ALL));
        foreach ($contacts as $c)
            echo $c->id . '<br />';
    }
}