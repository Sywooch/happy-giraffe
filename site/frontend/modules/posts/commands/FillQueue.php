<?php

namespace site\frontend\modules\posts\commands;

/**
 * Description of FillQueue
 *
 * @author Кирилл
 */
class FillQueue extends \CConsoleCommand
{

    public function actionIndex($author = null, $type = null)
    {
        $criteria = new \CDbCriteria();
        $criteria->order = 'created desc';
        if ($author) {
            $criteria->addColumnCondition(array(
                'author_id' => $author,
            ));
        }
        if ($type) {
            $criteria->addColumnCondition(array(
                'type_id' => $type,
            ));
        }

        $dataProvider = new \CActiveDataProvider("CommunityContent", array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 100,
            ),
        ));
        $iterator = new \CDataProviderIterator($dataProvider);
        $count = 0;
        foreach ($iterator as $model) {
            $model->addTaskToConvert();
            $count++;
            echo '.';
        }
        echo "\ntotal " . $count . " items\n";
    }

}

?>
