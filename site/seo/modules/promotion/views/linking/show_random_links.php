<?php
/**
 * Author: alexk984
 * Date: 14.03.13
 * @var $links InnerLink[]
 */

foreach($links as $link){
    echo 'со статьи '.CHtml::link($link->page->getArticleTitle(), $link->page->url);
    echo ' на &nbsp;&nbsp;&nbsp;'.CHtml::link($link->keyword->name, $link->pageTo->url).'<br>';
}