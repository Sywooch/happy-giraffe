<?php

class m120417_110433_rename_contest_columns extends CDbMigration
{
    private $_table = '';
	public function up()
	{
        $this->dropForeignKey('fk_club_contest_work_contest', 'contest__works');
        $this->dropForeignKey('club_contest_user_fk', 'contest__contests');
        $this->dropForeignKey('club_contest_prize_item_fk', 'contest__prizes');
        $this->dropForeignKey('club_contest_prize_contest_fk', 'contest__prizes');

        $this->renameColumn('contest__contests', 'contest_id', 'id');
        $this->renameColumn('contest__contests', 'contest_title', 'title');
        $this->renameColumn('contest__contests', 'contest_text', 'text');
        $this->renameColumn('contest__contests', 'contest_image', 'image');
        $this->renameColumn('contest__contests', 'contest_from_time', 'from_time');
        $this->renameColumn('contest__contests', 'contest_till_time', 'till_time');
        $this->renameColumn('contest__contests', 'contest_status', 'status');
        $this->renameColumn('contest__contests', 'contest_time', 'time');
        $this->renameColumn('contest__contests', 'contest_user_id', 'user_id');
        $this->renameColumn('contest__contests', 'contest_stop_reason', 'stop_reason');

        $this->renameColumn('contest__prizes', 'prize_id', 'id');
        $this->renameColumn('contest__prizes', 'prize_contest_id', 'contest_id');
        $this->renameColumn('contest__prizes', 'prize_place', 'place');
        $this->renameColumn('contest__prizes', 'prize_item_id', 'item_id');
        $this->renameColumn('contest__prizes', 'prize_text', 'text');

        $this->_table = 'contest__contests';
        $this->addForeignKey('fk_'.$this->_table.'_user', $this->_table, 'user_id', 'users', 'id','CASCADE',"CASCADE");
        $this->_table = 'contest__works';
        $this->addForeignKey('fk_'.$this->_table.'_contest', $this->_table, 'contest_id', 'contest__contests', 'id','CASCADE',"CASCADE");

        $this->_table = 'contest__prizes';
        $this->addForeignKey('fk_'.$this->_table.'_contest', $this->_table, 'contest_id', 'contest__contests', 'id','CASCADE',"CASCADE");
        $this->addForeignKey('fk_'.$this->_table.'_item', $this->_table, 'item_id', 'shop__product', 'product_id','CASCADE',"CASCADE");
	}

	public function down()
	{
		echo "m120417_110433_rename_contest_columns does not support migration down.\n";
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