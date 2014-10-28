<?php

namespace site\frontend\modules\posts\commands;

/**
 * Description of ConvertCommand
 *
 * @author Кирилл
 */
class ConvertCommand extends \CConsoleCommand
{

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
        $id = $oldPost->id;
        $types = array(
            \CommunityContent::TYPE_POST => 'post',
            \CommunityContent::TYPE_VIDEO => 'video',
            \CommunityContent::TYPE_PHOTO_POST => 'photopost',
        );
        $fName = $service . '_' . $entity . '_convert_' . ($types[$oldPost->type_id] ? : 'unknown');
        $data = array(
            'service' => $service,
            'entity' => $entity,
            'entityId' => $id,
        );
        $client->doBackground($fName, self::serialize($data));
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

    public function actionIndex()
    {
        /** @todo параметризировать команду, что бы можно было выбирать обработчики */
        $worker = \Yii::app()->gearman->worker();
        $worker->addFunction('oldBlog_CommunityContent_convert', array($this, 'convertPost'));
        $worker->addFunction('oldCommunity_CommunityContent_convert', array($this, 'convertPost'));
        $worker->addFunction('oldBlog_CommunityContent_convert_post', array($this, 'convertPost'));
        $worker->addFunction('oldCommunity_CommunityContent_convert_post', array($this, 'convertPost'));
        $worker->addFunction('oldBlog_CommunityContent_convert_photopost', array($this, 'convertPost'));
        $worker->addFunction('oldCommunity_CommunityContent_convert_photopost', array($this, 'convertPost'));

        while ($worker->work());
    }

    /**
     * 
     * @param \GearmanJob $job
     */
    public function convertPost($job)
    {
        var_dump($job);
        $data = self::unserialize($job->workload());
        $model = \CActiveRecord::model($data['entity'])->findByPk($data['entityId']);
        $model->convertToNewPost();
        echo '.';
    }

}

?>
