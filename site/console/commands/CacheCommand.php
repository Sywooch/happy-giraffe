<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 9/23/13
 * Time: 6:27 PM
 * To change this template use File | Settings | File Templates.
 */

class CacheCommand extends CConsoleCommand
{
    public function actionFlushPurified()
    {
        $dp = new CActiveDataProvider('CommunityContent');
        $iterator = new CDataProviderIterator($dp);
        foreach ($iterator as $c) {
            $c->text = str_replace('/img(?:\d+).happy-giraffe.ru/', 'img.happy-giraffe.ru', $c->text);
            $c->save(false, array('text'));
        }

        $dp = new CActiveDataProvider('Comment');
        $iterator = new CDataProviderIterator($dp);
        foreach ($iterator as $c) {
            $c->text = str_replace('/img(?:\d+).happy-giraffe.ru/', 'img.happy-giraffe.ru', $c->text);
            $c->save(false, array('text'));
        }
    }
}