<?php
/**
 * @author Никита
 * @date 17/12/15
 */

namespace site\frontend\modules\som\modules\qa\tests;

use site\frontend\modules\som\modules\qa\models\QaQuestion;

class QaQuestionTest extends \CDbTestCase
{
    public $fixtures = array(
        'categories' => 'site\frontend\modules\som\modules\qa\models\QaCategory',
    );

    public function testSave()
    {

        var_dump($this->categories); die;

        $question = new QaQuestion();
        $question->setAttributes(array(
            'title' => 'Вопрос из категории',
            'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
            'category' => $this->categories('category1'),
            'authorId' => 12936,
        ), false);
        $this->assertTrue($question->save());
    }
}