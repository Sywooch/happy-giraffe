<?php

namespace site\frontend\modules\v1\helpers;

class HtmlParser
{
    /**@todo: clear*/
    public static function handleHtml($html, &$data = null) {
        $simpleDom = new \SimpleHTMLDOM();
        $html = $simpleDom->str_get_html($html);

        foreach ($html->find('img[class=smile]') as $smile) {
            $smile->outertext = '<smile>' . $smile->src . '</smile>';
        }
        $html->load($html->save());

        foreach ($html->find('img') as $smile) {
            $smile->outertext = '<image>' . $smile->src . '</image>';
        }
        $html->load($html->save());

        foreach ($html->find('iframe') as $video) {
            $video->outertext = '<video>' . $video->src . '</video>';
        }
        $html->load($html->save());

        foreach ($html->find('picture') as $picture) {
            $picture->outertext = '<image>' . $picture->first_child()->srcset . '</image>';
        }
        $html->load($html->save());

        /*foreach ($html->find('a') as $link) {
            $link->outertext = '<link><src>' . $link->href . '</src><title>' . $link->innertext . '</title></link>';
        }
        $html->load($html->save());*/

        foreach ($html->find('comment') as $comment) {
            $comment->outertext = '';
        }
        $html->load($html->save());

        if ($data != null) {
            foreach ($html->find('photo-collection') as $collection) {
                $data['photo-collection'] = "{" . $collection->params . "}";
                $collection->outertext = '';
            }
            $html->load($html->save());
        }

        foreach ($html->find('ol') as $ol) {
            $lis = $ol->find('li');

            for ($i = 0; $i < count($lis); $i++) {
                $lis[$i]->outertext = ($i + 1) . '. ' . $lis[$i]->innertext . '<br/>';
            }

            $ol->outertext = $ol->innertext;

            $html->load($html->save());
        }

        foreach ($html->find('ul') as $ul) {
            //$ul->outertext = $ul->innertext;
            foreach ($ul->find('li') as $li) {
                $li->outertext = '&#8226; ' . $li->innertext . '<br/>';
            }
        }

        $html->load($html->save());

        foreach ($html->find('ul') as $ul) {
            $ul->outertext = $ul->innertext;
        }

        $html->load($html->save());

        self::clearTags($html, 'div[class=b-article_in-img]');

        /*$tags = array('div', 'strong', 'del', 'em', 'b', 'u', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6',);

        foreach ($tags as $key => $tag) {
            $this->clearTags($html, $tag);
            //\Yii::log((string)$html, 'info', 'api');
        }*/

        $html->load($html->save());

        return $html;
    }

    /**
     * Delete all tag from html without deleting inner text.
     *
     * @param $html
     * @param $tag
     */
    private static function clearTags(&$html, $tag)
    {
        $tags = $html->find($tag);

        if ($tags == null) {
            //\Yii::log($tag . ' is null', 'info', 'api');
            return;
        }

        for ($i = count($tags) - 1; $i >= 0; $i--) {
            $tags[$i]->outertext = $tags[$i]->innertext;
        }

        $html->load($html->save());

        return $html;
    }
}