<?php

namespace site\frontend\modules\posts\commands;

/**
 * Description of FillQueue
 *
 * @author Кирилл
 */
class FillQueue extends \CConsoleCommand
{

    public function actionIndex($author = null)
    {
        $criteria = array(
            'condition' => 'type_id = ' . \CommunityContent::TYPE_POST . ($author ? ' AND author_id = ' . $author : ''),
            'order' => 'created desc'
        );


        $models = \CommunityContent::model()->findAll($criteria);
        foreach ($models as $model)
        {
            $model->addTaskToConvert();
        }
    }

}

?>
