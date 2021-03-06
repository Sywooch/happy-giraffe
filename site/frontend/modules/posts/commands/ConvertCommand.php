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
        'oldRecipe_CookRecipe_convert_recipe',
        'oldRecipe_SimpleRecipe_convert_recipe',
        'oldCommunity_CommunityContent_convert_question',
    );

    /**
     * Добавление задачи, для конвертирования CommunityContent в новый сервис постов
     *
     * @param \CommunityContent $oldPost
     */
    public static function addConvertTask($oldPost)
    {
        $client = \Yii::app()->gearman->client();
        if ($oldPost instanceof \CookRecipe)
        {
            $service = 'oldRecipe';
        }
        else
        {
            $service = $oldPost->isFromBlog ? 'oldBlog' : 'oldCommunity';
        }
        $entity = get_class($oldPost);
        if ($entity == 'BlogContent')
        {
            $entity = 'CommunityContent';
        }
        $id = $oldPost->id;
        $types = array(
            \CommunityContent::TYPE_POST => 'post',
            \CommunityContent::TYPE_VIDEO => 'video',
            \CommunityContent::TYPE_PHOTO_POST => 'photopost',
            \CommunityContent::TYPE_STATUS => 'status',
            \CommunityContent::TYPE_QUESTION => 'question',
            999 => 'recipe',
        );
        $type = $oldPost instanceof \CookRecipe ? 999 : $oldPost->type_id;
        if (!isset($types[$type]))
        {
            return false;
        }
        $fName = $service . '_' . $entity . '_convert_' . $types[$type];
        $data = array(
            'service' => $service,
            'entity' => $entity,
            'entityId' => $id,
        );

        // обеспечим уникальность задач
        $client->doNormal($fName, self::serialize($data), implode('-', $data));
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
        //\Yii::app()->db->enableSlave = false;
        \Yii::app()->db->createCommand('SET SESSION wait_timeout = 28800;')->execute();
        // Загрузим возможные модели
        \Yii::import('site.frontend.modules.cook.models.*');

        /** @todo параметризировать команду, что бы можно было выбирать обработчики */
        $worker = \Yii::app()->gearman->worker();
        if (empty($command))
        {
            $command = $this->commands;
        }

        foreach ($command as $c)
        {
            if (in_array($c, $this->commands))
            {
                $worker->addFunction($c, array($this, $fake ? 'fake' : 'convertPost'));
            }
        }

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
            \Yii::app()->db->setActive(true);
            $this->printLogStr("entyti_id: {$data['entityId']}; entity: {$data['entity']}");
            $startTime = microtime(true);
            $model = \CActiveRecord::model($data['entity'])->resetScope()->findByPk($data['entityId']);
            if (!$model)
            {
                /**
                 * данные еще не попали в базу
                 */
                $this->printLogStr("entity not found in db");
                return false;
                //throw new \Exception('no model');
            }
            $this->printLogStr('status ' . ( $model->convertToNewPost() ? 'ok' : 'fail'));
            $this->printLogStr('process time ' . (microtime(true) - $startTime));
            $model->handleCollection();
            \Yii::app()->db->setActive(false);
        }
        catch (\Exception $e)
        {
            echo $e;
            $this->printLogStr($e->getMessage());
            if ($e instanceof \CDbException)
            {
                echo "db error, exit\n";
                exit(1);
            }
        }

        \CommentLogger::model()->push(FALSE);
    }

    public function printLogStr($str)
    {
        print $str . "\r\n";

        if (!is_string($str))
        {
            return;
        }

        \CommentLogger::model()->addToLog('postConvert', $str);
    }

    public function fake($job)
    {
        return;
    }

}

?>
