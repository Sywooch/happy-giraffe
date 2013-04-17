<?php
/**
 * Author: alexk984
 * Date: 10.04.12
 */
class PagePromotion extends EMongoDocument
{
    public $url;
    public $keyword_id;
    public $strict_wordstat;
    public $yandex_pos;
    public $google_pos;
    public $views;
    public $se_traffic;

    /**
     * @param string $className
     * @return PagePromotion
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getCollectionName()
    {
        return 'seo_page_promotion';
    }

    public function load()
    {
        $text = '';

        $lines = explode(PHP_EOL, $text);
        foreach ($lines as $line) {
            $parts = explode(',', $line);
            $url = $parts[0];
            for ($i = 1; $i < count($parts); $i++) {
                $obj = new PagePromotion();
                $obj->url = $url;
                $keyword = Keyword::GetKeyword(trim($parts[$i]));
                $obj->keyword_id = (int)$keyword->id;
                $obj->save();
            }
        }
    }
}