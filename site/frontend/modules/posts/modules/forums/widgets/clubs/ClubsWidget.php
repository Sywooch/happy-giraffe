<?php
namespace site\frontend\modules\posts\modules\forums\widgets\clubs;

use site\frontend\components\api\models\User;
use site\frontend\modules\posts\models\Content;
use site\frontend\modules\posts\models\Label;

class ClubsWidget extends \CWidget
{
    public function run()
    {
        $sections = \CommunitySection::model()->with('clubs')->findAll();
        $posts = Content::model()->byLabels(array(Label::LABEL_FORUMS))->orderDesc()->findAll(array(
            'group' => 'labels',
        ));

        $posts = array();
        foreach ($sections as $section) {
            foreach ($section->clubs as $club) {
                $label = $club->toLabel();
                $post = Content::model()->byLabels(array($label, Label::LABEL_FORUMS))->orderDesc()->find(array(
                    'limit' => 1,
                ));
                if ($post) {
                    $posts[$club->id] = $post;
                }
            }
        }

        $users = User::model()->findAllByPk(array_map(function($post) {
            return $post->authorId;
        }, $posts));

        $this->render('view', compact('sections', 'posts', 'users'));
    }
}