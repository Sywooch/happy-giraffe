<?php
/**
 * Author: alexk984
 * Date: 30.01.13
 *
 */

$html = file_get_contents('f:/test_page.html');
$parser = new WordstatFilter(1);
$parser->keyword = ParsingKeyword::model()->findByPk(243629017);
$parser->debug = true;
$parser->queryModify = new WordstatQueryModify;
$parser->parseHtml($html);