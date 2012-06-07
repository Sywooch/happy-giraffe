<?php

class m120607_054340_metrika_date_stats extends CDbMigration
{
    private $_table = 'query_visits';

    public function up()
    {
        $lnk = mysql_connect('localhost', Yii::app()->db->username, Yii::app()->db->password)
            or die ('Not connected : ' . mysql_error());

        if (mysql_select_db('happy_giraffe_seo', $lnk)) {
            $this->setDbConnection(Yii::app()->db_seo);


            $this->createTable($this->_table, array(
                'query_id' => 'int(10) unsigned NOT NULL',
                'date' => 'date NOT NULL',
                'visits' => 'int(10) unsigned NOT NULL',
                'page_views' => 'int(10) unsigned NOT NULL',
                'denial' => 'float UNSIGNED NOT NULL',
                'depth' => 'float UNSIGNED NOT NULL',
                'visit_time' => 'int(10) UNSIGNED NOT NULL',
                'PRIMARY KEY (`query_id`, `date`)'
            ), 'ENGINE=Innodb DEFAULT CHARSET=utf8');

            $this->addForeignKey('fk_'.$this->_table.'_query', $this->_table, 'query_id', 'queries', 'id','CASCADE',"CASCADE");

            $this->_table = 'queries';
            $this->dropColumn($this->_table,'visits');
            $this->dropColumn($this->_table,'page_views');
            $this->dropColumn($this->_table,'denial');
            $this->dropColumn($this->_table,'depth');
            $this->dropColumn($this->_table,'visit_time');

            $this->_table = 'query_search_engines';
            $this->addColumn($this->_table, 'session_id', 'int(10) UNSIGNED NOT NULL after query_id');
        }
    }

    public function down()
    {
        echo "m120607_054340_metrika_date_stats does not support migration down.\n";
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