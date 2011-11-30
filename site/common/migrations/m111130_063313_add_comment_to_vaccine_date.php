<?php

class m111130_063313_add_comment_to_vaccine_date extends CDbMigration
{
    private $_table = 'vaccine_date';
	public function up()
	{
        $this->addColumn($this->_table, 'comment', 'varchar(256)');
        $this->truncateTable($this->_table);
        $this->execute("INSERT INTO `vaccine_date` (`id`, `vaccine_id`, `time_from`, `time_to`, `adult`, `interval`, `every_period`, `age_text`, `vaccination_type`, `vote_decline`, `vote_agree`, `vote_did`, `comment`) VALUES
        (1, 1, '0', '', 0, 1, NULL, 'В течение <b>24</b> часов с момента рождения', 3, 1202, 2401, 5404, NULL),
        (3, 2, '3', '7', 0, 2, NULL, '', 1, 4, 7, 4, NULL),
        (4, 1, '1', '', 0, 3, NULL, '', 4, 2, 1, 1, 'дети из групп риска'),
        (5, 2, '3', '', 0, 3, NULL, '', 4, 1, 0, 2, NULL),
        (7, 2, '4,5', '', 0, 3, NULL, '', 4, 0, 1, 0, NULL),
        (9, 2, '6', '', 0, 3, NULL, '', 5, 2, 0, 0, NULL),
        (10, 2, '12', '', 0, 3, NULL, '', 6, 0, 0, 0, 'дети из групп риска'),
        (11, 2, '18', '', 0, 3, NULL, '', 8, 0, 0, 0, NULL),
        (12, 2, '20', '', 0, 3, NULL, '', 9, 0, 0, 0, NULL),
        (13, 2, '6', '', 0, 4, NULL, '', 2, 0, 0, 0, NULL),
        (14, 2, '7', '', 0, 4, NULL, '', 9, 0, 0, 0, NULL),
        (15, 2, '14', '', 0, 4, NULL, '', 10, 0, 2, 0, NULL),
        (17, 2, '18', '', 1, 4, 10, 'ревакцинация каждые 10 лет от момента последней ревакцинации', 2, 0, 1, 0, NULL),
        (18, 1, '2', '', 0, 3, NULL, '', 5, 0, 1, 0, 'дети из групп риска'),
        (19, 1, '3', '', 0, 3, NULL, '', 3, 0, 0, 0, NULL),
        (20, 1, '12', '', 0, 3, NULL, '', 1, 0, 0, 0, ''),
        (21, 2, '7', '', 0, 4, NULL, '', 2, 0, 0, 0, NULL),
        (22, 2, '14', '', 0, 4, NULL, '', 2, 0, 0, 0, NULL),
        (23, 2, '14', '', 0, 4, NULL, '', 10, 0, 0, 0, NULL);");
	}

	public function down()
	{
		$this->dropColumn($this->_table,'comment');
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