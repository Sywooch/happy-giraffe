<?php

class DefaultController extends HController
{
    public function filters()
    {
        return array(
            'accessControl',
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
        $allCount = Im::getContactsCount(Yii::app()->user->id, Im::IM_CONTACTS_ALL);
        $newCount = Im::getContactsCount(Yii::app()->user->id, Im::IM_CONTACTS_NEW);
        $onlineCount = Im::getContactsCount(Yii::app()->user->id, Im::IM_CONTACTS_ONLINE);
        $friendsCount = Im::getContactsCount(Yii::app()->user->id, Im::IM_CONTACTS_FRIENDS);
        $wantToChat = WantToChat::getList(12);
        $hasMessages = Im::hasMessages(Yii::app()->user->id);
        $response = array(
            'html' => $this->renderPartial('index', compact('allCount', 'newCount', 'onlineCount', 'friendsCount', 'wantToChat', 'hasMessages'), true),
            'hasMessages' => $hasMessages,
        );

        echo CJSON::encode($response);
    }

    public function actionContacts($type = Im::IM_CONTACTS_ALL)
    {
        $contacts = Im::getContacts(Yii::app()->user->id, $type);
        echo $this->renderPartial('contacts', compact('contacts'));
    }

    public function actionDialog($interlocutor_id)
    {
        $contact = Im::getContact(Yii::app()->user->id, $interlocutor_id);
        $html = $this->renderPartial('_dialog', compact('contact', 'interlocutor_id'), true);
        $contactHtml = $this->renderPartial('_contact', compact('contact'), true);
        $response = array(
            'html' => $html,
            'contactHtml' => $contactHtml,
            'dialogid' => $contact->userDialog ? $contact->userDialog->dialog->id : 'undefined',
        );

        if ($contact->userDialog) {
            $contact->userDialog->dialog->markAsReadFrom($interlocutor_id);
        }

        echo CJSON::encode($response);
    }

    public function actionEmpty()
    {
        $wantToChat = WantToChat::getList(3);
        $friends = Yii::app()->user->model->getFriendsModels(array(
            'condition' => 'online = 1',
            'limit' => 6,
        ));

        $this->renderPartial('empty', compact('wantToChat', 'friends'));
    }

    /**
     * @todo заменить на withrelated
     */
    public function actionMessage()
    {
        $interlocutor_id = Yii::app()->request->getPost('interlocutor_id');
        $text = Yii::app()->request->getPost('text');

        $dialog_id = Im::getDialogId(Yii::app()->user->id, $interlocutor_id);
        if ($dialog_id === false) {
            $dialog = new Dialog;
            $dialog->save();
            $ud1 = new DialogUser;
            $ud1->dialog_id = $dialog->id;
            $ud1->user_id = Yii::app()->user->id;
            $ud2 = new DialogUser;
            $ud2->dialog_id = $dialog->id;
            $ud2->user_id = $interlocutor_id;
            $ud1->save();
            $ud2->save();
        } else {
            $dialog = Dialog::model()->findByPk($dialog_id);
        }

        $message = new Message;
        $message->text = $text;
        $message->dialog_id = $dialog->id;
        $message->user_id = Yii::app()->user->id;
        if ($message->save()) {
            $message->created = date("Y-m-d H:i:s");
            $html = $this->renderPartial('_message',compact('message'), true);
            $contact = Im::getContact($interlocutor_id, Yii::app()->user->id);
            $contactHtml = $this->renderPartial('_contact', compact('contact'), true);

            $comet = new CometModel;
            $comet->type = CometModel::TYPE_NEW_MESSAGE;
            $comet->attributes = array(
                'html' => $html,
                'contactHtml' => $contactHtml,
                'from' => Yii::app()->user->id,
            );
            $comet->send($interlocutor_id);

            $response = array(
                'status' => true,
                'html' => $html,
                'message_id' => $message->id,
            );
        } else {
            $response = array(
                'status' => false,
            );
        }

        echo CJSON::encode($response);
    }

    public function actionMarkAsRead()
    {
        $interlocutor_id = Yii::app()->request->getPost('interlocutor_id');
        $dialog_id = Yii::app()->request->getPost('dialog_id');

        $dialog = Dialog::model()->findByPk($dialog_id);
        $dialog->markAsReadFrom($interlocutor_id);
    }

    // test

    public function actionChangeStatus($id)
    {
        $user = User::getUserById($id);
        $user->online = ! $user->online;
        $user->save(false, array('online'));
    }

    public function actionTest()
    {
        $onlineCount = Im::getContactsCount(Yii::app()->user->id, Im::IM_CONTACTS_NEW);
        echo $onlineCount;
    }
}