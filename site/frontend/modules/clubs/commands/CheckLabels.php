<?php

namespace site\frontend\modules\clubs\commands;

/**
 * Description of CheckLabels
 *
 * @author Кирилл
 */
class CheckLabels extends \CConsoleCommand
{

    public $types = array(
        'section' => array('CommunitySection', 'toLabel'),
        'club' => array('CommunityClub', 'toLabel'),
        'forum' => array('Community', 'toLabel'),
        'rubric' => array('CommunityRubric', 'toLabel'),
    );

    public function actionIndex(Array $type = array())
    {
        if (empty($type)) {
            $type = array_keys($this->types);
        }

        foreach ($type as $t) {
            if (isset($this->types[$t])) {
                $callable = $this->types[$t];
                $objects = \CActiveRecord::model($callable[0])->findAll(array('select' => 'distinct(`title`) as title'));
                $labels = array_map(function($obj) use($callable) {
                    return call_user_func(array($obj, $callable[1]));
                }, $objects);
                foreach ($labels as $label) {
                    $exist = \site\frontend\modules\posts\models\Label::model()->exists('text = :text', array(':text' => $label));
                    if (!$exist) {
                        var_dump($label);
                    }
                }
            }
        }
    }

    public function actionFixRubrics($type = 'all')
    {
        $criteria = new \CDbCriteria();
        //$criteria->select = 'distinct(`title`) as title';
        $criteria->addCondition('label_id IS NULL');
        if ($type == 'all') {
            // nothing
        } elseif ($type == 'clubs') {
            $criteria->addCondition('community_id IS NOT NULL');
        } elseif ($type == 'blogs') {
            $criteria->addCondition('community_id IS NULL');
        } else {
            echo 'err';
            die();
        }

        $dataProvider = new \CActiveDataProvider(\CommunityRubric::model(), array(
            'criteria' => $criteria,
            'pagination' => array(
                'pageSize' => 1000,
            ),
        ));

        $iterator = new \CDataProviderIterator($dataProvider);

        foreach ($iterator as $model) {
            $model->getLabelId();
            //echo '.';
        }
    }

}
