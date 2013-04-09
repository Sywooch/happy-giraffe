<?php
/**
 * Author: alexk984
 * Date: 30.01.13
 *
 */

$k = Keyword::model()->findByPk(24084);
echo $k->name."<br>";
$k = Keyword::model()->findByPk(15083);
echo $k->name."<br>";