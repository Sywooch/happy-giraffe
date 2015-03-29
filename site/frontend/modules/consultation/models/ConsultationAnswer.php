<?php
namespace site\frontend\modules\consultation\models;

/**
 * @property int $id
 * @property int $questionId
 * @property int $consultantId
 * @property string $text
 *
 * @property \site\frontend\modules\consultation\models\ConsultationConsultant $consultant
 * @property \site\frontend\modules\consultation\models\ConsultationQuestion $question
 *
 * @author Никита
 * @date 20/03/15
 */

class ConsultationAnswer extends \HActiveRecord
{
    private $_user;

    public function tableName()
    {
        return 'consultation__answers';
    }

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function relations()
    {
        return array(
            'consultant' => array(self::BELONGS_TO, 'site\frontend\modules\consultation\models\ConsultationConsultant', 'consultantId'),
            'question' => array(self::BELONGS_TO, 'site\frontend\modules\consultation\models\ConsultationQuestion', 'questionId'),
        );
    }

    public function getUser()
    {
        if (is_null($this->_user)) {
            $this->_user = \site\frontend\components\api\models\User::model()->query('get', array(
                'id' => $this->consultant->userId,
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
                        'questionId' => $model->question->id,
                        'slug' => $model->question->consultation->slug,
                        '#' => 'answer',
                    );
                },
            ),
        );
    }
}