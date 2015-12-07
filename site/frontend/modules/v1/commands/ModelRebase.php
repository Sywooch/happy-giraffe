<?php

namespace site\frontend\modules\v1\commands;

class ModelRebase extends \CConsoleCommand
{
    private static $models = array(
        'Label' => 'site\frontend\modules\posts\models\Label',
        'Content' => 'site\frontend\modules\posts\models\Content',
        'Tag' => 'site\frontend\modules\posts\models\Tag',
        'Comment' => 'site\frontend\modules\comments\models\Comment',
        'User' => 'site\frontend\modules\users\models\User',
    );

    /**
     * @param string $modelName
     */
    public function actionIndex($modelName) {
        if (isset(self::$models[$modelName])) {
            $models = call_user_func(array(self::$models[$modelName], 'model'))->findAll();

            echo 'Current models count to rebase is ' . count($models) . "\n";

            foreach ($models as $model) {
                $model->save();
                echo '.';
            }

            echo "\n";
        } else {
            echo 'Not supporting model "' . $modelName . '"';
        }
    }
}