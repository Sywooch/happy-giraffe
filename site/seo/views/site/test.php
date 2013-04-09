<?php
/**
 * Author: alexk984
 * Date: 30.01.13
 *
 */

$cols = Yii::app()->db_seo->createCommand()
    ->selectDistinct('search_phrase_id')
    ->from('pages_search_phrases_positions')
    ->where('se_id = 2 AND position > 10 AND position < 30')
    ->queryColumn();

echo count($cols).'<br>';

foreach($cols as $col){
    $phrase = PagesSearchPhrase::model()->findByPk($col);
    if (strpos($phrase->page->url, '/cook/recipe/'))
        echo $phrase->page->url.' - '. $phrase->keyword->name.' - '.$phrase->keyword->wordstat.'<br>';
}
