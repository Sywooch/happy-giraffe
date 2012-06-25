<?php
/**
 * @var Page $page
 */

echo $page->getArticleTitle().'<br>';
echo $page->getArticleLink().'<br>';

foreach($page->phrases as $phrase){
    echo CHtml::link($phrase->keyword->name, '#', array('onclick'=>'SeoModule.getPhraseData(this, '.$phrase->id.')'));
}
