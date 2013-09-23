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
    public function actionFixCdnImages()
    {
        $dp = new CActiveDataProvider('CommunityContent');
        $iterator = new CDataProviderIterator($dp);
        foreach ($iterator as $c)
            $c->fix();

        $dp = new CActiveDataProvider('Comment');
        $iterator = new CDataProviderIterator($dp);
        foreach ($iterator as $c)
            $c->fix();
    }

    public function actionFixCdnImagesTest()
    {
        $model = CommunityContent::model()->findByPk(94302);
        $model->fix();
    }

    protected function fix($model)
    {
        $model->text = preg_replace('/img(?:\d+).happy-giraffe.ru/', 'img.happy-giraffe.ru', $model->text);
        $model->save(false, array('text'));
    }
}