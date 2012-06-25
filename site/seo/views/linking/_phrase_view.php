<?php
/**
 * @var $pages Page[]
 * @var $keywords Keyword[]
 */

foreach($pages as $page)
    echo $page->url.'<br>';
foreach($keywords as $keyword)
    echo $keyword->name.'<br>';