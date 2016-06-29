<?php

namespace site\frontend\modules\comments\commands;

use site\frontend\modules\posts\models\Content;

/**
 * отчистка кеша комментариев
 * 
 * @author crocodile
 */
class CacheClear extends \CConsoleCommand
{

    public function actionIndex()
    {
        \Yii::app()->db->createCommand('SET SESSION wait_timeout = 28800;')->execute();
        $dataProvider = new \CActiveDataProvider(Content::model()->resetScope(), array(
            'criteria' => new \CDbCriteria(),
            #'criteria' => ['condition' => 'label_section is null and label_subsections  is null'],
            'pagination' => array(
                'pageSize' => 1000
            ),
        ));
        $iterator = new \CDataProviderIterator($dataProvider);

        foreach ($iterator AS $i => $post)
        {

            $widget = new \site\frontend\modules\comments\widgets\CommentWidget();
            $widget->model = array(
                'entity' => $post->originService == 'oldBlog' ? 'BlogContent' : $post->originEntity,
                'entity_id' => $post->originEntityId,
            );
            $widget->init();
            $widget->getCacheComponent()->delete($widget->getCacheKey());
            if (($i % 500) == 0)
            {
                print "{$i}/{$iterator->count()} " . round($i / $iterator->count() * 100, 2) . "% processed\r\n";
                \Yii::app()->db->createCommand('COMMIT')->execute();
            }
        }
    }

}
