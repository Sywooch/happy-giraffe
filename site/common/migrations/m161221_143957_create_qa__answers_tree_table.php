<?php

/**
 * @author Sergey Gubarev
 */
class m161221_143957_create_qa__answers_tree_table extends CDbMigration
{

    private $_tableName = 'qa__answers_tree';

	public function safeUp()
	{
        $this->createTable($this->_tableName, [
            'ancestor_id'   => 'int(11) UNSIGNED NOT NULL',
            'descendant_id' => 'int(11) UNSIGNED NOT NULL',
            'depth'         => 'int NOT NULL DEFAULT "0"',
            'PRIMARY KEY (ancestor_id, descendant_id)'
        ], 'ENGINE=InnoDB DEFAULT CHARSET=utf8');

        $this->createIndex('idx_ancestor_id', $this->_tableName, 'ancestor_id');
        $this->createIndex('idx_descendant_id', $this->_tableName, 'descendant_id');

        $this->addForeignKey('fk_ancestor_id__qa__answers_id', $this->_tableName, 'ancestor_id', 'qa__answers', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey('fk_descendant_id__qa__answers_id', $this->_tableName, 'descendant_id', 'qa__answers', 'id', 'CASCADE', 'CASCADE');
	}

	public function safeDown()
	{
		$this->dropIndex('idx_ancestor_id', $this->_tableName);
        $this->dropIndex('idx_ancestor_id', $this->_tableName);

        $this->dropForeignKey('fk_ancestor_id__qa__answers_id', $this->_tableName);
        $this->dropForeignKey('fk_descendant_id__qa__answers_id', $this->_tableName);

        $this->dropTable($this->_tableName);
	}

}