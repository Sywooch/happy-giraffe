<?php

class m120615_053601_add_parsed_table extends CDbMigration
{
    private $_table = 'parsed_keywords';

    public function up()
    {
        preg_match('/host=([^;]+);/', Yii::app()->db->connectionString, $matches);
        $host = $matches[1];
        $lnk = mysql_connect($host, Yii::app()->db->username, Yii::app()->db->password)
            or die ('Not connected : ' . mysql_error());

        if (mysql_select_db('happy_giraffe_seo', $lnk)) {
            $this->setDbConnection(Yii::app()->db_seo);

            $this->createTable($this->_table, array(
                'keyword_id' => 'int(11) NOT NULL',
                'depth' => 'int',
                'PRIMARY KEY (`keyword_id`)'
            ), 'ENGINE=Innodb DEFAULT CHARSET=utf8');
            $this->addForeignKey('fk_'.$this->_table.'_keyword', $this->_table, 'keyword_id', 'keywords', 'id','CASCADE',"CASCADE");
        }
    }

    public function down()
    {
        echo "m120615_053601_add_parsed_table does not support migration down.\n";
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