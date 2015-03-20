<?php
namespace site\frontend\modules\consultation\models;

/**
 * @property int $id
 * @property int $consultationId
 * @property int $userId
 *
 * @property \site\frontend\modules\consultation\models\Consultation $consultation
 * @property \site\frontend\components\api\models\User $user
 *
 * @author Никита
 * @date 20/03/15
 */

class ConsultationConsultant extends \HActiveRecord
{
    private $_user;

    public function tableName()
    {
        return 'consultation__consultants';
    }

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function relations()
    {
        return array(
            'consultation' => array(self::BELONGS_TO, 'site\frontend\modules\consultation\models\Consultation', 'consultationId'),
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

    public function user($userId)
    {
        $this->getDbCriteria()->compare($this->tableAlias . '.userId', $userId);
        return $this;
    }

    public function consultation($consultationId)
    {
        $this->getDbCriteria()->compare($this->tableAlias . '.consultationId', $consultationId);
        return $this;
    }
}