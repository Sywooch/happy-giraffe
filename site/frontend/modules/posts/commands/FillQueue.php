<?php

namespace site\frontend\modules\posts\commands;

/**
 * Description of FillQueue
 *
 * @author Кирилл
 */
class FillQueue extends \CConsoleCommand
{

    public function actionIndex($author = null, $type = null, $all = false, $lastDays = false)
    {
        $criteria = new \CDbCriteria();
        $criteria->order = 'created desc';
        if ($author) {
            $criteria->addColumnCondition(array(
                'author_id' => (int) $author,
            ));
        }
        if ($type) {
            $criteria->addColumnCondition(array(
                'type_id' => (int) $type,
            ));
        }
        if (!$all) {
            $criteria->addColumnCondition(array(
                'removed' => 0,
            ));
        }
        if ($lastDays) {
            $criteria->addCondition('created > :created');
            $criteria->params[':created'] = date("Y-m-d H:i:s", strtotime('-' . (int) $lastDays . ' day'));
        }

        $dataProvider = new \CActiveDataProvider(\CommunityContent::model()->resetScope(), array(
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

    public function actionOldPhotoPost()
    {
        $dataProvider = new \CActiveDataProvider(\CommunityContent::model()->resetScope(), array(
            'criteria' => array(
                'condition' => 't.id in (SELECT cc.id from community__contents cc join community__content_gallery ccg on ccg.content_id = cc.id WHERE cc.type_id = 1 AND cc.removed = 0)',
            ),
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

    public function actionCommunity($id)
    {
        $criteria = new \CDbCriteria();
        $criteria->with[] = 'rubric';
        $criteria->together = true;
        $criteria->addColumnCondition(array('rubric.community_id' => $id));
        $dataProvider = new \CActiveDataProvider(\CommunityContent::model(), array(
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

    public function actionRubric($id)
    {
        $criteria = new \CDbCriteria();
        $criteria->addColumnCondition(array('rubric_id' => $id));
        $dataProvider = new \CActiveDataProvider(\CommunityContent::model(), array(
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

    public function actionRecipe()
    {
        $criteria = new \CDbCriteria();
        $criteria->order = 'created desc';

        \Yii::import('site.frontend.modules.cook.models.*');
        $dataProvider = new \CActiveDataProvider(\CookRecipe::model()->resetScope(), array(
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
