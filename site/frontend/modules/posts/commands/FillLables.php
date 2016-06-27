<?php

namespace site\frontend\modules\posts\commands;

use \site\frontend\modules\posts\models\Content;
use \site\frontend\modules\posts\models\Label;

/**
 * заполнение label_section и label_subsections данными
 * @author crocodile
 */
class FillLables extends \CConsoleCommand
{

    public function actionIndex()
    {
        $sql = "SELECT count(*) AS c FROM post__contents";
        list($count) = \Yii::app()->db->createCommand($sql)->queryAll(true);
        $count = $count['c'];

        $dataProvider = new \CActiveDataProvider(Content::model()->resetScope(), array(
            'criteria' => new \CDbCriteria(),
            #'criteria' => ['condition' => 'label_section is null and label_subsections  is null'],
            'pagination' => array(
                'pageSize' => 500
            ),
        ));
        $iterator = new \CDataProviderIterator($dataProvider);
        $baseSections = [
            Label::LABEL_FORUMS,
            Label::LABEL_BUZZ,
            Label::LABEL_NEWS,
            Label::LABEL_BLOG
        ];
        /**
         * @var \site\frontend\modules\posts\models\Content $model
         */
        foreach ($iterator as $i => $model)
        {
            print "Start {$i}/{$iterator->count()}\r\n";
            /**
             * @var site\frontend\modules\posts\models\Label $label
             */
            $labelSection = null;
            $labelSubsections = [];
            foreach ($model->labelModels AS $label)
            {
                if (in_array($label->text, $baseSections))
                {
                    $labelSection = $label->id;
                }
                $labelSubsections[] = $label->id;
            };
            $model->label_section = $labelSection;
            $model->label_subsections = implode(',', $labelSubsections);
            $model->save();
        }
    }

}
