<?php

namespace site\frontend\modules\posts\commands;

use site\frontend\modules\posts\models\Content;

/**
 * перестроение превьюшек для постов
 *
 * @author crocodile
 */
class RebuildPreview extends \CConsoleCommand
{

    /**
     * перестраивает превью для текстовых постов начиная с времени $startTime и
     * заканчивая временем $endTime
     * @param string $startTime
     * @param string $endTime
     */
    public function actionRebuild($startTime = null, $endTime = null)
    {
        $startTime = $startTime == null ? $startTime = strtotime("-1 day") : strtotime($startTime);
        $endTime = $endTime == null ? $endTime = time() : strtotime($endTime);

        $list = Content::model()->findAll(
                array(
                    'condition' => 'dtimeCreate BETWEEN :startDate and :endDate and originEntity in ("CommunityContent", "AdvPost")',
                    'params' => array('startDate' => $startTime, 'endDate' => $endTime)
                )
        );
        $count = sizeof($list);
        foreach ($list AS $i => $p)
        {
            $c = $i + 1;
            print "start process {$c}/{$count}, photo post id: {$p->id}\r\n";
            /**
             * у advContent превью строится по своему, по этому не трогаем его
             */
            $advContent = \site\frontend\modules\editorialDepartment\models\Content::model()->findByAttributes(array(
                'entity' => $p->communityContent->getIsFromBlog() ? 'BlogContent' : 'CommunityContent',
                'entityId' => (int) $p->communityContent->id
            ));
            if (is_null($advContent))
            {
                $p->communityContent->convertPost();
            }
            $p->delActivity();
            $p->addActivity();
        }
    }

}
