<?php

class m120425_064810_community_content_author_fix extends CDbMigration
{
    private $_table = 'community__contents';

	public function up()
	{
        $fk = 'SELECT `CONSTRAINT_NAME`
              FROM `information_schema`.`REFERENTIAL_CONSTRAINTS`
              WHERE `TABLE_NAME` = "community__contents" AND `REFERENCED_TABLE_NAME` = "users" AND CONSTRAINT_SCHEMA = "happy_giraffe"';
        $fk = Yii::app()->db->createCommand($fk)->queryScalar();
        $this->dropForeignKey($fk, $this->_table);

        $this->addForeignKey('fk_'.$this->_table.'_author', $this->_table, 'author_id', 'users', 'id','CASCADE',"CASCADE");
	}

	public function down()
	{

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