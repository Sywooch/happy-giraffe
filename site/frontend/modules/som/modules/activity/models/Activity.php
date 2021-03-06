<?php

namespace site\frontend\modules\som\modules\activity\models;
use site\frontend\modules\som\modules\activity\widgets\ActivityWidget;
use site\frontend\modules\som\modules\qa\models\QaAnswer;
use site\frontend\modules\som\modules\qa\models\QaCategory;
use site\frontend\modules\som\modules\qa\models\QaQuestion;

/**
 * This is the model class for table "som__activity".
 *
 * The followings are the available columns in table 'som__activity':
 * @property string $id
 * @property string $userId
 * @property string $typeId
 * @property string $dtimeCreate
 * @property string $data
 * @property array $dataArray
 *
 * The followings are the available model relations:
 * @property ActivityType $type
 * @property Users $user
 */
class Activity extends \HActiveRecord implements \IHToJSON
{
    /**
     * @var string TYPE_STATUS Тип записи "статус"
     * @author Sergey Gubarev
     */
    const TYPE_STATUS = 'status';

    const TYPE_ANSWER_PEDIATRICIAN = 'answer_pediatrician';
    const TYPE_COMMENT = 'comment';
    const TYPE_QUESTION = 'question';

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'som__activity';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('userId, typeId, dtimeCreate, data', 'required'),
            array('id, typeId', 'length', 'max' => 20),
            array('userId, dtimeCreate', 'length', 'max' => 10),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('id, userId, typeId, dtimeCreate, data', 'safe', 'on' => 'search'),
        );
    }

    public function behaviors()
    {
        return array(
            \HTimestampBehavior::class => array(
                'class' => 'HTimestampBehavior',
                'createAttribute' => 'dtimeCreate',
                'updateAttribute' => null,
                'publicationAttribute' => null,
                'owerwriteAttributeIfSet' => false,
            ),
            /*'CacheDelete' => array(
                'class' => 'site\frontend\modules\v1\behaviors\CacheDeleteBehavior',
            ),*/
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
            'type' => array(self::BELONGS_TO, 'ActivityType', 'typeId'),
            'user' => array(self::BELONGS_TO, 'User', 'userId'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'userId' => 'User',
            'typeId' => 'Type',
            'dtimeCreate' => 'Dtime Create',
            'data' => 'Data',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * Typical usecase:
     * - Initialize the model fields with values from filter form.
     * - Execute this method to get CActiveDataProvider instance which will filter
     * models according to data in model fields.
     * - Pass data provider to CGridView, CListView or any similar widget.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
//     public function search()
//     {
        // @todo Please modify the following code to remove attributes that should not be searched.

//         $criteria = new CDbCriteria;

//         $criteria->compare('id', $this->id, true);
//         $criteria->compare('userId', $this->userId, true);
//         $criteria->compare('typeId', $this->typeId, true);
//         $criteria->compare('dtimeCreate', $this->dtimeCreate, true);
//         $criteria->compare('data', $this->data, true);

//         return new CActiveDataProvider($this, array(
//             'criteria' => $criteria,
//         ));
//     }

    public function getDataArray()
    {
        return \CJSON::decode($this->data);
    }

    public function setDataArray($value)
    {
        $this->data = \CJSON::encode($value);
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Activity the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function toJSON()
    {
        return array(
            'id' => (int) $this->id,
            'userId' => (int) $this->userId,
            'typeId' => $this->typeId,
            'dtimeCreate' => (int) $this->dtimeCreate,
            'data' => $this->dataArray,
        );
    }

    /* scopes */

    public function defaultScope()
    {
        return array(
            // 'condition' => 'typeId != "status"',
            'order' => $this->getTableAlias(false, false) . '.`dtimeCreate` DESC',
        );
    }

    public function byUser($userId)
    {
         $this->getDbCriteria()->addCondition('userId = :userId');
         $this->getDbCriteria()->params[':userId'] = $userId;

        return $this;
    }


    /**
     * Данные по юзеру
     *
     * В выборку попадают
     * - ответы юзера в сервисе МП, которые не относятся к его вопросам
     * - события от других сервисов (Форумы, Блоги и т.д.)
     *
     * @param integer $userId ID пользователя
     * @return $this
     * @author Sergey Gubarev
     */
    public function forUser($userId)
    {
        $criteria = $this->getDbCriteria();
        $criteria->condition = '
            t.id IN (
                    SELECT id
                    FROM (
                        SELECT *
                        FROM ' . Activity::model()->tableName() . '
                        WHERE
                            typeId <> "' . static::TYPE_STATUS . '"
                            AND
                            userId  = ' . $userId . '
                    ) t2
                    WHERE
                        t2.typeId != "' . static::TYPE_ANSWER_PEDIATRICIAN . '"
                        OR
                        (
                            t2.hash IN (
                                        SELECT MD5(qa__a.id)
                                        FROM ' . QaAnswer::model()->tableName() . ' qa__a
                                        JOIN ' . QaQuestion::model()->tableName() . ' qa__q
                                        ON qa__q.id = qa__a.questionId
                                        WHERE
                                            qa__q.authorId != ' . $userId . '
                                            AND
                                            qa__a.authorId = ' . $userId . '
                                            AND
                                            qa__a.root_id IS NULL ' . '
                                            AND
                                            qa__a.isRemoved = ' . QaAnswer::NOT_REMOVED . '
                                            AND
                                            qa__a.isPublished = ' . QaAnswer::PUBLISHED . '
                            )
                            AND
                            t2.typeId = "' . static::TYPE_ANSWER_PEDIATRICIAN . '"
                        )
            )
        ';
        $criteria->order = 't.id DESC';

        return $this;
    }

    /**
     * Исключить ответы к сервису "Мой педиатр"
     * @param bool $limited Использовать лимитирование по времени
     * @param int $sliceRange Диапазон времени выбираемых событий (в сутках)
     * @return $this
     * @author Sergey Gubarev
     */
    public function excludePediatricianAnswers($limited = true, $sliceRange = 30)
    {

        $day = 60 * 60 * 24; // Количество секунд в сутках
        $now = time(); // Текущее время
        $limitSql = $limited
        ? 'AND
          qa__a.dtimeCreate > ' . ($now - ($day * $sliceRange)) . '
          AND
          qa__q.dtimeCreate > ' . ($now - ($day * $sliceRange))
        : '';

        $sqlForAnswers = sprintf(
            'SELECT MD5(qa__a.id)
                FROM %s qa__a
                JOIN %s qa__q
                ON
                  qa__q.id = qa__a.questionId
                WHERE
                    qa__a.isPublished = %d
                    AND
                    qa__q.categoryId != %d
                    AND
                    qa__q.isRemoved = %d
                    %s
            ',

            QaAnswer::model()->tableName(),
            QaQuestion::model()->tableName(),
            QaAnswer::PUBLISHED,
            QaCategory::PEDIATRICIAN_ID,
            QaQuestion::NOT_REMOVED,
            $limitSql
        );

        $criteria = new \CDbCriteria();
        $criteria
            ->compare('typeId', '=' . static::TYPE_COMMENT)
		    ->addCondition('hash in ('.$sqlForAnswers.')')
        ;

        $this->getDbCriteria()->mergeWith($criteria, 'OR');

        return $this;
    }

    /**
     * Исключить вопросы из сервиса "Мой педиатр"
     *
     * Так же, есть возможность сделать исключение для конкретного пользователя
     *
     * @param integer|null $userId ID пользователя
     * @return $this
     * @author Sergey Gubarev
     */
    public function excludePediatricianQuestions($userId = null)
    {
        $sqlAuthorCondition = ! is_null($userId) ? "authorId = $userId AND" : '';

        $sqlForQuestions = '
              SELECT MD5(id)
              FROM ' . QaQuestion::model()->tableName() . '
              WHERE
                  ' . $sqlAuthorCondition . '
                  categoryId != ' . QaCategory::PEDIATRICIAN_ID . '
                  AND
                  isRemoved = ' . QaQuestion::NOT_REMOVED
        ;

        $cmdForQuestions = \Yii::app()->getDb()->createCommand($sqlForQuestions);
        $questionsHashList = $cmdForQuestions->queryColumn();

        if (count($questionsHashList) < 1)
        {
            return $this;
        }

        $criteria = new \CDbCriteria();
        $criteria
            ->compare('typeId', '=' . static::TYPE_QUESTION)
            ->addInCondition('hash', $questionsHashList)
        ;

        $this->getDbCriteria()->mergeWith($criteria, 'OR');

        return $this;
    }

    public function onlyComments()
    {
        $this->getDbCriteria()->compare('typeId', static::TYPE_COMMENT);
        return $this;
    }

    public function onlyPosts()
    {
        $this->getDbCriteria()->compare('typeId', '<>' . static::TYPE_COMMENT);
        return $this;
    }

    public function withoutAnswerPediatrician()
    {
        $this->getDbCriteria()->compare('typeId', '<>' . static::TYPE_ANSWER_PEDIATRICIAN);
        return $this;
    }

    public function withoutQuestion()
    {
        $this->getDbCriteria()->compare('typeId', '<>' . static::TYPE_QUESTION);
        return $this;
    }

    public function getDataObject()
    {
        $data = @json_decode($this->data);

        if (is_null($data) || !isset($data->attributes))
        {
            return;
        }

        $model = new QaAnswer();
        foreach ($data->attributes as $attrName => $attrValue)
        {
            $model->{$attrName} = $attrValue;
        }

        if (!$model->validate())
        {
            return;
        }

        return $model;
    }

}
