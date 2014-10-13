<?php

namespace site\frontend\modules\editorialDepartment\models;

/**
 * Description of Rubric
 *
 * @author Кирилл
 */
class Rubric extends \CommunityRubric
{

    /**
     * 
     * @param type $className
     * @return \site\frontend\modules\editorialDepartment\models\Rubric
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /* scopes */

    /**
     * 
     * @param int $forumId
     * @return \site\frontend\modules\editorialDepartment\models\Rubric
     */
    public function byForum($forumId)
    {
        $this->dbCriteria->addColumnCondition(array('community_id' => $forumId));

        return $this;
    }

}

?>
