<?php

namespace site\frontend\modules\posts\commands;

/**
 * Description of ConvertCommand
 *
 * @author Кирилл
 */
class ConvertCommand extends \CConsoleCommand
{

    public $commands = array(
        'oldBlog_CommunityContent_convert_post',
        'oldCommunity_CommunityContent_convert_post',
        'oldBlog_CommunityContent_convert_photopost',
        'oldCommunity_CommunityContent_convert_photopost',
        'oldBlog_CommunityContent_convert_status',
        'oldBlog_CommunityContent_convert_video',
        'oldCommunity_CommunityContent_convert_video',
    );

    /**
     * Добавление задачи, для конвертирования CommunityContent в новый сервис постов
     * 
     * @param \CommunityContent $oldPost
     */
    public static function addConvertTask($oldPost)
    {
        $client = \Yii::app()->gearman->client();
        $service = $oldPost->isFromBlog ? 'oldBlog' : 'oldCommunity';
        $entity = get_class($oldPost);
        if($entity == 'BlogContent') {
            $entity = 'CommunityContent';
        }
        $id = $oldPost->id;
        $types = array(
            \CommunityContent::TYPE_POST => 'post',
            \CommunityContent::TYPE_VIDEO => 'video',
            \CommunityContent::TYPE_PHOTO_POST => 'photopost',
            \CommunityContent::TYPE_STATUS => 'status',
        );
        if(!isset($types[$oldPost->type_id]))
            return false;
        $fName = $service . '_' . $entity . '_convert_' . $types[$oldPost->type_id];
        $data = array(
            'service' => $service,
            'entity' => $entity,
            'entityId' => $id,
        );
        // обеспечим уникальность задач
        $client->doBackground($fName, self::serialize($data), implode('-', $data));
        return true;
    }

    public static function serialize($data)
    {
        return \CJSON::encode($data);
    }

    public static function unserialize($data)
    {
        return \CJSON::decode($data);
    }

    public function actionIndex(Array $command = array(), $fake = false)
    {
        /** @todo параметризировать команду, что бы можно было выбирать обработчики */
        $worker = \Yii::app()->gearman->worker();
        if (empty($command))
            $command = $this->commands;

        foreach ($command as $c)
            if (in_array($c, $this->commands))
                $worker->addFunction($c, array($this, $fake ? 'fake' : 'convertPost'));

        while ($worker->work());
    }

    /**
     * 
     * @param \GearmanJob $job
     */
    public function convertPost($job)
    {
        try
        {
            $data = self::unserialize($job->workload());
            usleep(10000); // На всякий случай поспим 0,01 сек, что бы быть уверенным, что репликация прошла
            $model = \CActiveRecord::model($data['entity'])->resetScope()->findByPk($data['entityId']);
            $model->convertToNewPost();
            echo '.';
        }
        catch (\Exception $e)
        {
            echo "\nFAIL: ".$data['entityId']."\n";
        }
    }

    public function fake($job)
    {
        return null;
    }

}

?>
