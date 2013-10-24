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
    public function actionSync($code)
    {
        $i = 0;
        $parser = new HhParser($code);
        $models = HhResume::model()->findAll();
        foreach ($models as $m) {
            echo ++$i . "\n";
            $data = $parser->parseResume($m->_id);
            foreach ($data as $attribute => $value)
                $m->$attribute = $value;
            $m->save();
        }
    }

    public function actionParse($keyword)
    {
        // authorize
        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => 'http://hh.ru/logon.do',
            CURLOPT_COOKIEJAR => $this->getCookie(),
            CURLOPT_COOKIEFILE => $this->getCookie(),
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => array(
                'username' => 'mira@happy-giraffe.ru',
                'password' => 'headhunt',
            ),
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_USERAGENT => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/30.0.1599.101 Safari/537.36',
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
            CURLOPT_USERAGENT => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_8_5) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/30.0.1599.101 Safari/537.36',
        ));

        for ($i = 0; true; $i++) {
            curl_setopt($ch, CURLOPT_URL, $this->getPageUrl($keyword, $i));
            $response = curl_exec($ch);
            if (curl_getinfo($ch, CURLINFO_HTTP_CODE) == 200)
                $this->parsePage($response, $keyword);
            else
                break;
        }
    }

    protected function getPageUrl($keyword, $page)
    {
        $params = array(
            'text' => $keyword,
            'logic' => 'normal',
            'pos' => 'full_text',
            'a' => '113',
            's' => '1.221',
            'order' => '2',
            'items' => '100',
            'lang' => 'eng',
            'degree' => '0',
            'schedule' => '0',
            'searchPeriod' => '30',
            'wRelocation' => 'true',
            'woAge' => 'true',
            'woGender' => 'true',
            'gen' => '-1',
            'cur' => 'RUR',
            'woSalary' => 'true',
            'profArea' => '1',
            'edu' => '0',
            'employment' => '0',
        );
        if ($page != 0)
            $params['page'] = $page;

        return 'http://hh.ru/resumesearch/result?' . http_build_query($params);
    }

    protected function parsePage($response, $keyword)
    {
        $html = str_get_html($response);
        foreach ($html->find('a[itemprop=jobTitle]') as $a) {
            $url = $a->getAttribute('href');
            preg_match('#\/resume\/(\w+)\?#', $url, $matches);
            $hash = $matches[1];
            try {
                $model = new HhResume();
                $model->_id = $hash;
                $model->keyword = $keyword;
                $model->save();
            } catch (MongoCursorException $e) {}
        }
    }

    protected function getCookie()
    {
        return Yii::getPathOfAlias('site.common.cookies') . DIRECTORY_SEPARATOR . 'hh.txt';
    }
}