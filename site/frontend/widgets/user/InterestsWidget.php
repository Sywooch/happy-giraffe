<?php
/**
 * Author: alexk984
 * Date: 29.02.12
 */
class InterestsWidget extends UserCoreWidget
{
    public $interests = array();

    public function init()
    {
        Yii::import('site.common.models.interest.*');

        $this->interests = InterestCategory::model()->findAll(array(
            'params' => array(':user_id' => 12936),
            'with' => array(
                'interests' => array(
                    'with' => 'usersCount',
                    'join' => 'JOIN interest__users_interests ON interest__users_interests.interest_id = interests.id AND interest__users_interests.user_id = :user_id',
                ),
            ),
        ));

        $this->visible = $this->isMyProfile || ! empty($this->interests);
        var_dump($this->visible);

        $basePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR;
        $baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
        Yii::app()->clientScript->registerScriptFile($baseUrl . '/interest.js');
        parent::init();
    }
}
