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
    public function actionMigrate()
    {
        $dp = new \CActiveDataProvider(Content::model(), array(
            'criteria' => array(
                'condition' => 'id IN (68)',
            ),
        ));

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

        $advExceptions = array(
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

        $fakeModel = new \site\frontend\modules\posts\models\api\Content();
        $fakeClass = get_class($fakeModel);

        /** @var \site\frontend\modules\posts\models\Content $model */
        foreach ($iterator as $model) {
            $labels = $model->labelsArray;
            if ($model->originService == 'advPost') {
                if (array_search($model->originEntityId, $advExceptions) === false) { // обычный эмоциональный пост
                    $labels[] = Label::LABEL_BUZZ;
                    $model->templateObject->data['authorView'] = 'club';
                    $model->templateObject->data['clubData'] = CommunityClub::getClub($labels);
                    $model->originManageInfoObject->params['edit'] = array(
                        'link' => array(
                            'url' => '/editorialDepartment/redactor/editBuzz/?' . http_build_query(array('entity' => $fakeClass, 'entityId' => $model->id)),
                        )
                    );
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

            $model->labelsArray = $labels;
            $model->save();
        }
    }

    public function actionMigrateNews()
    {
        $club = \Community::model()->findByPk(\Community::COMMUNITY_NEWS);

        $dp = new \CActiveDataProvider(Content::model()->byLabels(array($club->toLabel())));
        $iterator = new \CDataProviderIterator($dp, 100);

        foreach ($iterator as $model) {
            $model->templateObject->data['authorView'] = 'empty';
            $model->save();
        }
    }
}