<?php
namespace site\frontend\modules\consultation\models;

/**
 * @property int $id
 * @property string $slug
 *
 * @property \site\frontend\modules\consultation\models\ConsultationConsultant[] $consultants
 * @property \site\frontend\modules\consultation\models\ConsultationQuestion[] $questions
 *
 * @author Никита
 * @date 20/03/15
 */

class Consultation extends \HActiveRecord
{
    public function tableName()
    {
        return 'consultation__consultations';
    }

    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    public function relations()
    {
        return array(
            'consultants' => array(self::HAS_MANY, 'site\frontend\modules\consultation\models\ConsultationConsultant', 'consultationId'),
            'questions' => array(self::HAS_MANY, 'site\frontend\modules\consultation\models\ConsultationQuestion', 'consultationId'),
        );
    }

    public function slug($slug)
    {
        $this->getDbCriteria()->compare($this->tableAlias . '.slug', $slug);
        return $this;
    }

    public function isConsultant($userId)
    {
        return $this->getConsultantByUserId($userId) !== null;
    }

    public function getConsultantByUserId($userId)
    {
        foreach ($this->consultants as $c) {
            if ($c->userId == $userId) {
                return $c;
            }
        }
        return null;
    }

    public function behaviors()
    {
        return array(
            'UrlBehavior' => array(
                'class' => 'site\common\behaviors\UrlBehavior',
                'route' => '/consultation/default/index',
                'params' => array('slug'),
            ),
        );
    }
}