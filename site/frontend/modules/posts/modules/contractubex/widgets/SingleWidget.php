<?php
/**
 * @author Никита
 * @date 03/12/15
 */

namespace site\frontend\modules\posts\modules\contractubex\widgets;

include_once \Yii::getPathOfAlias('site.frontend.vendor.simplehtmldom_1_5') . DIRECTORY_SEPARATOR . 'simple_html_dom.php';

abstract class SingleWidget extends \CWidget
{
    /**
     * @var \site\frontend\modules\posts\models\Content
     */
    public $model;

    private $_photo = false;

    public function run()
    {
        $this->render('_single');
    }

    public function getPhoto()
    {
        if ($this->_photo === false) {
            $docs = array(str_get_html($this->model->preview), str_get_html($this->model->html));
            foreach ($docs as $doc) {
                $img = $doc->find('img', 0);
                if ($img !== null) {
                    $src = $img->src;
                    $photo = \Yii::app()->thumbs->getPhotoByUrl($src);
                    if ($photo !== null) {
                        $this->_photo = $photo;
                    }
                }
            }
        }
        return $this->_photo;
    }
}