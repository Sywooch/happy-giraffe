<?php

class DefaultController extends Controller
{
    public function filters()
    {
        return array(
            'accessControl', // perform access control for CRUD operations
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
        Im::clearCache();
        $dialogs = MessageDialog::GetUserDialogs();
        $this->render('index', array(
            'dialogs' => $dialogs
        ));
    }

    public function actionNew()
    {
        $dialogs = MessageDialog::GetUserNewDialogs();
        $this->render('index', array(
            'dialogs' => $dialogs
        ));
    }

    public function actionOnline()
    {
        $dialogs = MessageDialog::GetUserOnlineDialogs();
        $this->render('index', array(
            'dialogs' => $dialogs
        ));
    }

    public function actionDialog($id)
    {
        $this->checkDialog($id);
        ActiveDialogs::model()->addDialog($id);
        ActiveDialogs::model()->SetLastDialogId($id);
        $messages = MessageLog::GetLastMessages($id);
        $this->render('dialog', array(
            'messages' => $messages,
            'id' => $id
        ));
    }

    public function actionAjaxDialog()
    {
        $id = Yii::app()->request->getPost('id');
        $this->checkDialog($id);
        $messages = MessageLog::GetLastMessages($id);
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
        if ($id == Yii::app()->user->getId())
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        $user = User::getUserById($id);
        //find if dialog with this user exist
        $dialog_id = Im::model()->getDialogByUser($id);
        if (empty($dialog_id)) {
            $dialog = new MessageDialog;
            $dialog->title = $user->getFullName();
            if (!$dialog->save())
                throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

            $um = new MessageUser;
            $um->dialog_id = $dialog->id;
            $um->user_id = $id;
            if (!$um->save())
                throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

            $um = new MessageUser;
            $um->dialog_id = $dialog->id;
            $um->user_id = Yii::app()->user->getId();
            if (!$um->save())
                throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

            Im::clearCache();
            $dialog_id = $dialog->id;
        }
        $this->redirect($this->createUrl('/im/default/dialog', array('id' => $dialog_id)));
    }

    public function actionSetRead()
    {
        $dialog = Yii::app()->request->getPost('dialog');
        $last_message_id = Yii::app()->request->getPost('id');
        MessageDialog::SetRead($dialog, $last_message_id);
    }

    public function actionCreateMessage()
    {
        $dialog = Yii::app()->request->getPost('dialog');
        $text = Yii::app()->request->getPost('text');
        $message = MessageLog::NewMessage($dialog, Yii::app()->user->getId(), $text);

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
        $messages = MessageLog::GetMessagesBefore($dialog_id, $id);

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
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        else
            $this->redirect($this->createUrl('dialog', array('id' => $id)));
    }

    public function actionRemoveMessage()
    {
        MessageLog::removeMessage(Yii::app()->request->getPost('id'));
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
        Yii::app()->comet->send(MessageCache::GetUserCache($user_to->id), array(
            'type' => MessageLog::TYPE_USER_WRITE,
            'dialog_id' => $dialog_id
        ));
    }

    /**
     * @param int $id model id
     * @throws CHttpException
     */
    public function checkDialog($id)
    {
        $dialog = Yii::app()->db->createCommand()
            ->select('id')
            ->from('message_dialog')
            ->where('id=:id', array(
            ':id' => $id,
        ))
            ->queryScalar();
        if ($dialog === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
    }

    /**
     * @param int $id model id
     * @return MessageDialog
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = MessageDialog::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return $model;
    }
}