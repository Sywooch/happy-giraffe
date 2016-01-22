<?php
/**
 * @author Никита
 * @date 12/10/15
 */

namespace site\frontend\modules\posts\components;
include_once \Yii::getPathOfAlias('site.frontend.vendor.simplehtmldom_1_5') . DIRECTORY_SEPARATOR . 'simple_html_dom.php';

class ReverseParser
{
    public $doc;

    public $images;
    public $gifs;
    public $videos;

    public function __construct($html)
    {
        $this->doc = str_get_html($html);
        $this->gifs = $this->getGifsData();
        $this->images = $this->getImagesData();
        $this->videos = $this->getVideos();
    }

    protected function getImagesData()
    {
        $result = array();
        foreach ($this->doc->find('img') as $img) {
            if ($img->parent->tag != 'gif-image') {
                $photo = \Yii::app()->thumbs->getPhotoByUrl($img->src);
                $result[] = array(
                    'src' => $img->src,
                    'photo' => $photo,
                );
            }
        }
        return $result;
    }

    protected function getGifsData()
    {
        $result = array();
        foreach ($this->doc->find('gif-image') as $gif) {
            $params = $gif->params;
            if (preg_match('#animated:\s(.*)#', $params, $matches)) {
                $url = trim($matches[1], '\'');
                $photo = \Yii::app()->thumbs->getPhotoByUrl($url);
                $result[] = array(
                    'photo' => $photo,
                );
            }
        }
        return $result;
    }

    protected function getVideos()
    {
        $result = array();
        foreach ($this->doc->find('iframe') as $iframe) {
            if (preg_match('#embed\/([^\?]*)#', $iframe->src, $matches)) {
                $result[] = array(
                    'id' => $matches[1],
                    'url' => $iframe->src,
                );
            }
        }
        return $result;
    }
}