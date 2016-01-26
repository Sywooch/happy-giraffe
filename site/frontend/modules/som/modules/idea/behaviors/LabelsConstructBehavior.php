<?php

namespace site\frontend\modules\som\modules\idea\behaviors;

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
 * @const DELIMITER;
 */
class LabelsConstructBehavior extends \CActiveRecordBehavior
{
    /**@todo: add labelsModels array to class and owner and proceed it to convert in future*/
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
        $this->club = $this->owner->club;
        $this->forums = explode(',', $this->owner->forums);
        $this->rubrics = explode(',', $this->owner->rubrics);

        $this->handleClub();
        $this->handleForums();
        $this->handleRubrics();

        if ($this->labelsArray) {
            $this->owner->labelsArray = $this->labelsArray;
            $this->owner->labels = 'Идеи|' . implode(self::DELIMITER, $this->labelsArray);
        }

        return parent::beforeSave($event);
    }

    private function handleClub()
    {
        if (isset($this->club)) {
            $this->handleLabel(self::CLUB_PREFIX . \CommunityClub::model()->findByPk($this->club)->title);
        }
    }

    private function handleForums()
    {
        if (isset($this->forums)) {
            $models = $this->getByCriteria($this->forums, \Community::model());

            foreach ($models as $model) {
                $this->handleLabel(self::FORUM_PREFIX . $model->title);
            }
        }
    }

    private function handleRubrics()
    {
        if (isset($this->rubrics)) {
            $models = $this->getByCriteria($this->rubrics, \CommunityRubric::model());

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
        $criteria = new \CDbCriteria();
        $criteria->addInCondition(
            'id',
            $inArray,
            'OR'
        );
        return $model->findAll($criteria);
    }
}