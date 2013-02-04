<?php

/**
 * This is the model class for table "keywords__folders".
 *
 * The followings are the available columns in table 'keywords__folders':
 * @property string $id
 * @property string $user_id
 * @property string $name
 * @property integer $color
 * @property integer $type
 *
 * The followings are the available model relations:
 * @property SeoUser $user
 * @property Keyword[] $keywords
 */
class KeywordFolder extends HActiveRecord
{
    const TYPE_REGULAR = 0;
    const TYPE_FAVOURITES = 1;
    const TYPE_STRIKE_OUT = 2;

    const COLOR_RED = 1;
    const COLOR_BLUE = 2;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return KeywordFolder the static model class
     */
    public static function model($className = __CLASS__)
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
        return 'keywords__folders';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('user_id, name', 'required'),
            array('color, type', 'numerical', 'integerOnly' => true),
            array('user_id', 'length', 'max' => 11),
            array('name', 'length', 'max' => 100),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, user_id, name, color', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'user' => array(self::BELONGS_TO, 'SeoUser', 'user_id'),
            'keywords' => array(self::MANY_MANY, 'Keyword', 'keywords__folders_keywords(folder_id, keyword_id)'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'user_id' => 'User',
            'name' => 'Name',
            'color' => 'Color',
        );
    }

    /**
     * @return KeywordFolder[]
     */
    public static function getMyFolders()
    {
        return self::model()->findAll('user_id=:me AND type=:regular', array(
            ':me' => Yii::app()->user->id,
            ':regular' => self::TYPE_REGULAR
        ));
    }

    //****************************************************************************************************/
    /******************************************* FAVOURITES **********************************************/
    /*****************************************************************************************************/

    /**
     * @return KeywordFolder
     */
    public static function getFavourites()
    {
        $model = self::model()->findByAttributes(array(
            'user_id' => Yii::app()->user->id,
            'type' => self::TYPE_FAVOURITES
        ));

        if ($model !== null)
            return $model;
        $model = new self;
        $model->type = self::TYPE_FAVOURITES;
        $model->user_id = Yii::app()->user->id;
        $model->save();

        return $model;
    }

    /**
     * @param $keyword_ids int[]|int
     */
    public static function addToFavourites($keyword_ids)
    {
        $model = self::getFavourites();
        $model->addToFolder($keyword_ids);
    }

    /**
     * @param $keyword_id int
     */
    public static function toggleFavourites($keyword_id)
    {
        $model = self::getFavourites();
        $model->toggleKeyword($keyword_id);
    }


    //****************************************************************************************************/
    /********************************************** STRIKE OUT *******************************************/
    /*****************************************************************************************************/
    /**
     * @return KeywordFolder
     */
    public static function getStrikeOutFolder()
    {
        $model = self::model()->findByAttributes(array(
            'user_id' => Yii::app()->user->id,
            'type' => self::TYPE_STRIKE_OUT
        ));

        if ($model !== null)
            return $model;
        $model = new self;
        $model->type = self::TYPE_STRIKE_OUT;
        $model->user_id = Yii::app()->user->id;
        $model->save();

        return $model;
    }

    /**
     * @param $keyword_ids int[]|int
     */
    public static function StrikeOut($keyword_ids)
    {
        $model = self::getStrikeOutFolder();
        $model->addToFolder($keyword_ids);
    }

    /**
     * @param $keyword_id int
     */
    public static function toggleStrikeOut($keyword_id)
    {
        $model = self::getStrikeOutFolder();
        $model->toggleKeyword($keyword_id);
    }

    //****************************************************************************************************/
    /********************************************** FOLDERS **********************************************/
    /*****************************************************************************************************/
    /**
     * @param $keyword_ids int[]|int
     */
    public function addToFolder($keyword_ids)
    {
        if (!is_array($keyword_ids))
            $keyword_ids = array($keyword_ids);
        foreach ($keyword_ids as $keyword_id) {
            try {
                Yii::app()->db_seo->createCommand()->insert('keywords__folders_keywords',
                    array('folder_id' => $this->id, 'keyword_id' => $keyword_id));
            } catch (Exception $err) {

            }
        }
    }

    /**
     * @param $keyword_ids int[]|int
     */
    public function removeFromFolder($keyword_ids)
    {
        if (!is_array($keyword_ids))
            $keyword_ids = array($keyword_ids);
        foreach ($keyword_ids as $keyword_id) {
            Yii::app()->db_seo->createCommand()->delete('keywords__folders_keywords',
                'folder_id = :folder_id AND keyword_id = :keyword_id',
                array(':folder_id' => $this->id, ':keyword_id' => $keyword_id));
        }
    }

    /**
     * @param $keyword_id int
     */
    public function toggleKeyword($keyword_id)
    {
        $exist = Yii::app()->db_seo->createCommand()->select('keyword_id')
            ->from('keywords__folders_keywords')
            ->where('folder_id = :folder_id AND keyword_id = :keyword_id',
            array(':folder_id' => $this->id, ':keyword_id' => $keyword_id))
            ->queryScalar();

        if (empty($exist))
            $this->removeFromFolder($keyword_id);
        else
            $this->addToFolder($keyword_id);
    }

    /**
     * @return int
     */
    public function keywordsCount()
    {
        return Yii::app()->db_seo->createCommand()
            ->select('count(*)')
            ->from('keywords__folders_keywords')
            ->where('folder_id=' . $this->id)
            ->queryScalar();
    }
}