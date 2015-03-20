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
}