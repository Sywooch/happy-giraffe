<?php

class m120302_074019_change_auth_rules extends CDbMigration
{
    private $_table = 'auth_item';
	public function up()
	{
        $this->insert($this->_table, array(
            'name'=>'isAuthor',
            'type'=>0,
            'description'=>'Если автор статьи/комментария',
            'bizrule'=>'return !Yii::app()->user->isGuest && Yii::app()->user->id == $params["user_id"];'
        ));

        $this->insert($this->_table, array(
            'name'=>'user',
            'type'=>2,
            'description'=>'user',
        ));

        $this->_table = 'auth_item_child';
        $this->insert($this->_table,array(
            'parent'=>'user',
            'child'=>'isAuthor',
        ));
        $this->insert($this->_table,array(
            'parent'=>'administrator',
            'child'=>'user',
        ));
        $this->insert($this->_table,array(
            'parent'=>'moderator',
            'child'=>'user',
        ));
        $this->insert($this->_table,array(
            'parent'=>'isAuthor',
            'child'=>'removeComment',
        ));
        $this->insert($this->_table,array(
            'parent'=>'isAuthor',
            'child'=>'editComment',
        ));
        $this->insert($this->_table,array(
            'parent'=>'isAuthor',
            'child'=>'editCommunityContent',
        ));
        $this->insert($this->_table,array(
            'parent'=>'isAuthor',
            'child'=>'removeCommunityContent',
        ));
	}

	public function down()
	{

	}
}