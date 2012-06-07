<?php

class m120607_062031_parsing_session_fix extends CDbMigration
{
    private $_table = 'query_search_engines';

    public function up()
    {
        $lnk = mysql_connect('localhost', Yii::app()->db->username, Yii::app()->db->password)
            or die ('Not connected : ' . mysql_error());

        if (mysql_select_db('happy_giraffe_seo', $lnk)) {
            $this->setDbConnection(Yii::app()->db_seo);

            $this->renameTable('parsing_session', 'parsing_sessions');
            $this->addForeignKey('fk_' . $this->_table . '_session', $this->_table, 'session_id', 'parsing_sessions', 'id', 'CASCADE', "CASCADE");

        }
    }

    public function down()
    {
        echo "m120607_062031_parsing_session_fix does not support migration down.\n";
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