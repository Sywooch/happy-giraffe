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
     * @param type $timeLimit
     */
    public function actionFix($startTime = null, $endTime = null)
    {

        $startTime = $startTime == null ? $startTime = strtotime("-30 hour") : intval($startTime);
        $endTime = $endTime == null ? $endTime = time() : intval($endTime);

        $list = Photopost::model()->findAll(
                array(
                    'condition' => 'dtimeCreate BETWEEN :startDate and :endDate',
                    'params' => array('startDate' => $startTime, 'endDate' => $endTime)
                )
        );
        /*
         * @var $p site\frontend\modules\som\modules\photopost\models\Photopost
         */
        foreach ($list AS $p)
        {

            $p->save();
            $entity = array_search(get_class($p->owner), \site\frontend\modules\posts\models\Content::$entityAliases);
            $post = $p->getPost($entity);
            $post = \site\frontend\modules\posts\models\Content::model()->findByPk($post->id);
            var_dump($post->getActivityId());
            #$post->addActivity();

            $activity = \site\frontend\modules\som\modules\activity\models\api\Activity::model()->query('get', array('hash' => $post->getActivityId()));
            exit();
            var_dump($activity);exit();
            
            $activity = $post->getActivityModel();
            $activity->save(true);
        }
    }

}
