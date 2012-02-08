<?php
class RatingCache extends EMongoDocument
{
    public $entity_id;
    public $entity_name;
    public $ratings;
    public $created_date;

    public function getCollectionName()
    {
        return 'ratings';
    }

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function rules()
    {
        return array(
            array('entity_id, entity_name, ratings, created_date', 'safe'),
        );
    }

    /**
     * @static
     * @param CActiveRecord $entity
     * @param array $socials
     * @param string $url
     * @return RatingCache
     */
    public static function checkCache($entity, $socials, $url)
    {
        $entity_id = (int)$entity->primaryKey;
        $entity_name = get_class($entity);

        $criteria = new EMongoCriteria;
        $criteria->entity_id('==', $entity_id);
        $criteria->entity_name('==', $entity_name);
        $model = RatingCache::model()->find($criteria);
        if(!$model)
        {
            $keys = array();
            foreach(array_keys($socials) as $social_key)
                $keys[$social_key] = Rating::countByEntity($entity, $social_key);
            $model = new RatingCache;
            $model->entity_id = $entity_id;
            $model->entity_name = $entity_name;
            $model->ratings = $keys;
            $model->created_date = time();
            $model->save();
        }
        elseif($model->created_date < time() - 1)
        {
            $model->created_date = time();
            $model->save();
            self::updateCache($entity, $url);
        }
        return $model;
    }


    /**
     * @static
     * @param CActiveRecord $entity
     * @param string $url
     * @return bool
     */
    public static function updateCache($entity, $url)
    {
        $entity_id = (int)$entity->primaryKey;
        $entity_name = get_class($entity);

        $criteria = new EMongoCriteria;
        $criteria->entity_id('==', $entity_id);
        $criteria->entity_name('==', $entity_name);
        $model = RatingCache::model()->find($criteria);
        if(!$model)
            return false;
        foreach($model->ratings as $social_key => $rating)
        {
            switch($social_key)
            {
                case 'tw' :
                    $response = CJSON::decode(file_get_contents('http://urls.api.twitter.com/1/urls/count.json?url=' . urlencode($url)));
                    $count = $response['count'];
                    break;
                case 'fb' :
                    $response = CJSON::decode(file_get_contents('https://api.facebook.com/method/fql.query?query=' . urlencode('select total_count from link_stat where url="' . $url . '"') . '&format=json'));
                    $count = isset($response[0]) && isset($response[0]['total_count']) ? $response[0]['total_count'] : 0;
                    break;
                case 'vk' :
                    $response = file_get_contents('http://vk.com/share.php?act=count&index=1&url=' . urlencode($url) . '&format=json&callback=?');
                    preg_match('|\((?:\d+),\s?(\d+)\)|', $response, $matches);
                    $count = $matches[1];
                    break;
                case 'mr' :
                    $response = CJSON::decode(file_get_contents('http://connect.mail.ru/share_count?url_list=' . urlencode($url)));
                    $count = count($response) > 0 && isset($response[$url]) && isset($response[$url]['shares']) ? $response[$url]['shares'] : 0;
                    break;
                case 'ok' :
                    $response = file_get_contents('http://www.odnoklassniki.ru/dk?st.cmd=extOneClickLike&uid=odklocs0&ref=' . urlencode($url));
                    preg_match("/^ODKL.updateCountOC\('[\d\w]+','(\d+)','(\d+)','(\d+)'\);$/i", $response, $matches);
                    $count = $matches[1];
                    break;
                case 'gp' :
                    $curl = curl_init();
                    curl_setopt($curl, CURLOPT_URL, "https://clients6.google.com/rpc");
                    curl_setopt($curl, CURLOPT_POST, 1);
                    curl_setopt($curl, CURLOPT_POSTFIELDS, '[{"method":"pos.plusones.get","id":"p","params":{"nolog":true,"id":"' . $url . '","source":"widget","userId":"@viewer","groupId":"@self"},"jsonrpc":"2.0","key":"p","apiVersion":"v1"}]');
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
                    $curl_results = curl_exec ($curl);
                    curl_close ($curl);

                    $json = CJSON::decode($curl_results);
                    var_dump($curl_results);
                    break;
                default : $count = 0;
            }
            $model->ratings[$social_key] = $count;
            Rating::saveByEntity($entity, $social_key, $count);
        }
    }
}
