<?php
/**
 * Author: alexk984
 * Date: 13.08.12
 */
class ProxyRefresher
{
    public static function execute()
    {
        $str = file_get_contents('http://awmproxy.com/socks_proxy.txt?');
        $i = 0;
        if (strlen($str) > 10000) {

            $proxies = explode("\n", $str);
            $transaction = Yii::app()->db_seo->beginTransaction();

            try {
                foreach ($proxies as $proxy) {
                    $proxy = trim($proxy);
                    $model = Proxy::model()->find('value="' . $proxy . '"');
                    if ($model === null) {
                        $model = new Proxy;
                        $model->value = $proxy;
                        $model->save();
                        $i++;
                    }
                }
                if (Proxy::model()->count() > 50000){
                    Proxy::model()->deleteAll('rank < 10 order by rank ASC limit 20000');
                }

                $transaction->commit();
            } catch (Exception $e) {
                $transaction->rollback();
                echo 'update proxy failed';
            }
        }

        echo $i.' -new proxies';
    }
}
