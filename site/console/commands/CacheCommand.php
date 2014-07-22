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
        $dp = new CActiveDataProvider('CommunityPost', array(
            'criteria' => array(
                'condition' => 'id > :id',
            ),
        ));
        $iterator = new CDataProviderIterator($dp);
        foreach ($iterator as $c)
            $this->fix($c);

        $dp = new CActiveDataProvider('Comment', array(
            'criteria' => array(
                'condition' => 'id > :id',
            ),
        ));
        $iterator = new CDataProviderIterator($dp);
        foreach ($iterator as $c)
            $this->fix($c);
    }

    public function actionFixCdnImagesTest()
    {
        $model = CommunityPost::model()->find('content_id = :content_id', array(':content_id' => 186927));
        $this->fix($model);
    }

    protected function fix($model)
    {
        $text = str_replace('img.happy-giraffe.cdnvideo.ru', 'img.happy-giraffe.ru', $model->text);
        $model->updateByPk($model->id, array('text' => $text));
        $model->purified->clearCache();
    }
}