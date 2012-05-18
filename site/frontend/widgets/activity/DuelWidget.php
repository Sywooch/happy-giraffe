<?php
/**
 * Дуэль дня
 *
 * Author: choo
 * Date: 16.05.2012
 */
class DuelWidget extends CWidget
{
    public function run()
    {
        $question = DuelQuestion::getAnswered();
        $this->render('DuelWidget', compact('question'));
    }
}
