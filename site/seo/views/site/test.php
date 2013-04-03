<?php
/**
 * Author: alexk984
 * Date: 30.01.13
 *
 */

$html = file_get_contents('f:/test_page.html');
$parser = new WordstatFilter(1);
$parser->keyword = ParsingKeyword::model()->findByPk(243629016);
$parser->queryModify = new WordstatQueryModify;
$parser->parseHtml($html);