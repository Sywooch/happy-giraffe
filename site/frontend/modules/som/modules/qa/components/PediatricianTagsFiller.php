<?php

namespace site\frontend\modules\som\modules\qa\components;

use site\frontend\modules\som\modules\qa\models\QaCategory;
use site\frontend\modules\som\modules\qa\models\QaTag;

class PediatricianTagsFiller
{
    private static $title = 'Мой педиатр';
    private static $tags = array(
        'Дети до года',
        'Дети старше года',
        'Дошкольники',
        'Школьники',
    );

    public static function run()
    {
        $category = QaCategory::model()->byTitle(self::$title)->find();

        if (!$category) {
            echo 'Pediatrician category not found. Creating...';
            $category = new QaCategory();
            $category->title = self::$title;

            if (!$category->save()) {
                echo 'Category creation failed.';
                return;
            }
        }

        /**
         * @var \CDbTransaction $transaction
         */
        $transaction = \Yii::app()->db->beginTransaction();
        try {
            foreach (self::$tags as $tag) {
                if (QaTag::model()->byCategory($category->id)->byName($tag)->find()) {
                    echo "Tag with name' {$tag}'' already exist.\n";
                    continue;
                }

                $model = new QaTag();
                $model->category_id = $category->id;
                $model->name = $tag;

                if (!$model->save()) {
                    throw new \Exception(print_r($model->getErrors(), true));
                }
            }

            $transaction->commit();
        } catch (\Exception $ex) {
            $transaction->rollback();
            echo $ex->getMessage();
        }
    }
}