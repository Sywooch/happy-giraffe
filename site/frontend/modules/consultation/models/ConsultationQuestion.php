<?php
namespace site\frontend\modules\consultation\models;

/**
 * @property int $id
 * @property int $consultationId
 * @property int $userId
 * @property string $title
 * @property string $text
 *
 * @property \site\frontend\modules\consultation\models\Consultation $consultation
 * @property \site\frontend\modules\consultation\models\ConsultationAnswer $answer
 *
 * @author Никита
 * @date 20/03/15
 */

class ConsultationQuestion extends \HActiveRecord
{
    private $_user;

    public function tableName()
    {
        return 'consultation__questions';
    }

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function rules()
    {
        return array(
            array('title, text', 'required'),
            array('title', 'length', 'max' => 255),
            array('text', 'length', 'max' => 10000),
        );
    }

    public function attributeLabels()
    {
        return array(
            'title' => 'Заголовок',
            'text' => 'Текст',
        );
    }

    public function relations()
    {
        return array(
            'consultation' => array(self::BELONGS_TO, 'site\frontend\modules\consultation\models\Consultation', 'consultationId'),
            'answer' => array(self::HAS_ONE, 'site\frontend\modules\consultation\models\ConsultationAnswer', 'questionId'),
        );
    }

    public function getUser()
    {
        if (is_null($this->_user)) {
            $this->_user = \site\frontend\components\api\models\User::model()->query('get', array(
                'id' => $this->userId,
                'avatarSize' => \Avatar::SIZE_MEDIUM,
            ));
        }

        return $this->_user;
    }

    public function behaviors()
    {
        return array(
            'HTimestampBehavior' => array(
                'class' => 'HTimestampBehavior',
                'createAttribute' => 'created',
                'updateAttribute' => 'updated',
                'setUpdateOnCreate' => true,
            ),
            'UrlBehavior' => array(
                'class' => 'site\common\behaviors\UrlBehavior',
                'route' => '/consultation/default/question',
                'params' => function($model) {
                    return array(
                        'questionId' => $model->id,
                        'slug' => $model->consultation->slug,
                    );
                },
            ),
            'AuthorBehavior' => array(
                'class' => 'site\common\behaviors\AuthorBehavior',
                'attr' => 'userId',
            ),
        );
    }

    public function consultation($consultationId)
    {
        $this->getDbCriteria()->compare($this->tableAlias . '.consultationId', $consultationId);
        return $this;
    }

    public function orderDesc()
    {
        $this->getDbCriteria()->order = $this->tableAlias . '.id DESC';
        return $this;
    }

    public function listView()
    {
        $criteria = new \CDbCriteria();
        $criteria->with = array(
            'answer' => array(
                'with' => 'consultant',
            ),
        );
        $this->getDbCriteria()->mergeWith($criteria);
        return $this;
    }
}