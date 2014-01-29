<?php

Yii::import('site.frontend.modules.friends.models.*');
Yii::import('site.frontend.modules.messaging.models.*');

class m140129_073710_friends_threads extends CDbMigration
{
	public function up()
	{
        $this->execute("DELETE f.*
FROM friends f
LEFT OUTER JOIN users u1 ON u1.id = f.user_id
LEFT OUTER JOIN users u2 ON u2.id = f.friend_id
WHERE u1.id IS NULL OR u2.id IS NULL;");

        $this->execute("ALTER TABLE `friends` ADD FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;");
        $this->execute("ALTER TABLE `friends` ADD FOREIGN KEY (`friend_id`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;");

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