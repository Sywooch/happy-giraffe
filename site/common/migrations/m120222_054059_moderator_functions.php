<?php

class m120222_054059_moderator_functions extends CDbMigration
{
    private $_table = 'auth_item';
	public function up()
	{
        $this->insert($this->_table, array(
            'name'=>'удаление тем в сообществах',
            'type'=>'0',
            'description'=>'Удаление тем в сообществах',
        ));
        $this->insert($this->_table, array(
            'name'=>'удаление тем в блогах',
            'type'=>'0',
            'description'=>'удаление тем в блогах',
        ));
        $this->insert($this->_table, array(
            'name'=>'редактирование тем в сообществах',
            'type'=>'0',
            'description'=>'редактирование тем в сообществах (название темы, текст)',
        ));
        $this->insert($this->_table, array(
            'name'=>'редактирование тем в блогах',
            'type'=>'0',
            'description'=>'редактирование тем в блогах (название темы, текст)',
        ));
        $this->insert($this->_table, array(
            'name'=>'удаление комментариев в сообществах',
            'type'=>'0',
            'description'=>'удаление комментариев в сообществах',
        ));
        $this->insert($this->_table, array(
            'name'=>'удаление комментариев в блогах',
            'type'=>'0',
            'description'=>'удаление комментариев в блогах',
        ));
        $this->insert($this->_table, array(
            'name'=>'редактирование комментариев в блогах',
            'type'=>'0',
            'description'=>'редактирование комментариев в блогах',
        ));
        $this->insert($this->_table, array(
            'name'=>'редактирование комментариев в сообществах',
            'type'=>'0',
            'description'=>'редактирование комментариев в сообществах',
        ));
        $this->insert($this->_table, array(
            'name'=>'изменение рубрик в темах',
            'type'=>'0',
            'description'=>'изменение рубрик в темах',
        ));
        $this->insert($this->_table, array(
            'name'=>'перенос темы из сообщества в сообщество',
            'type'=>'0',
            'description'=>'перенос темы из сообщества в сообщество',
        ));
        $this->insert($this->_table, array(
            'name'=>'удаление пользователей',
            'type'=>'0',
            'description'=>'удаление пользователей',
        ));
        $this->insert($this->_table, array(
            'name'=>'блокировка пользователей',
            'type'=>'0',
            'description'=>'блокировка пользователей',
        ));
        $this->insert($this->_table, array(
            'name'=>'редактирование страницы пользователей',
            'type'=>'0',
            'description'=>'полное редактирование страницы пользователей',
        ));
        $this->insert($this->_table, array(
            'name'=>'удаление фото в конкурсе',
            'type'=>'0',
            'description'=>'удаление фото в конкурсе',
        ));
        $this->insert($this->_table, array(
            'name'=>'редактирование и удалении записей в сервисах',
            'type'=>'0',
            'description'=>'редактирование и удалении записей в сервисах',
        ));
        $this->insert($this->_table, array(
            'name'=>'редактирование и удаление комментариев в сервисах',
            'type'=>'0',
            'description'=>'редактирование и удаление комментариев в сервисах',
        ));

        $this->insert($this->_table, array(
            'name'=>'administrator',
            'type'=>'2',
            'description'=>'Администратор',
        ));
        $this->insert($this->_table, array(
            'name'=>'supermoderator',
            'type'=>'2',
            'description'=>'Супер модератор',
        ));
	}

	public function down()
	{

	}
}