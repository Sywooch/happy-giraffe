<?php
namespace site\frontend\modules\posts\modules\forums\widgets\clubs;

use site\frontend\components\api\models\User;
use site\frontend\modules\posts\models\Content;

class ClubsWidget extends \CWidget
{
    public function run()
    {
        $sections = \CommunitySection::model()->with('clubs')->findAll();

        $posts = array();
        foreach ($sections as $section) {
            foreach ($section->clubs as $club) {
                $label = $club->toLabel();
                $post = Content::model()->byLabels(array($label))->orderDesc()->find();
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