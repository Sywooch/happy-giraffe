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
        if ($oldPost instanceof \CookRecipe) {
            $service = 'oldRecipe';
        } else {
            $service = $oldPost->isFromBlog ? 'oldBlog' : 'oldCommunity';
        }
        $entity = get_class($oldPost);
        if ($entity == 'BlogContent') {
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
        if (!isset($types[$type])) {
            return false;
        }
        $fName = $service . '_' . $entity . '_convert_' . $types[$type];
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
        //\Yii::app()->db->enableSlave = false;
        \Yii::app()->db->createCommand('SET SESSION wait_timeout = 28800;')->execute();
        // Загрузим возможные модели
        \Yii::import('site.frontend.modules.cook.models.*');
        
        /** @todo параметризировать команду, что бы можно было выбирать обработчики */
        $worker = \Yii::app()->gearman->worker();
        if (empty($command)) {
            $command = $this->commands;
        }

        foreach ($command as $c) {
            if (in_array($c, $this->commands)) {
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
        try {
            $data = self::unserialize($job->workload());
            \Yii::app()->db->setActive(true);
            usleep(100000); // на всякий случай поспим 0.1 сек, что бы быть уверенным, что реплика прошла
            $model = \CActiveRecord::model($data['entity'])->resetScope()->findByPk($data['entityId']);
            if (!$model) {
                throw new \Exception('no model');
            }
            echo $model->convertToNewPost() ? '.' : '!';
            \Yii::app()->db->setActive(false);
        } catch (\Exception $e) {
            var_dump($data);
            echo $e;
            if($e instanceof \CDbException) {
                echo "db error, exit\n";
                exit(1);
            }
        }
    }

    public function fake($job)
    {
        return null;
    }

}

?>
