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
        $community = CommunityContent::model()->full()->findAll('id IN (1745,1828,1880,1901,1911,1917,1976,1977,2026,2027,2091,2092,2202,2206,2211,2262,2282,2284,2305,2314,2315,2328,2386,2409,2462,2473,2476,2559,2956,3026,3452,3453,3512,3690,3830,4000,4002,4005,4296,4315,4474,4480,4797,4892,5126,5406,5614,5847,6281,6944,7024,7335,7373,7494,7592,8156,8318,9208,2511,2512,2646,2650,2652,2655,2729,2741,2748,2789,2849,2852,2854,2855,3019,3023,3290,3292,3293,3294,3295,3297,3300,3302,3305,3367,3369,3370,3371,3678,3814,3817,3818,3819,3821,3823,4183,4188,4189,4190,4961,4968,5016,5491,5493,5503,5508,5510,5526,5528,5536,5710,5711,5712,5713,5715,6275,6277,7051,7052,7053,7054,7056,7135,7141,7145,7147,7149,7154,7156,7801,7803,7804,7805,7807,7810,8092,8093,8096,8100,8104,8563,8718,8722,8732,8733,8741,8758,8999,9022,9026,9029,9040,9051,9055,9071,9074,3731,3800,3985,4565,4712,4967,5157,5262,5923,6206,6209,6213,6478,6481,6482,6483,6694,6695,6696,6842,7376,8020,8153,8222,8579,9274,4561,4568,4936,4948,5057,5311,5473,5476,5728,5731,5734,6398,6518,6524,6838,6840,6848,6850,9310,9312,9313,9314,9315,9317,9318,7819,8295)');
        foreach($community as $model)
        {
            if(!$model->content || !$model->content->text)
            {
                echo 'Беда!!!11 ID: ' . $model->id . ' --- ';
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
