<?php

namespace site\frontend\modules\som\modules\qa\behaviors;

use site\frontend\modules\som\modules\qa\models\QaRating;
use site\frontend\modules\som\modules\qa\models\QaRatingHistory;
use site\frontend\modules\som\modules\qa\models\QaAnswer;
use site\frontend\modules\som\modules\qa\models\QaAnswerVote;

/**
 * @property int $userId;
 * @property int $categoryId;
 * @property string $fieldName;
 */
class RatingBehavior extends \CActiveRecordBehavior
{
    private $userId;
    private $categoryId;
    private $fieldName;

    public function afterSave($event)
    {
        if ($this->owner instanceof QaAnswer) {
            if ($this->owner->isRemoved) {
                $this->handleDelete();
            } else {
                $this->handleSave();
            }

            return;
        }

        $this->handleSave();
    }

    public function afterDelete($event)
    {
        $this->handleDelete();

        return parent::afterDelete($event);
    }

    private function handleSave()
    {
        $this->setProperties();
        $rating = QaRating::model()
            ->byCategory($this->getCategoryId())
            ->byUser($this->getUserId())
            ->find();

        if (!$rating) {
            $rating = new QaRating();
            $rating->user_id = $this->getUserId();
            $rating->category_id = $this->getCategoryId();

            if (!$rating->save()) {
                throw new \CException('Rating is not saved');
            }
        }

        $history = QaRatingHistory::model()
            ->byUser($this->getUserId())
            ->byCategory($this->getCategoryId())
            ->byOwner((new \ReflectionClass($this->owner))->getShortName(), $this->owner->id)
            ->find();

        if ($history) {
            return;
        }

        $rating->total_count += 1;
        $rating->{$this->getFieldName()} += 1;
        $rating->save();

        $history = new QaRatingHistory();

        $history->user_id = $this->getUserId();
        $history->category_id = $this->getCategoryId();
        $history->owner_model = (new \ReflectionClass($this->owner))->getShortName();
        $history->owner_id = $this->owner->id;

        if (!$history->save()) {
            throw new \CException('History is not saved');
        }
    }

    private function handleDelete()
    {
        /**
         * @var QaRating $rating
         */
        $rating = QaRating::model()
            ->byCategory($this->getCategoryId())
            ->byUser($this->getUserId())
            ->find();

        if ($rating) {
            $history = QaRatingHistory::model()
                ->byUser($this->getUserId())
                ->byCategory($this->getCategoryId())
                ->byOwner((new \ReflectionClass($this->owner))->getShortName(), $this->owner->id)
                ->find();

            if ($history) {
//            if ($this->owner instanceof QaAnswer) {
//                foreach ($this->owner->votes as $vote) {
//                    $voteInHistory = QaRatingHistory::model()
//                        ->byUser($this->getUserId())
//                        ->byCategory($this->getCategoryId())
//                        ->byOwner((new \ReflectionClass($vote))->getShortName(), $vote->id)
//                        ->find();
//                }
//            }

                $rating->total_count -= 1;
                $rating->{$this->getFieldName()} -= 1;

                $rating->save();

                $history->delete();
            }
        }
    }

    private function getUserId()
    {
        if (!$this->userId) {
            if ($this->owner instanceof QaAnswer) {
                $this->userId = $this->owner->authorId;
            } else if ($this->owner instanceof QaAnswerVote) {
                $this->userId = $this->owner->answer->authorId;
            }
        }

        return $this->userId;
    }

    private function getCategoryId()
    {
        if (!$this->categoryId) {
            if ($this->owner instanceof QaAnswer) {
                $this->categoryId = $this->owner->question->category->id;
            } else if ($this->owner instanceof QaAnswerVote) {
                $this->categoryId = $this->owner->answer->question->category->id;
            }
        }

        return $this->categoryId;
    }

    private function getFieldName()
    {
        if (!$this->fieldName) {
            if ($this->owner instanceof QaAnswer) {
                $this->fieldName = 'answers_count';
            } else if ($this->owner instanceof QaAnswerVote) {
                $this->fieldName = 'votes_count';
            }
        }

        return $this->fieldName;
    }

    private function setProperties()
    {
        if ($this->owner instanceof QaAnswer) {
            $this->categoryId = $this->owner->question->categoryId;
            $this->userId = $this->owner->authorId;
            $this->fieldName = 'answers_count';
        } else if ($this->owner instanceof QaAnswerVote) {
            $this->categoryId = $this->owner->answer->question->categoryId;
            $this->userId = $this->owner->answer->authorId;
            $this->fieldName = 'votes_count';
        }
    }
}