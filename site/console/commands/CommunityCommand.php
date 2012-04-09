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

    public $junk_parts = array(' alt="null"', ' title="null"', 'http://img.happy-giraffe.ru/thumbs/300x185/');

    public function actionCleanImages(){
        Yii::import('site.frontend.extensions.ESaveRelatedBehavior');
        Yii::import('site.frontend.extensions.image.Image');
        Yii::import('site.frontend.helpers.*');

        $community = CommunityContent::model()->full()->findAll();
        foreach($community as $model)
        {
            if(!$model->content || !$model->content->text)
            {
                echo 'Беда!!!11 ID: ' . $model->id . ' --- ';
                continue;
            }

            if ($this->containsJunk($model->preview)){
                $model->preview = $this->cleanAttributes($model->preview);
                $model->preview = $this->fixImage($model->preview);
                $model->update('preview');
            }
            if($this->containsJunk($model->content->text)){
                $model->content->text = $this->cleanAttributes($model->content->text);
                $model->content->text = $this->fixImage($model->content->text);
                $model->content->update('text');
            }
        }
    }

    public function containsJunk($attr)
    {
        foreach($this->junk_parts as $part)
            if (strpos($attr, $part))
                return true;
        return false;
    }

    public function cleanAttributes($attr)
    {
        $attr = $this->cleanAttribute($attr, ' alt="null"');
        $attr = $this->cleanAttribute($attr, ' title="null"');
        return $attr;
    }

    public function cleanAttribute($attr, $part)
    {
        if (strpos($attr, $part))
            return str_replace($part, '', $attr);
        else
            return $attr;
    }

    public function fixImage($attr)
    {
        preg_match_all("|src=\"http://img.happy-giraffe.ru/thumbs/300x185/([\d]+)/([\w\.]+)\"|", $attr, $matches);
        for ($i=0; $i < count($matches[0]); $i++) {
            $user_id = $matches[1][$i];
            $pic_name = $matches[2][$i];

            $model = AlbumPhoto::model()->findByAttributes(array('author_id' => $user_id, 'fs_name' => $pic_name));
            if ($model) {
                $model->getPreviewUrl(650, 650);

                return str_replace('src="http://img.happy-giraffe.ru/thumbs/300x185/',
                    'src="http://img.happy-giraffe.ru/thumbs/650x650/', $attr);
            }else{
                echo 'picture not found';
            }
        }

        return $attr;
    }
}
