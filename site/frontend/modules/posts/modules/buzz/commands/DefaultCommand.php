<?php
namespace site\frontend\modules\posts\modules\buzz\commands;
use site\frontend\modules\posts\models\Content;
use site\frontend\modules\posts\models\Label;
use site\frontend\modules\som\modules\community\models\api\CommunityClub;

/**
 * @author Никита
 * @date 08/10/15
 */

class DefaultCommand extends \CConsoleCommand
{
    public $advExceptions = array(
        247154,

        240984,
        691779,
        675554,

        697054,
        691084,
        268736,
        691864,

        270589,
        676679,
        256624,
        252664,
        250794,
    );

    public function actionMigrate2($all = false, $id = null)
    {
        if ($all === false && $id === null) {
            throw new \CException("Invalid parameters");
        }

        $criteria = new \EMongoCriteria();
        if ($id !== null) {
            $criteria->addCond('entityId', '==', (int) $id);
        }

        $criteria->sort('dtimeCreated', \EMongoCriteria::SORT_ASC);

        $criteria->addCond('entityId', '>=', 690624);

        $dp = new \EMongoDocumentDataProvider(MigrateContent::model(), array(
            'criteria' => $criteria,
        ));
        $total = $dp->totalItemCount;
        $iterator = new \CDataProviderIterator($dp);

        $ids = \Yii::app()->db->createCommand("SELECT id
FROM post__contents
WHERE originEntity = 'AdvPost' AND isRemoved = 0;")->queryColumn();

        foreach ($iterator as $i => $model) {
            echo $model->entityId . "\n";
            if (array_search($model->entityId, $ids) === false) {
                continue;
            }

            $model->scenario = 'buzz';
            $model->label = Label::LABEL_BUZZ;
            if (array_search($model->entityId, $this->advExceptions) === false) {
                $model->save();
            }
            echo '[' . ($i + 1) . '/' . $total . ']' . "\n";
        }
    }

    public function actionMigrate($all = false, $id = null)
    {
        if ($all === false && $id === null) {
            throw new \CException("Invalid parameters");
        }

        $criteria = new \CDbCriteria();
        $criteria->addCondition('buzzMigrate = 0');
        $criteria->addInCondition('originService', array('advPost', 'oldCommunity'));
        if ($id !== null) {
            $criteria->compare('originEntityId', $id);
        }

        $dp = new \CActiveDataProvider(Content::model(), array(
            'criteria' => $criteria,
        ));
        $total = $dp->totalItemCount;

        $iterator = new \CDataProviderIterator($dp, 100);

        $newsCommunity = \Community::model()->findByPk(\Community::COMMUNITY_NEWS);

        $rubricToClub = array(
            6302 => 2,
            6303 => 4,
            6304 => 15,
            6305 => 13,
            6306 => 7,
            6307 => 6,
            6308 => 8,
            6309 => 21,
        );

        $fakeModel = new \site\frontend\modules\posts\models\api\Content();
        $fakeClass = get_class($fakeModel);

        /** @var \site\frontend\modules\posts\models\Content $model */
        foreach ($iterator as $i => $model) {
            $labels = $model->labelsArray;
            if ($model->originService == 'advPost') {
                if (array_search($model->originEntityId, $this->advExceptions) === false) { // обычный эмоциональный пост
                    $labels[] = Label::LABEL_BUZZ;
                    $model->templateObject->data['authorView'] = 'club';
                    $model->templateObject->data['clubData'] = CommunityClub::getClub($labels);
//                    $model->originManageInfoObject->params['edit'] = array(
//                        'link' => array(
//                            'url' => '/editorialDepartment/redactor/editBuzz/?' . http_build_query(array('entity' => $fakeClass, 'entityId' => $model->id)),
//                        )
//                    );
                } else { // рекламный эмоциональный пост
                    $labels[] = Label::LABEL_FORUMS;
                }
            } elseif (array_search($newsCommunity->toLabel(), $labels) !== false) {
                $clubLabel = null;

                foreach ($labels as $label) {
                    if (strpos($label, 'Рубрика') !== false) {
                        $parts = explode(': ', $label);
                        $title = $parts[1];
                        $rubric = \CommunityRubric::model()->findByAttributes(array('title' => $title, 'community_id' => \Community::COMMUNITY_NEWS));

                        $clubId = $rubricToClub[$rubric->id];
                        $club = \CommunityClub::model()->findByPk($clubId);
                        $clubLabel = $club->toLabel();
                    }
                }

                if ($clubLabel === null) {
                    echo $model->id . "\n";
                    break;
                }

                $labels[] = Label::LABEL_NEWS;
                $labels[] = $clubLabel;

                $model->templateObject->data['authorView'] = 'empty';
            } else {
                $labels[] = Label::LABEL_FORUMS;
            }

            $model->buzzMigrate = 1;
            $model->labelsArray = $labels;
            $model->save();
            echo '[' . ($i + 1) . '/' . $total . ']' . "\n";
        }
    }
}

class MigrateContent extends \site\frontend\modules\editorialDepartment\models\Content
{
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function rules()
    {
        return array(
            // Обязательность
            array('title, markDown, htmlText, authorId, fromUserId', 'required'),
            array('clubId, forumId, rubricId', 'required', 'on' => 'forums'),
            array('clubId', 'required', 'on' => 'buzz, news'),

            // Сделаем числа числами
            array('authorId, fromUserId', '\site\common\components\HIntegerFilter'),
            array('clubId, forumId, rubricId', '\site\common\components\HIntegerFilter', 'on' => 'forums'),
            array('clubId', '\site\common\components\HIntegerFilter', 'on' => 'buzz, news'),
        );
    }
}