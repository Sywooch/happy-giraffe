<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 10/24/13
 * Time: 11:26 AM
 * To change this template use File | Settings | File Templates.
 */

include_once Yii::getPathOfAlias('site.frontend.vendor.simplehtmldom_1_5') . DIRECTORY_SEPARATOR . 'simple_html_dom.php';
Yii::import('site.seo.models.mongo.ProxyMongo');
Yii::import('site.frontend.extensions.YiiMongoDbSuite.*');
Yii::import('site.common.models.mongo.HhResume');
Yii::import('site.seo.components.ProxyParserThread');
Yii::import('site.common.components.Hh.*');

class HhCommand extends CConsoleCommand
{
    const LOGIN = 'n.ikita@happy-giraffe.ru';
    const PASSWORD = 'happy-giraffe';

    public function actionSync($code)
    {
        $i = 0;
        $parser = new HhParser($code);
        $criteria = new EMongoCriteria();
        $criteria->parsed('==', false);
        $models = HhResume::model()->findAll($criteria);
        foreach ($models as $m) {
            echo ++$i . ' : ' . $m->_id . "\n";
            $data = $parser->parseResume($m->_id);
            if ($data !== false) {
                foreach ($data as $attribute => $value)
                    $m->$attribute = $value;
                $m->parsed = time();
                $m->save();
            } else {
                Yii::app()->end();
            }
        }
    }

    public function actionParse($query)
    {
        // authorize
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => 'http://astrakhan.hh.ru/logon.do',
            CURLOPT_COOKIEJAR => $this->getCookie(),
            CURLOPT_COOKIEFILE => $this->getCookie(),
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => array(
                'username' => self::LOGIN,
                'password' => self::PASSWORD,
            ),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_USERAGENT => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.152 Safari/537.3',
        ));
        curl_exec($ch);
        curl_close($ch);

        // parse
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_COOKIEJAR => $this->getCookie(),
            CURLOPT_COOKIEFILE => $this->getCookie(),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_USERAGENT => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_9_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750.152 Safari/537.3',
        ));

        for ($i = 0; true; $i++) {
            curl_setopt($ch, CURLOPT_URL, $this->getPageUrl($query, $i));
            $response = curl_exec($ch);
            if (curl_getinfo($ch, CURLINFO_HTTP_CODE) == 200)
                $this->parsePage($response, $query);
            else
                break;
        }
    }

    protected function getPageUrl($query, $page)
    {
        $query .= '&items=100';
        $query .= '&page=' . $page;

        return 'http://hh.ru/resumesearch/result?' . $query;
    }

    protected function parsePage($response, $query)
    {
        $html = str_get_html($response);

        foreach ($html->find('div[data-hh-resume-hash]') as $a) {
            $hash = $a->getAttribute('data-hh-resume-hash');
            try {
                $model = new HhResume();
                $model->_id = $hash;
                $model->query = $query;
                $model->save();
            } catch (MongoCursorException $e) {}
        }
    }

    protected function getCookie()
    {
        return Yii::getPathOfAlias('application.runtime') . DIRECTORY_SEPARATOR . 'hh.txt';
    }
}