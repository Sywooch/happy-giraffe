<?php

namespace site\frontend\modules\posts\commands;
use site\frontend\modules\posts\components\ArticleHelper;
use site\frontend\modules\posts\models\Content;
use site\frontend\modules\posts\components\ReverseParser;

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

    public function actionTest()
    {
        $post = Content::model()->findByPk(47);
        $parser = new ReverseParser($post->html);
        //print_r($parser->gif);
    }
    
    public function actionSchema()
    {
        $dp = new \CActiveDataProvider(Content::model());
        $iterator = new \CDataProviderIterator($dp, 1000);
        /** @var Content $i */
        foreach ($iterator as $i) {
            \Yii::app()->dbCache->set('articleSchema.' . $this->post->id, ArticleHelper::getJsonLd($i));
        }
    }
}
