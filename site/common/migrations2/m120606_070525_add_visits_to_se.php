<?php

class m120606_070525_add_visits_to_se extends CDbMigration
{
    private $_table = 'query_search_engines';
	public function up()
	{
        $lnk = mysql_connect('localhost', Yii::app()->db->username, Yii::app()->db->password)
            or die ('Not connected : ' . mysql_error());

        if (mysql_select_db('happy_giraffe_seo', $lnk)) {
            $this->setDbConnection(Yii::app()->db_seo);
            $this->addColumn($this->_table, 'visits', 'int(11) not null default 0');
        }
	}

	public function down()
	{
		echo "m120606_070525_add_visits_to_se does not support migration down.\n";
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