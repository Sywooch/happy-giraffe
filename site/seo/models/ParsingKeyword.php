<?php

/**
 * This is the model class for table "parsing_keywords".
 *
 * The followings are the available columns in table 'parsing_keywords':
 * @property integer $keyword_id
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
     * @param null|int $wordstat
     * @return bool
     */
    public static function addNewKeyword($keyword, $wordstat = null)
    {
        $model = new ParsingKeyword();
        $model->keyword_id = $keyword->id;
        $model->priority = 0;
        $model->type = 1;
        if ($wordstat !== null) {
            $model->updated = date("Y-m-d H:i:s");
        }
        //если 3 слова и менее - добавляем на парсинг по этому слова
        if (substr_count($keyword->name, ' ') < 3)
            $model->priority = 10;

        try {
            $model->save();
        } catch (Exception $e) {
        }
    }

    /**
     * Обновляет частоту слова
     * @param $value значение частоты wordstat
     * @return bool
     */
    public function updateWordstat($value)
    {
        try {
            Keyword::model()->updateByPk($this->keyword_id, array('wordstat' => $value));
        } catch (Exception $err) {
            sleep(1);
            return $this->updateWordstat($value);
        }
        $this->updated = date("Y-m-d H:i:s");
        $this->priority = 0;
        return $this->save();
    }

    public static function wordstatParsed($keyword_id)
    {
        $res = self::model()->model()->updateByPk($keyword_id, array('priority' => 0, 'updated' => date("Y-m-d H:i:s")));

        if (empty($res)) {
            $model = self::model()->findByPk($keyword_id);
            if ($model === null) {
                $model = new ParsingKeyword();
                $model->keyword_id = $keyword_id;
                $model->priority = 0;
                $model->updated = date("Y-m-d H:i:s");
                try {
                    $model->save();
                } catch (Exception $e) {
                }
            }
        }
    }
}