<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 26/04/14
 * Time: 11:19
 * To change this template use File | Settings | File Templates.
 */

class YandexShareWidget extends CWidget
{
    /**
     * @var CommunityContent
     */
    public $model;

    public function run()
    {
        $this->registerScript();
        $json = CJSON::encode(array(
            'element' => $this->getElementId(),
            'theme' => 'counter',
            'elementStyle' => array(
                'quickServices' => array(
                    'vkontakte',
                    'odnoklassniki',
                    'facebook',
                    'twitter',
                    'moimir',
                    'gplus',
                ),
            ),
            'link' => $this->model->getUrl(false, true),
            'title' => $this->model->title,
            'description' => $this->model->getContentText(),
            'image' => $this->getImage(),
        ));
        $this->render('view', compact('json'));
    }

    public function getDefaultImage()
    {
        return Yii::app()->request->hostInfo . '/new/images/base/logo.png';
    }

    public function getElementId()
    {
        return 'ya_share' . $this->model->id;
    }

    public function registerScript()
    {
        /** @var ClientScript $cs */
        $cs = Yii::app()->clientScript;
        $cs->registerScriptFile('//yandex.st/share/share.js', null, array(
            'charset' => 'utf-8',
        ));
    }

    protected function getImage()
    {
        $photo = $this->model->getPhoto();
        $avatar = $this->model->author->getAvatarUrl(200);
        if ($photo !== null) {
            return $photo->getOriginalUrl();
        } elseif ($avatar !== false) {
            return $avatar;
        } else {
            return $this->getDefaultImage();
        }
    }
}