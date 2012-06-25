<?php

class m120615_124734_add_seo_migrations_table extends CDbMigration
{
	public function up()
	{
        preg_match('/host=([^;]+);/', Yii::app()->db->connectionString, $matches);
        $host = $matches[1];
        $lnk = mysql_connect($host, Yii::app()->db->username, Yii::app()->db->password)
            or die ('Not connected : ' . mysql_error());

        if (mysql_select_db('happy_giraffe_seo', $lnk)) {
            $this->setDbConnection(Yii::app()->db_seo);

            $this->execute('CREATE TABLE IF NOT EXISTS tbl_migration (
              version varchar(255) NOT NULL,
              apply_time int(11) DEFAULT NULL,
              PRIMARY KEY (version)
            ) ENGINE=MyISAM DEFAULT CHARSET=utf8 AVG_ROW_LENGTH=42;');
        }
	}

	public function down()
	{
		echo "m120615_124734_add_seo_migrations_table does not support migration down.\n";
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