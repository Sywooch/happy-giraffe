<?php

namespace site\frontend\modules\som\modules\qa\helpers;

/**
 * Class AnswersTreeListHelper
 *
 * @package site\frontend\modules\som\modules\qa
 * @author Sergey Gubarev
 */
class AnswersTreeListHelper
{

    public static function getFormattedList($list)
    {
        if (! count($list))
        {
            return false;
        }

        $formattedList = [];

        foreach ($list as $data)
        {
            if (count($data['answers']))
            {
                $childAnswersList = $data['answers'];

                $parentId = $data['id'];

                $newChildAnswersList = [];

                for ($i = 0; $i < count($childAnswersList); $i++)
                {
                    $answerData = $childAnswersList[$i];

                    if ($parentId == $answerData['rootId'])
                    {
                        $newChildAnswersList[] = $answerData;
                    }
                    else
                    {
                        $newChildAnswersList[$i - 1]['answers'][] = $answerData;
                    }
                }

                $data['answers'] = $newChildAnswersList;
            }

            $formattedList[] = $data;
        }

        return $formattedList;
    }

}