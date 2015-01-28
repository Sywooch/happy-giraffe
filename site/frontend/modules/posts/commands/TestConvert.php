<?php

namespace site\frontend\modules\posts\commands;

/**
 * Description of TestConvert
 *
 * @author Кирилл
 */
class TestConvert extends \CConsoleCommand
{

    public function actionIndex($id)
    {
        $model = \CommunityContent::model()->resetScope()->findByPk($id);
        var_dump($model->behaviors());
        $model->save();
        var_dump($model->convertToNewPost());
    }

    public function actionRubric($id)
    {
        $models = \CommunityContent::model()->findAllByAttributes(array('rubric_id' => $id));
        foreach ($models as $model) {
            echo $model->convertToNewPost() ? '.' : '!';
        }
        echo "\n";
    }

}
