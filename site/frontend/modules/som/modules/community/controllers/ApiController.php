<?php

namespace site\frontend\modules\som\modules\community\controllers;

use \site\frontend\modules\posts\models\Label;

/**
 * Description of ApiController
 *
 * @author Кирилл
 */
class ApiController extends \site\frontend\components\api\ApiController
{

    public function actionGetLabels($rubricId = false, $forumId = false, $communityId = false, $blog = false)
    {
        if ($forumId) {
            $forum = Community::model()->with('club')->findByPk($forumId);

            $labels = array(
                'Форум: ' . $forum->title,
                'Клуб: ' . $forum->club->title,
            );

            $this->success = true;
            $this->isPack = true;
            $this->data = array_map(function($label) {
                return array('id' => Label::getIdByLabel($label, true), 'text' => $label);
            }, $labels);
        } elseif ($blog) {
            $this->success = true;
            $this->isPack = true;
            $labels = array(
                'Блог',
            );
            $this->data = array_map(function($label) {
                return array(
                    'success' => true,
                    'data' => array('id' => (int) Label::getIdByLabel($label, true), 'text' => $label)
                );
            }, $labels);
        }
    }

}
