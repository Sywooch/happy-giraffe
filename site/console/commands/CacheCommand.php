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
        $dp = new CActiveDataProvider('CommunityPost');
        $iterator = new CDataProviderIterator($dp);
        foreach ($iterator as $c)
            $this->fix($c);

        $dp = new CActiveDataProvider('Comment');
        $iterator = new CDataProviderIterator($dp);
        foreach ($iterator as $c)
            $this->fix($c);
    }

    public function actionFixCdnImagesTest()
    {
        $model = CommunityPost::model()->find('content_id = :content_id', array(':content_id' => 94302));
        $this->fix($model);
    }

    protected function fix($model)
    {
        $model->text = preg_replace('/img(?:\d+).happy-giraffe.ru/', 'img.happy-giraffe.ru', $model->text);
        $model->save(false, array('text'));
    }
}