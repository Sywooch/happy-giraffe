<?php

class m151007_093137_create_questionnaire_tables extends CDbMigration
{
    /*public function up()
    {
      $sql = <<<SQL
			SET FOREIGN_KEY_CHECKS=0;

DROP TABLE IF EXISTS `questionnaire`;
CREATE TABLE `questionnaire` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`) USING BTREE,
  CONSTRAINT `questionnaire_author` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;

DROP TABLE IF EXISTS `questionnaire_answers`;
CREATE TABLE `questionnaire_answers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `question_id` int(10) unsigned NOT NULL,
  `questionnaire_id` int(10) unsigned NOT NULL,
  `text` varchar(255) NOT NULL,
  `result_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `questionnaire_question` (`questionnaire_id`) USING BTREE,
  KEY `questionnaire_question_result` (`result_id`) USING BTREE,
  KEY `question_id` (`question_id`),
  CONSTRAINT `questionnaire_question` FOREIGN KEY (`questionnaire_id`) REFERENCES `questionnaire` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `questionnaire_questions`;
CREATE TABLE `questionnaire_questions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `questionnaire_id` int(10) unsigned NOT NULL,
  `stage` int(10) unsigned NOT NULL,
  `text` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `questionnaire_results`;
CREATE TABLE `questionnaire_results` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `questionnaire_id` int(10) unsigned NOT NULL,
  `type` tinyint(1) NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `questionnare_result` (`questionnaire_id`) USING BTREE,
  CONSTRAINT `questionnaire_results_ibfk_1` FOREIGN KEY (`questionnaire_id`) REFERENCES `questionnaire` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
SQL;

      $this->execute($sql);
    }

    public function down()
    {
      $this->dropTable('questionnaire_answers');
      $this->dropTable('questionnaire_questions');
      $this->dropTable('questionnaire_results');
      $this->dropTable('questionnaire');
    }*/

	public function safeUp()
	{
		$sql = <<<SQL
			SET FOREIGN_KEY_CHECKS=0;

DROP TABLE IF EXISTS `questionnaire`;
CREATE TABLE `questionnaire` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `user_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `user_id` (`user_id`) USING BTREE,
  CONSTRAINT `questionnaire_author` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=72 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci ROW_FORMAT=COMPACT;

DROP TABLE IF EXISTS `questionnaire_answers`;
CREATE TABLE `questionnaire_answers` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `question_id` int(10) unsigned NOT NULL,
  `questionnaire_id` int(10) unsigned NOT NULL,
  `text` varchar(255) NOT NULL,
  `result_id` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `questionnaire_question` (`questionnaire_id`) USING BTREE,
  KEY `questionnaire_question_result` (`result_id`) USING BTREE,
  KEY `question_id` (`question_id`),
  CONSTRAINT `questionnaire_question` FOREIGN KEY (`questionnaire_id`) REFERENCES `questionnaire` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `questionnaire_questions`;
CREATE TABLE `questionnaire_questions` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `questionnaire_id` int(10) unsigned NOT NULL,
  `stage` int(10) unsigned NOT NULL,
  `text` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=38 DEFAULT CHARSET=utf8;

DROP TABLE IF EXISTS `questionnaire_results`;
CREATE TABLE `questionnaire_results` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `questionnaire_id` int(10) unsigned NOT NULL,
  `type` tinyint(1) NOT NULL,
  `value` varchar(255) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `questionnare_result` (`questionnaire_id`) USING BTREE,
  CONSTRAINT `questionnaire_results_ibfk_1` FOREIGN KEY (`questionnaire_id`) REFERENCES `questionnaire` (`id`) ON DELETE NO ACTION ON UPDATE NO ACTION
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8 ROW_FORMAT=COMPACT;
SQL;

		$this->execute($sql);
	}

	public function safeDown()
	{
        $this->dropTable('questionnaire_answers');
        $this->dropTable('questionnaire_questions');
        $this->dropTable('questionnaire_results');
		$this->dropTable('questionnaire');
	}
}