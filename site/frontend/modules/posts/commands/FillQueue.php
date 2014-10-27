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

        $dataProvider = new \CActiveDataProvider("CommunityContent", array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 100,
            ),
        ));
        $iterator = new \CDataProviderIterator($dataProvider);
        foreach ($iterator as $model)
            $model->addTaskToConvert();
    }

}

?>
