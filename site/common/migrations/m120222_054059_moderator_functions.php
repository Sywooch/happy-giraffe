<?php

class m120222_054059_moderator_functions extends CDbMigration
{
    private $_table = 'auth_item_child';
	public function up()
	{
        $this->truncateTable($this->_table);
        $this->_table = 'auth_assignment';
        $this->truncateTable($this->_table);
        $this->_table = 'auth_item';
        $this->alterColumn($this->_table, 'name', 'varchar(64) null');
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
('перенос темы из сообщества в сообщество', 0, 'перенос темы из сообщества в сообщество', NULL, NULL),
('редактирование meta', 0, 'редактирование title, description, keywords', NULL, NULL),
('редактирование и удалении записей в сервисах', 0, 'редактирование и удалении записей в сервисах', NULL, NULL),
('редактирование комментариев', 0, 'редактирование комментариев', NULL, NULL),
('редактирование страницы пользователей', 0, 'полное редактирование страницы пользователей', NULL, NULL),
('редактирование тем в блогах', 0, 'редактирование тем в блогах (название темы, текст)', NULL, NULL),
('редактирование тем в сообществах', 0, 'редактирование тем в сообществах (название темы, текст)', NULL, NULL),
('удаление комментариев', 0, 'удаление комментариев', NULL, NULL),
('удаление пользователей', 0, 'удаление пользователей', NULL, NULL),
('удаление тем в блогах', 0, 'удаление тем в блогах', NULL, NULL),
('удаление тем в сообществах', 0, 'Удаление тем в сообществах', NULL, NULL),
('удаление фото в конкурсе', 0, 'удаление фото в конкурсе', NULL, NULL),
('управление правами пользователей', 0, 'управление правами пользователей', NULL, NULL),
('вход в админку', 0, 'вход в админку', NULL, NULL);


INSERT INTO `auth_item_child` (`parent`, `child`) VALUES
('moderator', 'user_signals'),
('user_signals', 'видеть сигналы'),
('editor', 'редактирование meta'),
('administrator', 'управление правами пользователей'),
('administrator', 'вход в админку'),
('supermoderator', 'управление правами пользователей');

INSERT INTO `auth_assignment` (`itemname`, `userid`, `bizrule`, `data`) VALUES
('administrator', '9987', NULL, NULL),
('administrator', '22', NULL, NULL);

");
        $this->alterColumn($this->_table, 'name', 'varchar(64) not null');
	}

	public function down()
	{

	}
}