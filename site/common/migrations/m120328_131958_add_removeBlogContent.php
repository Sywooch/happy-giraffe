<?php

class m120328_131958_add_removeBlogContent extends CDbMigration
{
    private $_table = 'auth_item';
	public function up()
	{
        $this->insert($this->_table, array(
            'name'=>'removeBlogContent',
            'type'=>0,
            'description'=>'удаление записи в блоге'
        ));
        $this->insert($this->_table, array(
            'name'=>'editBlogContent',
            'type'=>0,
            'description'=>'редактирование записи в блоге'
        ));

        $this->_table = 'auth_item_child';
        $this->insert($this->_table, array(
            'parent'=>'isAuthor',
            'child'=>'removeBlogContent',
        ));
        $this->insert($this->_table, array(
            'parent'=>'isAuthor',
            'child'=>'editBlogContent',
        ));
	}

	public function down()
	{
		echo "m120328_131958_add_removeBlogContent does not support migration down.\n";
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