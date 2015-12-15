<?php

namespace site\frontend\modules\v1\actions;

use site\frontend\modules\posts\models\Content;

class PostContentAction extends RoutedAction implements IPostProcessable
{
    public function run()
    {
        $this->route('getPostsContent', null, null, null);
    }

    public function getPostsContent()
    {
        $this->controller->get(Content::model(), $this);
    }

    /**
     * HTML Format
     *
     * @param $data
     */
    public function postProcessing(&$data)
    {
        \Yii::import('ext.SimpleHTMLDOM.SimpleHTMLDOM');

        //\Yii::log(print_r($data, true), 'info', 'api');

        /**@todo: clear*/
        for ($i = 0; $i < count($data); $i++) {
            $simpleDom = new \SimpleHTMLDOM();
            $html = $simpleDom->str_get_html($data[$i]['html']);

            foreach ($html->find('img') as $smile) {
                $smile->outertext = '<smile>' . $smile->src . '</smile>';
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

            foreach ($html->find('photo-collection') as $collection) {
                $data[$i]['photo-collection'] = $collection->params;
                $collection->outertext = '';
            }
            $html->load($html->save());

            /*$tags = array('div', 'strong', 'del', 'em', 'b', 'u', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6',);

            foreach ($tags as $key => $tag) {
                $this->clearTags($html, $tag);
                //\Yii::log((string)$html, 'info', 'api');
            }*/

            //\Yii::log(print_r($html->nodes, true), 'info', 'api');

            $html->load($html->save());

            $data[$i]['html'] = $html->outertext;
        }
    }

    /**
     * Delete all tag from html without deleting inner text.
     *
     * @param $html
     * @param $tag
     */
    private function clearTags(&$html, $tag)
    {
        $tags = $html->find($tag);

        if ($tags == null) {
            //\Yii::log($tag . ' is null', 'info', 'api');
            return;
        }

        for ($i = count($tags) - 1; $i >= 0; $i--) {
            //\Yii::log($tag . ' outer text ' . $tags[$i]->outertext, 'info', 'api');
            //\Yii::log($tag . ' inner text ' . $tags[$i]->innertext, 'info', 'api');
            $tags[$i]->outertext = $tags[$i]->innertext;
            //\Yii::log($tag . ' outer text after changes ' . $tags[$i]->outertext, 'info', 'api');
        }

        $html->load($html->save());
    }
}