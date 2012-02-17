<?php

/**
 * This is the model class for table "ratings".
 *
 * The followings are the available columns in table 'ratings':
 * @property integer $entity_id
 * @property string $entity_name
 * @property string $social_key
 * @property integer $value
 */
class Rating extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @return rating the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'ratings';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('entity_id, entity_name, social_key, value', 'required'),
			array('entity_id, value', 'numerical', 'integerOnly'=>true),
			array('entity_name', 'length', 'max'=>50),
			array('social_key', 'length', 'max'=>2),
		);
	}

    /**
     * @static
     * @param CActiveRecord $entity
     * @param string $social_key
     * @return Rating
     */
    public static function findByEntity($entity, $social_key = false)
    {
        $params = array(
            'entity_name' => get_class($entity),
            'entity_id' => $entity->primaryKey,
        );
        if($social_key !== false)
            $params['social_key'] = $social_key;
        if($social_key !== false)
            return self::model()->findByAttributes($params);
        else
            return self::model()->findAllByAttributes($params);
    }

    /**
     * @static
     * @param CActiveRecord $entity
     * @param string $social_key
     * @param bool $cache
     * @return int
     */
    public static function countByEntity($entity, $social_key = false, $cache = false)
    {
        if($cache)
        {
            if($rating = RatingCache::findByEntity($entity, $social_key = false))
            {
                if($social_key)
                    return $rating->ratings[$social_key];
                else
                {
                    $sum = 0;
                    foreach($rating->ratings as $sk => $sv)
                        $sum += $sv;
                    return $sum;
                }
            }
        }
        $model = self::findByEntity($entity, $social_key);
        if($social_key === false)
        {
            $sum = 0;
            foreach($model as $item)
                $sum += $item->value;
            return $sum;
        }
        else if($model)
        {
            return $model->value;
        }
        return 0;
    }


    /**
     * @static
     * @param CActiveRecord $entity
     * @param string $social_key
     * @param int $value
     * @return Rating
     */
    public static function saveByEntity($entity, $social_key, $value, $plus = false)
    {
        $model = self::findByEntity($entity, $social_key);
        if(!$model)
        {
            $model = new Rating;
            $model->entity_name = get_class($entity);
            $model->entity_id = $entity->primaryKey;
            $model->social_key = $social_key;
        }
        $model->value = $plus !== false ? $model->value + $value : $value;
        $model->save();
        if($cache = RatingCache::findByEntity($entity))
        {
            $cache->ratings[$social_key] = $model->value;
            $cache->save();
        }
        return $model;
    }

    public static function chekUserByYohoho($entity, $user_id)
    {
        $where = array(
            ':entity_id' => $entity->primaryKey,
            ':entity_name' => get_class($entity),
            ':social_key' => 'yh',
            ':user_id' => $user_id,
        );
        $user = Yii::app()->db->createCommand()
            ->select('user_id')
            ->from('ratings_yohoho')
            ->where('entity_id=:entity_id and entity_name=:entity_name and social_key=:social_key
                    and user_id=:user_id', $where)
            ->queryRow();
        return $user;
    }

    public static function addUserByYohoho($entity, $user_id)
    {
        $user = self::chekUserByYohoho($entity, $user_id);
        if($user)
           return false;
        $insert = array(
            'entity_id' => $entity->primaryKey,
            'entity_name' => get_class($entity),
            'social_key' => 'yh',
            'user_id' => $user_id,
        );
        Yii::app()->db->createCommand()
            ->insert('ratings_yohoho', $insert);
        self::saveByEntity($entity, 'yh', 2, true);
        return true;
    }

    public static function deleteByYohoho($entity, $user_id)
    {
        $where = array(
            ':entity_id' => $entity->primaryKey,
            ':entity_name' => get_class($entity),
            ':social_key' => 'yh',
            ':user_id' => $user_id,
        );
        Yii::app()->db->createCommand()
            ->delete('ratings_yohoho', 'entity_id=:entity_id and entity_name=:entity_name
                    and social_key=:social_key and user_id=:user_id', $where);
        self::saveByEntity($entity, 'yh', -2, true);
        return false;
    }

    public static function pushUserByYohoho($entity, $user_id)
    {
        if(!$value = self::addUserByYohoho($entity, $user_id))
            $value = self::deleteByYohoho($entity, $user_id);
        return $value;
    }

    public static function updateByApi($entity, $social_key, $url)
    {
        switch($social_key)
        {
            case 'tw' :
                $response = CJSON::decode(file_get_contents('http://urls.api.twitter.com/1/urls/count.json?url=' . urlencode($url)));
                $count = $response['count'];
                echo $count;
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
                $count = $json ? intval( $json[0]['result']['metadata']['globalCounts']['count'] ) : 0;
                break;
            case 'yh' :
                $count = Rating::countByEntity($entity, $social_key);
                break;
            default : $count = 0;
        }
        Rating::saveByEntity($entity, $social_key, $count);
        RatingCache::saveByEntity($entity, $social_key, $count);
    }
}