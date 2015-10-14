<?php
namespace site\frontend\modules\posts\modules\buzz\commands;
use site\frontend\modules\posts\models\Content;

/**
 * @author Никита
 * @date 08/10/15
 */

class DefaultCommand extends \CConsoleCommand
{
    public function actionSetLabels()
    {
        $dp = new \CActiveDataProvider(Content::model(), array(
            'criteria' => array(
                'condition' => 'id = 25 AND originService = "advPost"',
            ),
        ));

        $iterator = new \CDataProviderIterator($dp, 100);

        foreach ($iterator as $model) {
            $labels = $model->labelsArray;
            $labels[] = 'Buzz';
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