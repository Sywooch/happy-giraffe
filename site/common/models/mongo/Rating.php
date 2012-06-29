<?php
class Rating extends EMongoDocument
{
    public $entity_id;
    public $entity_name;
    public $ratings;
    public $sum = 0;

    public function getCollectionName()
    {
        return 'ratings';
    }

    /**
     * @static
     * @param string $className
     * @return $this
     */
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function rules()
    {
        return array(
            array('entity_id, entity_name, ratings', 'safe'),
        );
    }

    public function clearSocials()
    {
        $models = $this->findAll();
        foreach($models as $item)
        {
            if($item->entity_name == 'ContestWork')
                continue;
            if(isset($item->ratings['fb']))
                unset($item->ratings['fb']);
            if(isset($item->ratings['vk']))
                unset($item->ratings['vk']);
            if(isset($item->ratings['tw']))
                unset($item->ratings['tw']);
            if(isset($item->ratings['mr']))
                unset($item->ratings['mr']);
            if(isset($item->ratings['gp']))
                unset($item->ratings['gp']);
            $item->sum = array_sum($item->ratings);
            $item->save();
        }
    }

    public function findByEntity($entity)
    {
        $entity_id = (int)$entity->primaryKey;
        $entity_name = get_class($entity);

        $criteria = new EMongoCriteria;
        $criteria->entity_id('==', $entity_id);
        $criteria->entity_name('==', $entity_name);
        $model = $this->find($criteria);
        if($model)
            return $model;
        return false;
    }

    public function countByEntity($entity, $social_key = false)
    {
        if(($model = $this->findByEntity($entity)) === false)
            return 0;
        if($social_key === false)
            return $model->sum;
        else
            return isset($model->ratings[$social_key]) ? $model->ratings[$social_key] : 0;
    }

    public function saveByEntity($entity, $social_key, $value, $plus = false)
    {
        if(($model = $this->findByEntity($entity)) === false)
        {
            $model = new $this;
            $model->entity_id = (int)$entity->primaryKey;
            $model->entity_name = get_class($entity);
            $model->ratings = array();
            $model->sum = 0;
            $model->save();
        }
        if($social_key == 'yh')
            if(($e = RatingYohoho::model()->saveByEntity($entity)) === false)
                $value = $value * -1;

        $model->ratings[$social_key] = $plus && isset($model->ratings[$social_key]) ? $model->ratings[$social_key] + $value : $value;
        $old_sum = $model->sum;
        $model->sum = array_sum($model->ratings);

        if (isset($entity->rate) && $entity->rate != $model->sum)
        {
            $entity->rate = $model->sum;
            $entity->save(false);
        }

        if (isset($entity->author_id)){
            UserScores::addScores($entity->author_id, ScoreActions::ACTION_LIKE, $model->sum - $old_sum, $entity);
        }

        $model->save();
    }

    public static function updateByApi($entity, $social_key, $url)
    {
        if($social_key == 'yh')
            return false;
        switch($social_key)
        {
            case 'tw' :
                $response = CJSON::decode(file_get_contents('http://urls.api.twitter.com/1/urls/count.json?url=' . $url));
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
                /*$response = file_get_contents('http://www.odnoklassniki.ru/dk?st.cmd=extOneClickLike&uid=odklocs0&ref=' . urlencode($url));
                preg_match("/^ODKL.updateCountOC\('[\d\w]+','(\d+)','(\d+)','(\d+)'\);$/i", $response, $matches);
                $count = $matches[1];*/
                $count = 1;
                break;
            case 'gp' :
                /*$curl = curl_init();
                curl_setopt($curl, CURLOPT_URL, "https://clients6.google.com/rpc");
                curl_setopt($curl, CURLOPT_POST, 1);
                curl_setopt($curl, CURLOPT_POSTFIELDS, '[{"method":"pos.plusones.get","id":"p","params":{"nolog":true,"id":"' . $url . '","source":"widget","userId":"@viewer","groupId":"@self"},"jsonrpc":"2.0","key":"p","apiVersion":"v1"}]');
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($curl, CURLOPT_HTTPHEADER, array('Content-type: application/json'));
                $curl_results = curl_exec ($curl);
                curl_close ($curl);
                $json = CJSON::decode($curl_results);
                $count = $json ? intval( $json[0]['result']['metadata']['globalCounts']['count'] ) : 0;*/
                $count = 1;
                break;
            default : $count = 0;
        }
        Rating::model()->saveByEntity($entity, $social_key, $count);
    }
}
