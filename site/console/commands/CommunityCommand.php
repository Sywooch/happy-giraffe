<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Eugene
 * Date: 06.03.12
 * Time: 16:03
 * To change this template use File | Settings | File Templates.
 */
class CommunityCommand extends CConsoleCommand
{
    public function actionCutConvert()
    {
        Yii::import('site.frontend.extensions.ESaveRelatedBehavior');
        Yii::import('site.frontend.components.CutBehavior');
        $community = CommunityContent::model()->full()->findAll();
        foreach($community as $model)
        {
            if(!$model->content || !$model->content->text)
            {
                echo 'Беда!!!11 ID: ' . $model->id . ' --- ';
                continue;
            }
            $p = new CHtmlPurifier();
            $p->options = array(
                'URI.AllowedSchemes'=>array(
                    'http' => true,
                    'https' => true,
                ),
                'HTML.Nofollow' => true,
                'HTML.TargetBlank' => true,
                'HTML.AllowedComments' => array('more' => true),

            );
            $text = $p->purify($model->content->text);
            $pos = strpos($text, '<!--more-->');
            $preview = $pos === false ? $text : substr($text, 0, $pos);
            $preview = $p->purify($preview);
            $model->preview = $preview;
            $model->save(false);
            $model->content->text = $text;
            $model->content->save(false);
        }
    }

    public function actionBlogRubric()
    {
        $users = User::model()->findAll();
        foreach ($users as $u) {
            $r = new CommunityRubric;
            $r->name = 'Обо всём';
            $r->user_id = $u->id;
            $r->save();
        }
    }

    public function actionPurify()
    {
        Yii::import('site.frontend.extensions.ESaveRelatedBehavior');
        Yii::import('site.frontend.helpers.*');
        require_once(Yii::getPathOfAlias('site.frontend') . '/vendor/simplehtmldom_1_5/simple_html_dom.php');

        $criteria = new CDbCriteria;
        $criteria->addInCondition('t.id', array(
            13569,
        ));

        $contents = CommunityContent::model()->full()->findAll($criteria);

        foreach ($contents as $c) {
            $c->content->text = $this->_purify($c->content->text);
            $c->content->save();
        }
    }

    private function _purify($text)
    {
        $html = new simple_html_dom();
        $html->load($text);

        //убираем спаны
        $spans = $html->find('span');
        foreach ($spans as $s) {
            $s->outertext = $s->innertext;
        }

        //обнуляем стили параграфов
        $paragraphs = $html->find('p');
        foreach ($paragraphs as $p) {
            $p->style = null;
        }

        //чистим заголовки
        $headers = $html->find('h2, h3');
        foreach ($headers as $h) {
            $h->innertext = $h->plaintext;
            if (strlen($h->innertext) > 64) {
                $h->tag = 'em';
            }
        }

        /*$elements = $html->find('*');
        foreach ($elements as $e) {
            $e->innertext = trim($e->innertext);

            if ($e->innertext == '') {
                $e->outertext = '';
            }
        }*/

        return $html->save();
    }
}