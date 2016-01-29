<?php

namespace site\frontend\modules\v1\actions;

use site\frontend\modules\comments\models\Comment;

class PostCommentsAction extends RoutedAction
{
    public function run()
    {
        $this->route('getPostComments', null, null, null);
    }

    public function getPostComments()
    {
        $require = array(
            'entity_id' => true,
            'service' => true,
            'count' => false,
        );



        if ($this->controller->checkParams($require)) {
            $params = $this->controller->getParams($require);

            $aliases = array(
                'oldBlog' => 'BlogContent',
                'oldCommunity' => 'CommunityContent',
                'photopost' => 'NewPhotoPost',
            );

            $where = "entity_id = {$params['entity_id']} and entity = '{$aliases[$params['service']]}'";

            if (isset($params['count'])) {
                $this->controller->data = array('comments_count' => Comment::model()->count($where));
            } else {
                $this->controller->get(Comment::model(), $this, $where);
            }
        } else {
            $this->controller->setError("ParamsMissing", 400);
        }
    }
}