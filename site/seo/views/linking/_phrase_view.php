<?php
/**
 * @var $pages Page[]
 * @var $keywords Keyword[]
 */

foreach($pages as $page)
    echo CHtml::link($page->url, '#', array('onclick'=>'SeoLinking.page_id = '.$page->id.';return false;')).'<br>';
foreach($keywords as $keyword)
    echo CHtml::link($keyword->name, '#', array('onclick'=>'SeoLinking.keyword_id = '.$keyword->id.';return false;')).'<br>';