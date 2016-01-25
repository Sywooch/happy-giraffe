<?php
namespace site\frontend\modules\posts\modules\forums\widgets\clubs;

use site\frontend\components\api\models\User;
use site\frontend\modules\posts\models\Content;
use site\frontend\modules\posts\models\Label;

class ClubsWidget extends \CWidget
{
    public function run()
    {
        $sections = \CommunitySection::model()->findAll();
        $clubs = \Community::model()->findAll();
        $_posts = Content::model()->byLabels(array(Label::LABEL_FORUMS))->orderDesc()->count(array(
            'group' => 'labels',
        ));

        var_dump($_posts); die;

        $posts = array();
        foreach ($_posts as $post) {
            foreach ($post->labelsArray as $label) {
                foreach ($clubs as $club) {
                    if ($label == $club->toLabel()) {
                        $posts[$club->id] = $post;
                    }
                }
            }
        }

        $users = User::model()->findAllByPk(array_map(function($post) {
            return $post->authorId;
        }, $posts));

        $this->render('view', compact('sections', 'posts', 'users'));
    }
}