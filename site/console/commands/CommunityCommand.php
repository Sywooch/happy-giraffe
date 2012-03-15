<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Eugene
 * Date: 06.03.12
 * Time: 16:03
 * To change this template use File | Settings | File Templates.
 */
class CommunityCommand extends CConsoleCommand
{
    public function actionCutConvert()
    {
        Yii::import('site.frontend.extensions.ESaveRelatedBehavior');
        Yii::import('site.frontend.components.CutBehavior');
        $community = CommunityContent::model()->full()->findAll();
        foreach($community as $model)
        {
            if(!$model->content || !$model->content->text)
            {
                echo 'Беда!!!11 ID: ' . $model->id . ' --- '
                continue;
            }
            $p = new CHtmlPurifier();
            $p->options = array(
                'URI.AllowedSchemes'=>array(
                    'http' => true,
                    'https' => true,
                ),
                'HTML.Nofollow' => true,
                'HTML.TargetBlank' => true,
                'HTML.AllowedComments' => array('more' => true),

            );
            $text = $p->purify($model->content->text);
            $pos = strpos($text, '<!--more-->');
            $preview = $pos === false ? $text : substr($text, 0, $pos);
            $preview = $p->purify($preview);
            $model->preview = $preview;
            $model->save(false);
            $model->content->text = $text;
            $model->content->save(false);
        }
    }
}
