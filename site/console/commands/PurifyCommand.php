<?php
/**
 * Author: choo
 * Date: 08.04.2012
 */
class PurifyCommand extends CConsoleCommand
{
    public function actionPurify()
    {
        Yii::import('site.frontend.extensions.ESaveRelatedBehavior');
        Yii::import('site.frontend.extensions.phpQuery.phpQuery');
        Yii::import('site.frontend.helpers.*');
        require_once(Yii::getPathOfAlias('site.frontend') . '/vendor/simplehtmldom_1_5/simple_html_dom.php');

        $criteria = new CDbCriteria;
        $criteria->compare('by_happy_giraffe', true);

        $contents = CommunityContent::model()->full()->findAll($criteria);

        foreach ($contents as $c) {
            echo $c->id . "\n";
            $c->content->text = $this->_purify($c->content->text);
            $c->content->save();
        }
    }

    public function actionPurifyNonGiraffe()
    {
        Yii::import('site.frontend.extensions.ESaveRelatedBehavior');
        Yii::import('site.frontend.extensions.phpQuery.phpQuery');
        Yii::import('site.frontend.helpers.*');
        require_once(Yii::getPathOfAlias('site.frontend') . '/vendor/simplehtmldom_1_5/simple_html_dom.php');

        $perIteraion = 1000;

        $criteria = new CDbCriteria;
        $criteria->condition = 'by_happy_giraffe = 0 AND t.id > 12265';
        $criteria->limit = $perIteraion;
        $criteria->order = 't.id ASC';

        while ($contents = CommunityContent::model()->full()->findAll($criteria)) {
            foreach ($contents as $c) {
                echo $c->id . "\n";
                $c->content->text = $this->_purifyNonGiraffe($c->content->text);
                $c->content->save();
            }

            $criteria->offset += $perIteraion;
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
        foreach (pq('h2, h3, p, strong, b, em, u, s, li') as $e) {
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
        foreach (pq('strong, b') as $s) {
            if (mb_strlen(pq($s)->text(), 'utf-8') > 25 || mb_strlen(trim(pq($s)->parent('p')->text()), 'utf-8') == mb_strlen(trim(pq($s)->text()), 'utf-8')) {
                if (mb_strlen(pq($s)->html(), 'utf-8') > 0) {
                    pq($s)->replaceWith(pq($s)->html());
                } else {
                    pq($s)->remove();
                }
            }
        }

        foreach (pq('em') as $e) {
            if (count(pq($e)->parent('strong')) > 0 || count(pq($e)->children('strong')) > 0) {

                pq($e)->replaceWith(pq($e)->html());
            }
        }

        return $doc;
    }

    private function _purifyNonGiraffe($html)
    {
        $doc = phpQuery::newDocumentXHTML($html, $charset = 'utf-8');

        $allowedTags = 'h2, h3, p, a, ul, ol, li, img, div';

        //убираем лишние заголовки
        foreach (pq('h2, h3') as $e) {
            if (mb_strlen(pq($e)->text(), 'utf-8') > 70) {
                pq($e)->replaceWith('<p>' . pq($e)->html() . '</p>');
            }
        }

        //убираем лишние теги
        while (count(pq(':not(' . $allowedTags .')')) > 0) {
            foreach (pq(':not(' . $allowedTags .')') as $s) {
                pq($s)->replaceWith((string) pq($s)->html());
            }
        }

        //чистим атрибуты
        foreach (pq(':not(img, div)') as $e) {
            pq($e)->removeAttr('style');
        }

        return $doc;
    }
}
