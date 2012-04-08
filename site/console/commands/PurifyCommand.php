<?php
/**
 * Author: choo
 * Date: 08.04.2012
 */
class PurifyCommand extends CConsoleCommand
{
    public function actionIndex($cli = 0, $id = null, $by_happy_giraffe = 0)
    {
        Yii::import('site.frontend.extensions.ESaveRelatedBehavior');
        Yii::import('site.frontend.extensions.phpQuery.phpQuery');
        Yii::import('site.frontend.helpers.*');

        $criteria = new CDbCriteria;
        if ($id !== null) {
            $criteria->compare('t.id', $id);
        } else {
            $criteria->compare('by_happy_giraffe', $by_happy_giraffe);
        }

        $contents = CommunityContent::model()->full()->findAll($criteria);

        foreach ($contents as $c) {
            echo $c->id . "\n";
            $method = $c->by_happy_giraffe ? '_giraffe' : '_nonGiraffe';
            $text = $this->$method($c->content->text);
            if ($cli) {
                $text = str_replace('/upload', 'http://www.happy-giraffe.ru/upload', $text);
                echo "<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<<\n" . $text . "\n>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>\n";
            } else {
                $c->content->text = $text;
                $c->content->save();
            }
        }
    }

    private function _giraffe($html)
    {
        $doc = phpQuery::newDocumentXHTML($html, $charset = 'utf-8');

        //заменяем устаревшие теги
        $this->_deprecated();

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
                if ($fontSize == $maxFontSize) {
                    pq($s)->replaceWith('<h2>'. pq($s)->html() . '</h2>');
                }
            }
        }

        //заменяем длинные заголовки на p
        $this->_extraHeaders();

        //вычищаем всё из заголовков
        foreach (pq(':header') as $h) {
            pq($h)->html(pq($h)->text());
            pq(pq($h)->parents(':last'))->replaceWith(pq($h));
        }

        //убираем лишние теги
        while (count(pq('span')) > 0) {
            foreach (pq('span') as $s) {
                pq($s)->replaceWith((string) pq($s)->html());
            }
        }

        //чистим стили
        $this->_clearStyle();

        //удаляем пустые параграфы
        $this->_emptyParagraphs();

        //правим картинки
        $this->_images();

        //выделяем лид
        foreach (pq(':header:first')->prevAll('p') as $e) {
            pq($e)->html('<em>' . pq($e)->text() . '</em>');
        }

        //чистим маркированные списки
        $this->_lists();

        //убираем длинные стронги
        foreach (pq('strong') as $s) {
            if (mb_strlen($this->_htmltrim(pq($s)->parents('p')->text()), 'utf-8') == mb_strlen($this->_htmltrim(pq($s)->text()), 'utf-8')) {
                pq($s)->replaceWith((string) pq($s)->html());
            }
        }

        //убираем курсив с выделенного жирным
        foreach (pq('em') as $e) {
            if (count(pq($e)->parent('strong')) > 0 || count(pq($e)->children('strong')) > 0) {
                pq($e)->replaceWith(pq($e)->html());
            }
        }

        return $doc;
    }

    private function _nonGiraffe($html)
    {
        $doc = phpQuery::newDocumentXHTML($html, $charset = 'utf-8');

        $allowedTags = ':header, p, a, ul, ol, li, img, div';

        //заменяем устаревшие теги
        $this->_deprecated();

        //заменяем длинные заголовки на p
        $this->_extraHeaders();

        //убираем лишние теги
        while (count(pq(':not(' . $allowedTags .')')) > 0) {
            foreach (pq(':not(' . $allowedTags .')') as $s) {
                pq($s)->replaceWith((string) pq($s)->html());
            }
        }

        //чистим стили
        $this->_clearStyle();

        //удаляем пустые параграфы
        $this->_emptyParagraphs();

        //правим картинки
        $this->_images();

        //чистим маркированные списки
        $this->_lists();

        return $doc;
    }

    private function _htmltrim($string)
    {
        $pattern = '(?:[ \t\n\r\x0B\x00\x{A0}\x{AD}\x{2000}-\x{200F}\x{201F}\x{202F}\x{3000}\x{FEFF}]|&nbsp;|<br\s*\/?>)+';
        return preg_replace('/^' . $pattern . '|' . $pattern . '$/u', '', $string);
    }

    private function _images()
    {
        foreach (pq('img') as $e) {
            $style = pq($e)->attr('style');
            if (preg_match('/float:\s*(\w+)/', $style, $matches)) {
                $float = $matches[1];
                $style = preg_replace('/(?:margin|float):[^;]*;\s*/', '', $style);
                pq($e)->attr('class', 'content-img-' . $float);
                pq($e)->attr('style', $style);
                if (pq($e)->attr('style') == '') {
                    pq($e)->removeAttr('style');
                }

                pq($e)->insertBefore(pq($e)->parents(':last'));
            }
        }
    }

    private function _deprecated()
    {
        foreach (pq('b') as $e) {
            pq($e)->replaceWith('<strong>' . pq($e)->html() . '</strong>');
        }
        foreach (pq('i') as $e) {
            pq($e)->replaceWith('<em>' . pq($e)->html() . '</em>');
        }
    }

    private function _extraHeaders()
    {
        foreach (pq(':header') as $e) {
            if (mb_strlen(pq($e)->text(), 'utf-8') > 70) {
                pq($e)->replaceWith('<p>' . pq($e)->html() . '</p>');
            }
        }
    }

    private function _emptyParagraphs()
    {
        foreach (pq('p') as $e) {
            if ($this->_htmltrim(pq($e)->text()) == '') {
                pq($e)->remove();
            }
        }
    }

    private function _clearStyle()
    {
        foreach (pq(':not(img, div)') as $e) {
            pq($e)->removeAttr('style');
        }
    }

    private function _lists()
    {
        foreach (pq('li') as $l) {
            pq($l)->text(preg_replace('/^\s*-\s?/', '', pq($l)->text()));
        }
    }
}