<?php
/**
 * Author: alexk984
 * Date: 30.01.13
 *
 */
$criteria = new CDbCriteria;
//$criteria->order = 'rand()';
$criteria->limit = 100;
$recipes = CookRecipe::model()->findAll($criteria);
foreach ($recipes as $recipe) {
    $keywords = Yii::app()->db_seo->createCommand()
        ->select('keyword_id, keywords.name')
        ->from('parsing_task__keywords as t')
        ->join('keywords.keywords as keywords', 'keywords.id = t.keyword_id')
        ->where('content_id = :content_id AND keywords.name != :name',
            array(':content_id'=>$recipe->id,':name'=>$recipe->title))
        ->order('keywords.wordstat')
        ->limit(10)
        ->queryAll();

    foreach($keywords as $keyword)
        echo $keyword['name'].'<br>';
}
