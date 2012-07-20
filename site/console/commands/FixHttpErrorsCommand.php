<?php
/**
 * User: alexk984
 * Date: 05.07.12
 * Time: 18:14
 */
class FixHttpErrorsCommand extends CConsoleCommand
{
    public $proxy = null;
    public $ch;

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
        echo $this->fixBlogUrl('community__videos', 'text') . "\n";
        echo $this->fixBlogUrl('comments', 'text') . "\n";
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
                if ($this->getPageHeader($link, 'http://www.happy-giraffe.ru/')) {
                    //remove
                    echo $raw['content_id'] . '  ' . $link . "\n";
                    Yii::app()->db->createCommand()
                        ->delete('community__contents', 'id=' . $raw['content_id']);
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
            curl_close($ch);
            if ($html === false) {
                //echo "curl error\n";
                $this->getProxy();
                return $this->getPageHeader($url, $ref);
            } elseif (strpos($html, 'YouTube') === false && strpos($html, 'Rutube') === false) {
                return false;
            } elseif (strpos($html, '404 Not Found')) {
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
            if ($this->proxy !== null) {
                $this->proxy->active = 0;
                $this->proxy->save();
            }
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

    public function actionFixMalformed()
    {
        echo $this->fixMalformed('community__contents', 'preview') . "\n";
        echo $this->fixMalformed('community__posts', 'text') . "\n";
        echo $this->fixMalformed('comments', 'text') . "\n";
    }

    public function fixMalformed($table, $field_name)
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
                if (strpos($raw[$field_name], 'http://http/')) {
                    $field_value = str_replace('http://http/', 'http://', $raw[$field_name]);
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

    function getHTTPStatus($url)
    {
        if (!isset($this->ch))
            $this->ch = curl_init();

        curl_setopt($this->ch, CURLOPT_URL, $url);
        curl_setopt($this->ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:12.0) Gecko/20100101 Firefox/12.0');
        curl_setopt($this->ch, CURLOPT_HEADER, 1);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($this->ch, CURLOPT_FOLLOWLOCATION, 1);
        curl_setopt($this->ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($this->ch, CURLOPT_TIMEOUT, 30);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);

        curl_exec($this->ch);

        return curl_getinfo($this->ch, CURLINFO_HTTP_CODE);
    }

    public function actionCheckErrors($file)
    {
        if (($handle = fopen(__DIR__ . '/' . $file, "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                $url = $data[0];
                if (strpos($url, 'http') !== FALSE) {
                    $status = self::getHTTPStatus($url);
                    //if ($status != '200')
                        echo  $status . ' - ' . $url . "\r\n";
                }


            }
            fclose($handle);
        }
    }
}
