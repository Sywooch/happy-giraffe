<?php
/**
 * @author Никита
 * @date 06/02/15
 */

namespace site\frontend\modules\ads\components\renderers;


class PostRenderer extends BaseRenderer
{
    public function getClubTitle()
    {
        /** @var \CommunityContent $originEntity */
        $originEntity = \CActiveRecord::model($this->model->originEntity)->findByPk($this->model->originEntityId);
        $club = $originEntity->rubric->community->club;
        return $club->title;
    }

    public function getUser()
    {
        return $this->model->getUser();
    }
}