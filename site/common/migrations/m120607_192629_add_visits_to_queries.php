<?php

class m120607_192629_add_visits_to_queries extends CDbMigration
{
    private $_table = 'queries';

	public function up()
	{
        preg_match('/host=([^;]+);/', Yii::app()->db->connectionString, $matches);
        $host = $matches[1];
        $lnk = mysql_connect($host, Yii::app()->db->username, Yii::app()->db->password)
            or die ('Not connected : ' . mysql_error());

        if (mysql_select_db('happy_giraffe_seo', $lnk)) {
            $this->setDbConnection(Yii::app()->db_seo);

            $this->addColumn($this->_table, 'visits', 'int(10) unsigned not null after phrase');
            $this->addColumn($this->_table, 'page_views', 'int(10) unsigned not null after visits');
            $this->addColumn($this->_table, 'denial', 'float not null after page_views');
            $this->addColumn($this->_table, 'depth', 'float not null after denial');
            $this->addColumn($this->_table, 'visit_time', 'mediumint(8) unsigned NOT NULL after depth');
        }
	}

	public function down()
	{
		echo "m120607_192629_add_visits_to_queries does not support migration down.\n";
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