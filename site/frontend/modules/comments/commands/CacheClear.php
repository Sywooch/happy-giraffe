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

//            $comments = \Yii::app()->createWidget('site\frontend\modules\comments\widgets\CommentWidget', array('model' => array(
//                    /** @todo Исправить класс при конвертации */
//                    'entity' => $post->originService == 'oldBlog' ? 'BlogContent' : $post->originEntity,
//                    'entity_id' => $post->originEntityId,
//            )));
            $widget->getCacheComponent()->delete($widget->getCacheKey());
            print "{$i}/{$iterator->count()} " . round($i / $iterator->count(), 2) . "% processed\r\n";
            #exit();
        }
    }

}
