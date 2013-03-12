<?php

/**
 * This is the model class for table "parsing_keywords".
 *
 * The followings are the available columns in table 'parsing_keywords':
 * @property integer $keyword_id
 * @property integer $active
 * @property integer $priority
 * @property integer $type
 * @property integer $updated
 *
 * The followings are the available model relations:
 * @property Keyword $keyword
 */
class ParsingKeyword extends CActiveRecord
{
    const TYPE_WORDSTAT = 0;
    const TYPE_SIMPLE_WORDSTAT = 1;
    const TYPE_SEASON = 2;

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return ParsingKeyword the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'parsing_keywords';
    }

    public function getDbConnection()
    {
        return Yii::app()->db_keywords;
    }
    public function rules()
    {
        return array(
            array('keyword_id', 'required'),
        );
    }
    public function relations()
    {
        return array(
            'keyword' => array(self::BELONGS_TO, 'Keyword', 'keyword_id'),
        );
    }


    /**
     * @param Keyword $keyword
     * @param int $priority
     * @param null|int $wordstat
     * @return bool
     */
    public static function addNewKeyword($keyword, $priority = 0, $wordstat = null)
    {
        $model = new ParsingKeyword();
        $model->keyword_id = $keyword->id;
        $model->priority = $priority;
        if ($wordstat !== null){
            $model->updated = date("Y-m-d H:i:s");
            //если 3 слова - добавляем на парсинг по этому слова
            if (substr_count($keyword->name, ' ') < 3){
                $model->priority = 10;
            }
        }

        try {
            $model->save();
        } catch (Exception $e) {
        }
    }

    public function updateWordstat($value)
    {
        Yii::app()->db_seo->createCommand()->update(Keyword::model()->tableName(),
            array('wordstat' => $value),
            'id=:id',
            array(':id' => $this->keyword_id));
        $this->updated = date("Y-m-d H:i:s");
        $this->priority = 0;
        $this->active = 0;
        $this->update(array('updated', 'priority', 'active'));
    }

    public static function wordstatParsed($keyword_id)
    {
        $model = self::model()->findByPk($keyword_id);
        if ($model !== null) {
            $model->updated = date("Y-m-d H:i:s");
            $model->priority = 0;
            $model->save();
        } else {
            $model = new ParsingKeyword();
            $model->keyword_id = $keyword_id;
            $model->updated = date("Y-m-d H:i:s");
            try{
                $model->save();
            } catch (Exception $e) {
            }
        }
    }
}