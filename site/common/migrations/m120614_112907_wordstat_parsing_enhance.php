<?php

class m120614_112907_wordstat_parsing_enhance extends CDbMigration
{
    private $_table = 'parsing_keywords';

	public function up()
	{
        preg_match('/host=([^;]+);/', Yii::app()->db->connectionString, $matches);
        $host = $matches[1];
        $lnk = mysql_connect($host, Yii::app()->db->username, Yii::app()->db->password)
            or die ('Not connected : ' . mysql_error());

        if (mysql_select_db('happy_giraffe_seo', $lnk)) {
            $this->setDbConnection(Yii::app()->db_seo);

            $this->addColumn($this->_table, 'depth', 'tinyint default NULL');
            $this->_table = 'keywords';
            $this->addColumn($this->_table, 'our', 'tinyint(1)');
        }
	}

	public function down()
	{
		echo "m120614_112907_wordstat_parsing_enhance does not support migration down.\n";
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