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
    public $proxy;

    public function actionUpdateViews()
    {
        Yii::import('site.frontend.extensions.YiiMongoDbSuite.*');
        Yii::import('site.common.models.mongo.Rating');

        $ratings = Rating::model()->findAll(array(
            'conditions' => array(
                'entity_name' => array(
                    'in' => array(
                        'CommunityContent',
                        'BlogContent',
                    ),
                ),
            ),
        ));

        foreach ($ratings as $r) {
            $model = CActiveRecord::model($r->entity_name)->findByPk($r->entity_id);
            if ($model !== null) {
                $model->rate = $r->sum;
                $model->save(false);
            }
        }
    }

    public function actionCutConvert()
    {
        Yii::import('site.frontend.extensions.ESaveRelatedBehavior');
        Yii::import('site.frontend.components.CutBehavior');
        $community = CommunityContent::model()->full()->findAll();
        foreach ($community as $model) {
            if (!$model->content || !$model->content->text) {
                echo 'Беда!!!11 ID: ' . $model->id . ' --- ';
                continue;
            }
            $p = new CHtmlPurifier();
            $p->options = array(
                'URI.AllowedSchemes' => array(
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
        while (count(pq(':not(' . $allowedTags . ')')) > 0) {
            foreach (pq(':not(' . $allowedTags . ')') as $s) {
                pq($s)->replaceWith((string)pq($s)->html());
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
                    pq($s)->replaceWith('<h2>' . pq($s)->html() . '</h2>');
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

    public function actionCleanImages()
    {
        Yii::import('site.frontend.extensions.ESaveRelatedBehavior');
        Yii::import('site.frontend.extensions.image.Image');
        Yii::import('site.frontend.helpers.*');

        $community = CommunityContent::model()->full()->findAll();
        foreach ($community as $model) {
            if (!$model->content || !$model->content->text) {
                echo 'Беда!!!11 ID: ' . $model->id . ' --- ';
                continue;
            }

            if ($this->containsJunk($model->preview)) {
                $model->preview = $this->cleanAttributes($model->preview);
                //$model->preview = $this->fixImage($model->preview);
                $model->update('preview');
            }
            if ($this->containsJunk($model->content->text)) {
                $model->content->text = $this->cleanAttributes($model->content->text);
                $model->content->text = $this->fixImage($model->content->text);
                $model->content->update('text');
            }
        }
    }

    public function containsJunk($attr)
    {
        foreach ($this->junk_parts as $part)
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
        for ($i = 0; $i < count($matches[0]); $i++) {
            $user_id = $matches[1][$i];
            $pic_name = $matches[2][$i];

            $model = AlbumPhoto::model()->findByAttributes(array('author_id' => $user_id, 'fs_name' => $pic_name));
            if ($model) {
                $model->getPreviewUrl(650, 650);

                return str_replace('src="http://img.happy-giraffe.ru/thumbs/300x185/',
                    'src="http://img.happy-giraffe.ru/thumbs/650x650/', $attr);
            } else {
                echo 'picture not found';
            }
        }

        return $attr;
    }

    public function actionDistribute(array $editors)
    {
        $offset = 0;
        foreach ($editors as $e) {
            $sql = "UPDATE `community__contents` `t1`
                LEFT OUTER JOIN
                (
                SELECT `content`.`id`
                FROM `community__contents` `content`
                JOIN `community__rubrics` `rubric` ON  `content`.`rubric_id` = `rubric`.`id`
                WHERE `content`.`type_id` = 1
                AND `rubric`.`community_id` != 22
                AND `rubric`.`community_id` != 23
                AND `content`.`editor_id` IS NULL
                AND `rubric`.`community_id` IS NOT NULL
                AND `content`.`by_happy_giraffe` = 0
                ORDER BY `content`.`id` ASC
                LIMIT :offset, 500
                ) `t2` ON `t1`.`id` = `t2`.`id`
                SET `t1`.`editor_id` = :editor_id
                WHERE `t2`.`id` IS NOT NULL";
            $connection = Yii::app()->db;
            $command = $connection->createCommand($sql);
            $command->bindParam(":editor_id", $e, PDO::PARAM_INT);
            $command->bindParam(":offset", $offset, PDO::PARAM_INT);
            $command->execute();
            $offset += 500;
        }
    }

    public function actionFixLinks()
    {
        $find = 'http://www.nepropadu.ru/uploads/images';
        $replace = 'http://nepropadu.ru/uploads/images';

        echo $this->fixLink('community__contents', 'preview', $find, $replace) . "\n";
        echo $this->fixLink('community__posts', 'text', $find, $replace) . "\n";
        echo $this->fixLink('comments', 'text', $find, $replace) . "\n";
    }

    public function actionFixImages()
    {
        echo $this->fixLink('community__contents', 'preview', '/club/upload/images/', '/upload/images/') . "\n";
        echo $this->fixLink('community__posts', 'text', '/club/upload/images/', '/upload/images/') . "\n";
    }

    public function actionFixUrls()
    {
        echo $this->fixBlogUrl('community__contents', 'preview') . "\n";
        echo $this->fixBlogUrl('community__posts', 'text') . "\n";
        echo $this->fixBlogUrl('comments', 'text') . "\n";

        echo $this->fixCommunityUrl('community__contents', 'preview') . "\n";
        echo $this->fixCommunityUrl('community__posts', 'text') . "\n";
        echo $this->fixCommunityUrl('comments', 'text') . "\n";
    }

    public function fixBlogUrl($table, $field_name)
    {
        $j = 0;
        $k = 0;

        $raws = 1;
        while (!empty($raws)) {
            $raws = Yii::app()->db->createCommand()
                ->select('*')
                ->from($table)
                ->limit(1000)
                ->offset($k * 1000)
                ->queryAll();

            foreach ($raws as $raw) {
                if (strpos($raw[$field_name], '/blog/view/content_id/')) {
                    preg_match_all('/\/blog\/view\/content_id\/([\d]+)\//', $raw[$field_name], $matches);
                    for ($i = 0; $i < count($matches[0]); $i++) {
                        $post = BlogContent::model()->findByPk($matches[1][$i]);
                        $field_value = str_replace('/blog/view/content_id/' . $post->id . '/', '/user/' . $post->author_id . '/blog/post' . $post->id . '/', $raw[$field_name]);
                        Yii::app()->db->createCommand()
                            ->update($table, array(
                            $field_name => $field_value
                        ), 'id=' . $raw['id']);
                        $j++;
                        echo $post->id . "\n";
                    }
                }
            }

            $k++;
        }
        return $j;
    }

    public function fixCommunityUrl($table, $field_name)
    {
        $j = 0;
        $k = 0;

        $raws = 1;
        while (!empty($raws)) {
            $raws = Yii::app()->db->createCommand()
                ->select('*')
                ->from($table)
                ->limit(1000)
                ->offset($k * 1000)
                ->queryAll();

            foreach ($raws as $raw) {
                if (strpos($raw[$field_name], '/community/view/content_id/')) {
                    preg_match_all('/\/community\/view\/content_id\/([\d]+)\//', $raw[$field_name], $matches);
                    for ($i = 0; $i < count($matches[0]); $i++) {
                        $post = CommunityContent::model()->findByPk($matches[1][$i]);
                        if (isset($post->community_id)) {
                            $field_value = str_replace('/community/' . $post->community_id . '/', '/forum/post/' . $post->id . '/', $raw[$field_name]);
                            Yii::app()->db->createCommand()
                                ->update($table, array(
                                $field_name => $field_value
                            ), 'id=' . $raw['id']);
                            $j++;
                            echo $post->id . "\n";
                        }
                    }
                }
            }

            $k++;
        }
        return $j;
    }

    public function fixLink($table, $field_name, $find, $replace)
    {
        $i = 0;
        $k = 0;

        $raws = 1;
        while (!empty($raws)) {
            $raws = Yii::app()->db->createCommand()
                ->select('*')
                ->from($table)
                ->limit(1000)
                ->offset($k * 1000)
                ->queryAll();

            foreach ($raws as $raw) {
                if (strpos($raw[$field_name], $find)) {
                    $field_value = str_replace($find, $replace, $raw[$field_name]);
                    Yii::app()->db->createCommand()
                        ->update($table, array(
                        $field_name => $field_value
                    ), 'id=' . $raw['id']);
                    $i++;
                }
            }

            $k++;
        }
        return $i;

    }

    public function actionFixRutube()
    {
        echo $this->fixRutube('community__contents', 'preview') . "\n";
        echo $this->fixRutube('community__posts', 'text') . "\n";
        echo $this->fixRutube('comments', 'text') . "\n";
    }

    public function fixRutube($table, $field_name)
    {
        $i = 0;
        $k = 0;

        $raws = 1;
        while (!empty($raws)) {
            $raws = Yii::app()->db->createCommand()
                ->select('*')
                ->from($table)
                ->limit(1000)
                ->offset($k * 1000)
                ->queryAll();

            foreach ($raws as $raw) {
                if (strpos($raw[$field_name], 'http://video.rutube.ru/')) {
                    $field_value = str_replace('http://video.rutube.ru/', 'http://rutube.ru/player.swf?hash=', $raw[$field_name]);
                    Yii::app()->db->createCommand()
                        ->update($table, array(
                        $field_name => $field_value
                    ), 'id=' . $raw['id']);
                    $i++;
                }
            }

            $k++;
        }
        return $i;

    }

    public function actionCheckNameFamous()
    {
        Yii::import('site.frontend.modules.services.modules.names.models.*');
        Yii::import('site.frontend.components.ManyToManyBehavior');
        $names = Name::model()->findAll();
        foreach ($names as $name) {
            foreach ($name->famous as $famous) {
                $path = Yii::getPathOfAlias('site.frontend.www') . DIRECTORY_SEPARATOR . $famous->uploadTo() . $famous->photo;
                if (!file_exists($path))
                    echo 'http://www.happy-giraffe.ru/names/' . $name->slug . "\n";
            }
        }
    }

    public function actionRemoveDeletedVideo($thread)
    {
        $this->getProxy();
        $i = 0;
        $raws = 1;
        while (!empty($raws)) {
            $raws = Yii::app()->db->createCommand()
                ->select('*')
                ->from('community__videos')
                ->limit(100)
                ->offset($thread * 100)
                ->queryAll();

            foreach ($raws as $raw) {
                $link = $raw['link'];
                if ($this->getPageHeader($link, 'http://www.happy-giraffe.ru/')){
                    //remove
                    Yii::app()->db->createCommand()
                        ->delete('community__contents', 'id='.$raw['content_id']);
                }
                $i++;
                //echo $i."\n";
            }
        }
    }

    public function getPageHeader($url, $ref)
    {
        if ($ch = curl_init($url)) {
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:12.0) Gecko/20100101 Firefox/12.0');
            curl_setopt($ch, CURLOPT_REFERER, $ref);

            curl_setopt($ch, CURLOPT_PROXYTYPE, CURLPROXY_SOCKS5);
            curl_setopt($ch, CURLOPT_PROXY, $this->proxy->value);
            curl_setopt($ch, CURLOPT_PROXYUSERPWD, "alexk984:Nokia1111");
            curl_setopt($ch, CURLOPT_PROXYAUTH, 1);
            curl_setopt($ch, CURLOPT_HEADER, 1);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 15);
            curl_setopt($ch, CURLOPT_TIMEOUT, 15);
            $html = curl_exec($ch);
            if ($html === false) {
                //echo "curl error\n";
                return $this->getPageHeader($url, $ref);
            }
            elseif (strpos($html, 'YouTube') === false && strpos($html, 'Rutube') === false) {
                //echo "bad page\n";
                return $this->getPageHeader($url, $ref);
            }elseif (strpos($html, '404 Not Found')){
                echo $url."\n";
                return true;
            }
        }

        return false;
    }

    private function getProxy()
    {
        Yii::import('site.seo.models.*');
        $criteria = new CDbCriteria;
        $criteria->compare('active', 0);
        $criteria->order = 'rand()';

        $transaction = Yii::app()->db_seo->beginTransaction();
        try {
            $this->proxy = Proxy::model()->find($criteria);
            if ($this->proxy === null) {
                Yii::app()->end();
            }

            $this->proxy->active = 1;
            $this->proxy->save();
            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollback();
            Yii::app()->end();
        }
    }
}
