<?php
/**
 * @author Никита
 * @date 11/11/15
 */

namespace site\frontend\modules\som\modules\qa\components;


use site\frontend\modules\som\modules\qa\models\QaCategory;
use site\frontend\modules\som\modules\qa\models\QaQuestion;

class BulkDataGenerator
{
    const QUESTIONS_COUNT = 10000;
    const ANSWERS_COUNT = 50000;

    public static function run()
    {
        self::createCategories();

        \Yii::app()->db->getCommandBuilder()->createDeleteCommand('qa__questions', new \CDbCriteria())->execute();

        $rows = array();
        for ($i = 0; $i < self::QUESTIONS_COUNT; $i++) {
            $rows[] = array(
                'title' => 'Вопрос ' . ($i + 1),
                'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
                'sendNotifications' => rand(0, 1),
                'categoryId' => self::getRandomCategoryId(),
                'authorId' => self::getRandomUserId(),
                'dtimeCreate' => time(),
            );

            if ($i % 1000 == 0) {
                \Yii::app()->db->getCommandBuilder()->createMultipleInsertCommand('qa__questions', $rows)->execute();
                $rows = array();
            }
        }

        \Yii::app()->db->getCommandBuilder()->createMultipleInsertCommand('qa__questions', $rows)->execute();

        $rows = array();
        for ($i = 0; $i < self::ANSWERS_COUNT; $i++) {
            $rows[] = array(
                'text' => 'Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem. Ut enim ad minima veniam, quis nostrum exercitationem ullam corporis suscipit laboriosam, nisi ut aliquid ex ea commodi consequatur? Quis autem vel eum iure reprehenderit qui in ea voluptate velit esse quam nihil molestiae consequatur, vel illum qui dolorem eum fugiat quo voluptas nulla pariatur?',
                'questionId' => self::getRandomQuestionsId(),
                'authorId' => self::getRandomUserId(),
                'dtimeCreate' => time(),
            );

            if ($i % 1000 == 0) {
                \Yii::app()->db->getCommandBuilder()->createMultipleInsertCommand('qa__answers', $rows)->execute();
                $rows = array();
            }
        }

        \Yii::app()->db->createCommand("UPDATE qa__questions q
            INNER JOIN (
            SELECT questionId, COUNT(*) c
            FROM qa__answers
            GROUP BY questionId
            ) a ON a.questionId = q.id
            SET q.answersCount = a.c;")->execute();
    }

    protected static function createCategories()
    {
        QaCategory::model()->deleteAll();
        $titles = array(
            'Свадьба',
            'Отношения в семье',
            'Планирование',
            'Дети до года',
            'Беременность и роды',
            'Дети старше года',
            'Дошкольники',
            'Школьники',
        );

        foreach ($titles as $title) {
            $category = new QaCategory();
            $category->title = $title;
            $category->save();
        }
    }

    protected static function getRandomQuestionsId()
    {
        $sql = "SELECT t.id FROM qa__questions t JOIN (SELECT(FLOOR(max(id) * rand())) as maxid FROM qa__questions) as tt on t.id >= tt.maxid LIMIT 1";
        return \Yii::app()->db->createCommand($sql)->queryScalar();
    }

    protected static function getRandomUserId()
    {
        $sql = "SELECT t.id FROM users t JOIN (SELECT(FLOOR(max(id) * rand())) as maxid FROM users) as tt on t.id >= tt.maxid LIMIT 1";
        return \Yii::app()->db->createCommand($sql)->queryScalar();
    }

    protected static function getRandomCategoryId()
    {
        $sql = "SELECT t.id FROM qa__categories t JOIN (SELECT(FLOOR(max(id) * rand())) as maxid FROM qa__categories) as tt on t.id >= tt.maxid LIMIT 1";
        return \Yii::app()->db->createCommand($sql)->queryScalar();
    }
}