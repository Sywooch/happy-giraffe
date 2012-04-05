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
        Yii::import('site.frontend.extensions.phpQuery.phpQuery');
        Yii::import('site.frontend.helpers.*');
        require_once(Yii::getPathOfAlias('site.frontend') . '/vendor/simplehtmldom_1_5/simple_html_dom.php');

        $criteria = new CDbCriteria;
        $criteria->compare('by_happy_giraffe', true);
        //$criteria->addInCondition('t.id', array(
        //    6019,
        //));

        $contents = CommunityContent::model()->full()->findAll($criteria);

        foreach ($contents as $c) {
            $c->content->text = $this->_purify($c->content->text);
            $c->content->save();
        }
    }

    private function _purify($html)
    {
        $doc = phpQuery::newDocumentXHTML($html, $charset = 'utf-8');

        //вычисляем максимальный размер шрифта
        $maxFontSize = 18;
        foreach (pq('span[style]') as $s) {
            if (preg_match('/font-size:?(\d+)px;/', pq($s)->attr('style'), $matches)) {
                $fontSize = $matches[1];
                if ($fontSize > $maxFontSize) {
                    $maxFontSize = $fontSize;
                }
            }
        }

        //проставляем заголовки
        foreach (pq('span') as $s) {
            if (preg_match('/font-size:?(\d+)px;/', pq($s)->attr('style'), $matches)) {
                $fontSize = $matches[1];
                if ($fontSize == $maxFontSize && mb_strlen(pq($s)->text(), 'utf-8') <= 70 && count(pq($s)->find('img')) == 0) {
                    pq($s)->replaceWith('<h2>'. pq($s)->html() . '</h2>');
                }
            }
        }

        //чистим атрибуты
        foreach (pq('h2, h3, p, strong, em, u, s, li') as $e) {
            pq($e)->removeAttr('style');
        }

        //чистим маркированные списки
        foreach (pq('li') as $l) {
            pq($l)->text(preg_replace('/^\s*-\s?/', '', pq($l)->text()));
        }

        //вычищаем всё из заголовков - РАБОТАЕТ ЧЕРЕЗ ЖОПУ
        foreach (pq('h2, h3') as $h) {
            pq($h)->html(pq($h)->text());
            if (count(pq($h)->parents()) > 0) {
                pq($h)->parent(':first')->replaceWith(pq($h));
            }
        }

        //убираем спаны
        while (count(pq('span')) > 0) {
            foreach (pq('span') as $s) {
                pq($s)->replaceWith(pq($s)->html());
            }
        }

        //убираем фонты
        foreach (pq('font') as $s) {
            pq($s)->replaceWith(pq($s)->html());
        }

        //убираем длинные стронги
        foreach (pq('strong') as $s) {
            echo pq($s)->text() . "\n" . mb_strlen(trim(pq($s)->parent('p')->text()), 'utf-8') . "\n" . mb_strlen(trim(pq($s)->text()), 'utf-8');
            if (mb_strlen(pq($s)->text(), 'utf-8') > 70 || mb_strlen(trim(pq($s)->parent('p')->text()), 'utf-8') == mb_strlen(trim(pq($s)->text()), 'utf-8')) {
                pq($s)->replaceWith(pq($s)->html());
            }
        }

        foreach (pq('em') as $e) {
            if (count(pq($e)->parent('strong')) > 0 || count(pq($e)->children('strong')) > 0) {
                pq($e)->replaceWith(pq($e)->html());
            }
        }

        return $doc;
    }

    private function _purifyOld($text)
    {
        $html = new simple_html_dom();
        $html->load($text);

        //заменяем крупные спаны на заголовки
        $spans = $html->find('span');
        foreach ($spans as $s) {
            if (preg_match('/font-size:\s?(\d+)px;/', $s->style, $matches)) {
                $fontSize = $matches[1];
                if ($fontSize >= 18) {
                    $s->tag = 'h2';
                }
            }
        }

        //убираем длинные заголовки
        $headers = $html->find('h2, h3');
        foreach ($headers as $h) {
            if (mb_strlen($h->plaintext, 'utf-8') > 64) {
                $h->tag = 'p';
            }
        }

        //вычищаем всё из заголовков
        $headers = $html->find('h2, h3');
        foreach ($headers as $h) {
            $h->innertext = $h->plaintext;
        }

        //убираем спаны
        for ($i = 0; $i < 5; $i++) {
            $spans = $html->find('span');
            foreach ($spans as $s) {
                $s->outertext = $s->innertext;
            }
        }

        //убираем фонты
        $fonts = $html->find('font');
        foreach ($fonts as $s) {
            $s->outertext = $s->innertext;
        }

        //чистим оставшееся
        for ($i = 0; $i < 5; $i++) {
            $elements = $html->find('*');
            foreach ($elements as $e) {
                if ($e->tag != 'img') {
                    $e->style = null;
                    $e->innertext = trim($e->innertext);
                    if ($e->plaintext == '') {
                        $e->outertext = '';
                    }
                }
            }
        }

        return $html->save();
    }
}
