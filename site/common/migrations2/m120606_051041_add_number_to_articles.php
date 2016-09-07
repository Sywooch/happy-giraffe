<?php

class m120606_051041_add_number_to_articles extends CDbMigration
{
    private $_table = 'article_keywords';

	public function up()
	{
        $lnk = mysql_connect('localhost', Yii::app()->db->username, Yii::app()->db->password)
            or die ('Not connected : ' . mysql_error());

        if (mysql_select_db('happy_giraffe_seo', $lnk)) {
            $this->setDbConnection(Yii::app()->db_seo);
            $this->addColumn($this->_table, 'number', 'int(10)');

            $ids = Yii::app()->db_seo->createCommand('select id from article_keywords ORDER BY id ASC')->queryColumn();
            for($i=0;$i<count($ids);$i++){
                Yii::app()->db_seo->createCommand()->update($this->_table, array('number'=>$i+1), 'id='.$ids[$i]);
            }
        }
	}

	public function down()
	{
        $lnk = mysql_connect('localhost', Yii::app()->db->username, Yii::app()->db->password)
            or die ('Not connected : ' . mysql_error());

        if (mysql_select_db('happy_giraffe_seo', $lnk)) {
            $this->setDbConnection(Yii::app()->db_seo);
            $this->dropColumn($this->_table, 'number');
        }
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