<?php

class m120222_054059_moderator_functions extends CDbMigration
{
    private $_table = 'auth_item_child';
	public function up()
	{
        $this->dropForeignKey($this->_table.'_parent_fk', $this->_table);
        $this->dropForeignKey($this->_table.'_child_fk', $this->_table);

        $this->truncateTable($this->_table);

        $this->_table = 'auth_assignment';
        $this->dropForeignKey($this->_table.'_itemname_fk', $this->_table);
        $this->truncateTable($this->_table);

        $this->_table = 'auth_item';
        $this->truncateTable($this->_table);
        $this->execute("INSERT INTO `auth_item` (`name`, `type`, `description`, `bizrule`, `data`) VALUES
('administrator', 2, 'Администратор', NULL, NULL),
('editor', 2, 'Редактор', NULL, NULL),
('moderator', 2, 'обработка сигналов от пользователей', NULL, NULL),
('supermoderator', 2, 'Супер модератор', NULL, NULL),
('user_signals', 1, 'обработка сигналов от пользователей', NULL, NULL),
('блокировка пользователей', 0, 'блокировка пользователей', NULL, NULL),
('видеть сигналы', 0, 'видеть сигналы от новых пользователей', NULL, NULL),
('изменение рубрик в темах', 0, 'изменение рубрик в темах', NULL, NULL),
('transfer post', 0, 'transfer post', NULL, NULL),
('edit meta', 0, 'редактирование title, description, keywords', NULL, NULL),
('редактирование и удалении записей в сервисах', 0, 'редактирование и удалении записей в сервисах', NULL, NULL),
('edit comment', 0, 'edit comment', NULL, NULL),
('редактирование страницы пользователей', 0, 'полное редактирование страницы пользователей', NULL, NULL),
('редактирование тем в блогах', 0, 'редактирование тем в блогах (название темы, текст)', NULL, NULL),
('edit post', 0, 'edit post (название темы, текст)', NULL, NULL),
('delete comment', 0, 'delete comment', NULL, NULL),
('удаление пользователей', 0, 'удаление пользователей', NULL, NULL),
('удаление тем в блогах', 0, 'удаление тем в блогах', NULL, NULL),
('delete post', 0, 'delete post', NULL, NULL),
('удаление фото в конкурсе', 0, 'удаление фото в конкурсе', NULL, NULL),
('user access', 0, 'user access', NULL, NULL),
('вход в админку', 0, 'вход в админку', NULL, NULL);


INSERT INTO `auth_item_child` (`parent`, `child`) VALUES
('moderator', 'user_signals'),
('user_signals', 'видеть сигналы'),
('editor', 'edit meta'),
('administrator', 'user access'),
('administrator', 'вход в админку'),
('supermoderator', 'user access');

INSERT INTO `auth_assignment` (`itemname`, `userid`, `bizrule`, `data`) VALUES
('administrator', '9987', NULL, NULL),
('administrator', '22', NULL, NULL);

");
        $this->alterColumn($this->_table, 'name', 'varchar(64) not null');
        $this->_table = 'auth_item_child';
        $this->alterColumn($this->_table, 'parent', 'varchar(64) not null');
        $this->alterColumn($this->_table, 'child', 'varchar(64) not null');
        $this->addForeignKey($this->_table.'_parent_fk', $this->_table, 'parent', 'auth_item', 'name','CASCADE',"CASCADE");
        $this->addForeignKey($this->_table.'_child_fk', $this->_table, 'child', 'auth_item', 'name','CASCADE',"CASCADE");

        $this->_table = 'auth_assignment';
        $this->addForeignKey($this->_table.'_itemname_fk', $this->_table, 'itemname', 'auth_item', 'name','CASCADE',"CASCADE");
    }

	public function down()
	{

	}
}