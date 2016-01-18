<?php

namespace site\frontend\modules\som\modules\idea\behaviors;

use site\common\models\CommunityClub;
use site\common\models\Community;
use site\common\models\CommunityRubric;
use site\frontend\modules\posts\models\Tag;
use site\frontend\modules\posts\models\Label;

/**
 * Class for construct label string.
 * For more understanding.
 *
 * @property $club;
 * @property $forums;
 * @property $rubrics;
 *
 * @property $labels;
 * @property $labelsArray;
 *
 * @const CLUB_PREFIX;
 * @const FORUM_PREFIX;
 * @const RUBRIC_PREFIX;
 * @const DELIMETER;
 */
class LabelsConstructBehavior extends \CActiveRecordBehavior
{
    public $club;
    public $forums = array();
    public $rubrics = array();

    private $labels;
    private $labelsArray = array();

    const CLUB_PREFIX = "Клуб: ";
    const FORUM_PREFIX = "Форум: ";
    const RUBRIC_PREFIX = "Рубрика: ";
    const DELIMITER = "|";

    public function beforeSave($event)
    {
        $this->handleClub();
        $this->handleForums();
        $this->handleRubrics();

        $this->owner->labels = implode(self::DELIMITER, $this->labelsArray);
        $this->owner->labelsArray = $this->labelsArray;

        parent::beforeSave($event);
    }

    private function handleClub()
    {
        if (isset($club)) {
            $this->handleLabel(self::CLUB_PREFIX . CommunityClub::model()->findByPk($club)->title);
        }
    }

    private function handleForums()
    {
        if (isset($forums)) {
            $models = $this->getByCriteria($forums, Community::model());

            foreach ($models as $model) {
                $this->handleLabel(self::FORUM_PREFIX . $model->title);
            }
        }
    }

    private function handleRubrics()
    {
        if (isset($rubrics)) {
            $models = $this->getByCriteria($rubrics, CommunityRubric::model());

            foreach ($models as $model) {
                $this->handleLabel(self::RUBRIC_PREFIX . $model->title);
            }
        }
    }

    /**
     * Handle label, check hes model, create it if not exists, construct labels string, push labels array.
     *
     * @param $label
     */
    private function handleLabel($label)
    {
        $model = Label::model()->findByAttributes(array(
            'text' => $label,
        ));

        if (!$model) {
            $model = new Label();
            $model->text = $label;
            $model->save();
        }

        array_push($this->labelsArray, $label);
    }

    /**
     * Helper for get all forums or rubrics by id's array.
     *
     * @param $inArray
     * @param $model
     */
    private function getByCriteria($inArray, $model)
    {
        $criteria = new \CDbCriteria()
            .addInCondition(
                'id',
                $inArray,
                'OR'
            );
        return $model->findAll($criteria);
    }
}