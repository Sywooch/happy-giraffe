<?php

class m120330_124618_add_happy_giraffe extends CDbMigration
{
	public function up()
	{
        $this->execute("
        SET FOREIGN_KEY_CHECKS = 0;
        DELETE FROM user WHERE id=1;
        INSERT INTO user (id, external_id, vk_id, nick, email, phone, password, first_name, last_name, pic_small,
        avatar, link, gender, birthday, country_id, settlement_id, street_id, house, mail_id, last_active, online,
        deleted, blocked, register_date, login_date, last_ip, relationship_status, mood_id, profile_access,
        guestbook_access, im_access, room)
        VALUES
        (1, '', '', '', '', '', '', 'Веселый жираф', '', '', NULL, '', '1', NULL, NULL, NULL, NULL,
        NULL, NULL, NULL, '1', '0', '0', '2012-01-01 00:00:00', '2012-01-01 00:00:00', NULL, NULL, NULL,
        'all', 'all', 'all', NULL);
        SET FOREIGN_KEY_CHECKS = 1;
        ");
	}

	public function down()
	{

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