<?php
/**
 * Author: choo
 * Date: 27.06.2012
 */
class JunkController extends HController
{
    function actionIndex()
    {
        $n = 2.01;
        var_dump($n == (int) $n);
    }
}
