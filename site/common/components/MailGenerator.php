<?php
/**
 * Author: alexk984
 * Date: 01.08.12
 */
class MailGenerator extends CComponent
{
    public static function getWeeklyArticles()
    {
        $criteria = new CDbCriteria;
        $criteria->limit = 5;
        $criteria->order = 'id desc';
        $articles = CommunityContent::model()->findAll($criteria);

        $result = '';
        foreach($articles as $article){
            $result.= $article->title.'<br>';
        }

        return $result;
    }
}
