<?php

class m120310_154817_add_community_access extends CDbMigration
{
	public function up()
	{
        $this->execute('
        INSERT INTO auth_item (name, type, description, bizrule, data) VALUES
        (\'isInCommunity\', 0, \'Пользователь входит в сообщество\', \'return $params["user"]->isInCommunity($params["community_id"]);\', NULL),
        (\'createClubPost\', 0, \'Создание постов в сообществах\', NULL, NULL);
        ');

        $this->truncateTable('auth_item_child');

        $this->execute("
        INSERT INTO `auth_item_child` (`parent`, `child`) VALUES
('administrator', 'admin panel access'),
('editor', 'createClubPost'),
('isInCommunity', 'createClubPost'),
('moderator', 'createClubPost'),
('isAuthor', 'editComment'),
('isAuthor', 'editCommunityContent'),
('editor', 'editMeta'),
('user', 'isAuthor'),
('user', 'isInCommunity'),
('administrator', 'moderator'),
('isAuthor', 'removeComment'),
('isAuthor', 'removeCommunityContent'),
('administrator', 'user'),
('moderator', 'user'),
('administrator', 'user access'),
('supermoderator', 'user access'),
('moderator', 'user_signals');
");
	}

	public function down()
	{
		echo "m120310_154817_add_community_access does not support migration down.\n";
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