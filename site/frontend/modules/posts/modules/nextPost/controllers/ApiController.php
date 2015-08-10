<?php
namespace site\frontend\modules\posts\modules\nextPost\controllers;
use site\frontend\modules\posts\models\Content;

/**
 * @author Никита
 * @date 06/08/15
 */

class ApiController extends \site\frontend\modules\posts\controllers\ApiController
{
    public $post;
    private $_user;

    public function actionGet($postId, array $exclude = array())
    {
        \Yii::app()->clientScript->useAMD = true;

        $content = Content::model()->with('labelModels')->findByPk($postId);

        foreach ($content->labelModels as $label) {
            if (strpos($label->text, 'Клуб') !== false) {
                $criteria = new \CDbCriteria();
                $criteria->order = 'RAND()';
                $criteria->addNotInCondition('t.id', $exclude);
                $this->post = Content::model()->byLabels(array($label->text))->byService('advPost')->find($criteria);
                if ($this->post !== null) {
                    $this->success = true;
                    $this->data = array(
                        'id' => $this->post->id,
                        'title' => $this->post->title,
                        'url' => $this->post->url,
                        'html' => $this->renderPartial('_post', null, true, true),
                    );
                }
                break;
            }
        }
    }

    public function getUser()
    {
        if (is_null($this->_user)) {
            $this->_user = \site\frontend\components\api\models\User::model()->query('get', array(
                'id' => $this->post->authorId,
                'avatarSize' => \Avatar::SIZE_MEDIUM,
            ));
        }

        return $this->_user;
    }
}