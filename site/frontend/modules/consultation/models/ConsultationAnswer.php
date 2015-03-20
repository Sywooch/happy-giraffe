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
}