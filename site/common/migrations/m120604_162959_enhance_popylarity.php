<?php

class m120604_162959_enhance_popylarity extends CDbMigration
{
    private $_table = 'yandex_popularity';

    public function up()
    {
        $lnk = mysql_connect('localhost', Yii::app()->db->username, Yii::app()->db->password)
            or die ('Not connected : ' . mysql_error());

        if (mysql_select_db('happy_giraffe_seo', $lnk)) {
            $this->setDbConnection(Yii::app()->db_seo);
            $this->renameTable($this->_table, 'pastuhov_yandex_popularity');

            $this->_table = 'yandex_popularity';
            $this->createTable($this->_table, array(
                'keyword_id' => 'int(11) NOT NULL AUTO_INCREMENT',
                'date' => 'date NOT NULL',
                'value' => 'int(255) NOT NULL',
                'PRIMARY KEY (`keyword_id`)'
            ), 'ENGINE=Innodb DEFAULT CHARSET=utf8');

            $this->addForeignKey('fk_'.$this->_table.'_keyword', $this->_table, 'keyword_id', 'keywords', 'id','CASCADE',"CASCADE");
        }
    }

    public function down()
    {
        echo "m120604_162959_enhance_popylarity does not support migration down.\n";
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