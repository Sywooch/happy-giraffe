<?php

Yii::import('site.frontend.modules.friends.models.*');
Yii::import('site.frontend.modules.messaging.models.*');

class m140129_073710_friends_threads extends CDbMigration
{
	public function up()
	{
        $dp = new CActiveDataProvider('Friend');
        $iterator = new CDataProviderIterator($dp, 1000);
        foreach ($iterator as $model)
            MessagingThread::model()->findOrCreate($model->user_id, $model->friend_id);
	}

	public function down()
	{
		echo "m140129_073710_friends_threads does not support migration down.\n";
		return false;
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}