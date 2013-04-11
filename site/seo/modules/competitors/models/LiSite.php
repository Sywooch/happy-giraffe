<?php

/**
 * This is the model class for table "li_sites".
 *
 * The followings are the available columns in table 'li_sites':
 * @property integer $id
 * @property string $url
 * @property string $site_url
 * @property integer $rubric_id
 * @property integer $visits
 * @property string $password
 * @property integer $public
 * @property integer $active
 * @property integer $type
 */
class LiSite extends HActiveRecord
{
    const TYPE_LI = 1;
    const TYPE_MAIL = 2;

	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LiSite the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return CDbConnection database connection
	 */
	public function getDbConnection()
	{
		return Yii::app()->db_seo;
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'li_sites';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		return array(
			array('url, site_url', 'required'),
			array('visits, public, active', 'numerical', 'integerOnly'=>true),
			array('url, site_url, password', 'length', 'max'=>100),

		);
	}

    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'url' => 'Url',
            'site_url' => 'Site Url',
            'password' => 'Password',
            'public' => 'Public',
            'active' => 'Active',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search()
    {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria=new CDbCriteria;

        $criteria->compare('id',$this->id,true);
        $criteria->compare('url',$this->url,true);
        $criteria->compare('site_url',$this->site_url,true);
        $criteria->compare('password',$this->password,true);
        $criteria->compare('public',$this->public);
        $criteria->compare('active',$this->active);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
            'pagination' => array('pageSize' => 100),
        ));
    }

    public static function parseRubric()
    {
        $rubrics = LiSiteRubric::model()->findAll();

        $li_sites = LiSite::model()->findAll('type=' . LiSite::TYPE_LI . ' AND public=1 AND rubric_id IS NULL');
        $i = 1;
        foreach ($li_sites as $li_site) {
            $html = file_get_contents('http://www.liveinternet.ru/stat/' . $li_site->url . '/');
            $document = phpQuery::newDocument($html);
            $link = $document->find('div:eq(3) a:eq(2)');
            $cat = trim(str_replace('/rating/ru/', '', pq($link)->attr('href')), '/');
            foreach ($rubrics as $rubric)
                if ($rubric->url == $cat) {
                    $li_site->rubric_id = $rubric->id;
                    $li_site->save();
                }
            if (empty($cat)){
                $li_site->public = 0;
                $li_site->save();
            }

            $i++;
            echo $i."\n";
        }
    }
}