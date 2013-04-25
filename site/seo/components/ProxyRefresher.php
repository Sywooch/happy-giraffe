<?php
/**
 * Class ProxyRefresher
 *
 * Обновляет прокси (удаляет плохие, добавляет новые), запускается по крону раз в час
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */
class ProxyRefresher
{
    /**
     * Добавляет новые прокси и удаляет старые с низким рейтингом так чтобы их было не более 40,000
     */
    public static function executeMongo()
    {
        $str = file_get_contents('http://awmproxy.com/socks_proxy.txt?');
        if (strlen($str) > 10000) {
            $proxies = explode("\n", $str);
            foreach ($proxies as $proxy)
                ProxyMongo::model()->addNewProxy($proxy);

            ProxyMongo::model()->removeExtra();
        }
    }
}
