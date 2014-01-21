<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MessagingMessageForm
 *
 * @author Кирилл
 */
class MessagingMessageForm extends CFormModel
{

	public $messageId;
	public $fromUser;
	public $toUser;
	public $message;

	public function send()
	{
		$this->validate('newMessage');
		$this->messageModel->save();
		$comet = new CometModel();
		$comet->send($interlocutorId, $receiverData, CometModel::MESSAGING_MESSAGE_RECEIVED);
	}

	public function edit()
	{
		$this->validate('editMessage');
		$this->messageModel->save();
	}

	public function delete()
	{
		$this->validate('deleteMessage');
		$this->messageModel->save();
	}

	public function restore()
	{
		$this->validate('restoreMessage');
		$this->messageModel->save();
	}
	
	public function cancel()
	{
		$this->validate('cancelMessage');
		$this->messageModel->save();
	}

}

?>
