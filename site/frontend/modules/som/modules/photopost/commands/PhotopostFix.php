<?php

namespace site\frontend\modules\som\modules\photopost\commands;

use site\frontend\modules\som\modules\photopost\models\Photopost;

/**
 * Исправляет фотопосты которые не удалось создать по причине рассинхронизации
 * данных между бд
 *
 * @author crocodile
 */
class PhotopostFix extends \CConsoleCommand
{

    /**
     * перегенерируем записи в onair
     * @param string $startTime
     * @param string $endTime
     */
    public function actionFix($startTime = null, $endTime = null)
    {

        $startTime = $startTime == null ? $startTime = strtotime("-5 minute") : strtotime($startTime);
        $endTime = $endTime == null ? $endTime = time() : strtotime($endTime);

        $list = Photopost::model()->findAll(
                array(
                    'condition' => 'dtimeCreate BETWEEN :startDate and :endDate',
                    'params' => array('startDate' => $startTime, 'endDate' => $endTime)
                )
        );
        $count = sizeof($list);
        /*
         * @var $p site\frontend\modules\som\modules\photopost\models\Photopost
         */
        foreach ($list AS $i => $p)
        {
            $c = $i + 1;
            print "start process {$c}/{$count}, photo post id: {$p->id}\r\n";
            //$p->save();
            $entity = array_search(get_class($p->owner), \site\frontend\modules\posts\models\Content::$entityAliases);
            $post = $p->getPost($entity);
            $post = \site\frontend\modules\posts\models\Content::model()->findByPk($post->id);
            if ($post == null)
            {
                print "post content not found for {$p->id}\r\n";
                continue;
            }
            print "post_content: {$post->id}, original_id: {$post->originEntityId}\r\n";
            print "updating";
            $post->preview = $p->getPhotopostTag();
            $post->save();
            $post->delActivity();
            $post->addActivity();
            print ", updated\r\n";
        }
    }

}
