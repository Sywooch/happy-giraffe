<?php

use site\frontend\modules\som\modules\qa\components\CTAnswerManager;
use site\frontend\modules\som\modules\qa\models\QaAnswer;
use site\frontend\modules\som\modules\qa\models\QaCategory;
use site\frontend\modules\som\modules\qa\models\QaCTAnswer;

class m161215_124704_answers_pediatrician extends CDbMigration
{
    public function up()
    {
        // Создание таблицы
        $sql = <<<SQL
CREATE TABLE `qa__answers_new` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `content` TEXT,
  `id_author` INT(11) DEFAULT NULL,
  `votes_count` INT(11) NOT NULL DEFAULT '0',
  `is_removed` TINYINT(1) NOT NULL DEFAULT '0',
  `dtimeCreate` INT(11) NOT NULL,
  `dtimeUpdate` INT(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Древовидные комментарии к вопросам (ответы)'
SQL;
        $this->execute($sql);

        // Создание таблицы с деревом
        $sql = <<<SQL
CREATE TABLE `qa__answers_new_tree` (
  `id_ancestor` INT(11) DEFAULT NULL,
  `id_descendant` INT(11) DEFAULT NULL,
  `id_nearest_ancestor` INT(11) DEFAULT NULL,
  `level` INT(11) DEFAULT NULL,
  `id_subject` INT(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COMMENT='Дерево для новых комментариев'
SQL;
        $this->execute($sql);

        $answers = QaAnswer::model()
            ->category(QaCategory::PEDIATRICIAN_ID)
            ->findAll();
        $answerManager = new CTAnswerManager();

        function f(QaAnswer $answer, CTAnswerManager $manager)
        {
            if ($answer->root != null) {
                $a = f($answer->root, $manager);

                $newAnswer = ($ans = $manager->getAnswer($answer->id)) ? $ans : $manager->createAnswer($answer->authorId, $answer->text, $a, $answer->id);
            } else {
                $newAnswer = ($ans = $manager->getAnswer($answer->id)) ? $ans : $manager->createAnswer($answer->authorId, $answer->text, $answer->question, $answer->id);
            }

            /** @var QaCTAnswer $newAnswer */
            $newAnswer->is_removed = $answer->isRemoved;
            $newAnswer->dtimeCreate = $answer->dtimeCreate;
            $newAnswer->dtimeUpdate = $answer->dtimeUpdate;
            $newAnswer->votes_count = $answer->votesCount;
            $newAnswer->save();

            return $newAnswer;
        }

        foreach ($answers as $answer) {
            f($answer, $answerManager);
        }
    }

    public function down()
    {
        // Удаление таблицы
        $this->execute('DROP TABLE `qa__answers_new`');
        // Удаление таблицы с деревом
        $this->execute('DROP TABLE `qa__answers_new_tree`');
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