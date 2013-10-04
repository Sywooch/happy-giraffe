<?php

class m131003_073307_community_contest extends CDbMigration
{
	public function up()
	{
        $this->execute("DROP TABLE IF EXISTS `community__contests`;

CREATE TABLE `community__contests` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `rules` text NOT NULL,
  `forum_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `Forum` (`forum_id`),
  CONSTRAINT `Forum` FOREIGN KEY (`forum_id`) REFERENCES `community__forums` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");

        $this->execute("DROP TABLE IF EXISTS `community__contest_works`;

CREATE TABLE `community__contest_works` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `contest_id` int(11) unsigned NOT NULL,
  `content_id` int(11) unsigned NOT NULL,
  `rate` int(11) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `Contest` (`contest_id`),
  KEY `Content` (`content_id`),
  CONSTRAINT `Content` FOREIGN KEY (`content_id`) REFERENCES `community__contents` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `Contest` FOREIGN KEY (`contest_id`) REFERENCES `community__contests` (`id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;");
        $this->execute("INSERT INTO `community__contests` (`id`, `title`, `description`, `rules`, `forum_id`)
VALUES
	(1,'Наш домашний любимец','Поделитесь с нами небольшим рассказом и фотосюжетом о вашем любимчике в семье. И его увидят все ваши друзья и знакомые, выскажут свои мнения о его воспитании, кормлении и поделятся с вами своими рассказами.','<ol>\n							<li>Принимай участие в фотоконкурсе «Наш домашний любимец».</li>\n							<li>С 15 сентября по 31 октября 2013 года разместите свою фотографию на тему «Как я провел лето» на промо-сайте leto.bystrobank.ru. Напишите поясняющий комментарий — как БыстроБанк помог Вам этим летом.</li>\n							<li>От одного участника допускается размещение не более 5 фотографий.</li>\n							<li>За размещенные фотографии с 15 сентября по 14 ноября 2013 года будет организовано голосование посетителей сайта.</li>\n							<li>За одно фото посетитель может проголосовать только 1 раз.</li>\n							<li>Вы можете приглашать к голосованию своих друзей и знакомых.</li>\n							<li>Авторы 8 фотографий, набравших наибольшее количество голосов, получат призы фотоконкурса. Авторы фотографий, занявшие места с 1-го по 8-ое будут награждены мультиварками либо автомобильными регистраторами. Один участник конкурса сможет получить только один приз.</li>\n							<li>Для участия в конкурсе необходимо быть действующим клиентом БыстроБанка или клиентом, имевшим действующий договор с банком в течение 2012–2013 гг. Каждый участник должен указать ФИО, город, дату рождения и номер телефона.</li>\n							<li>Проведение итогов голосования и публикация на сайте Банка www.bystrobank.ru списка победителей будет 15 ноября 2013 года. В течении 10 дней после публикации сотрудник Банка свяжется с победителями по телефону и пригласит в Банк для вручения приза.</li>\n						</ol>',39);");
	}

	public function down()
	{
		echo "m131003_073307_community_contest does not support migration down.\n";
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