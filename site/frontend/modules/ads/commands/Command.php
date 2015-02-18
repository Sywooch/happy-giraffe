<?php
namespace site\frontend\modules\ads\commands;
/**
 * @author Никита
 * @date 11/02/15
 */

use site\frontend\modules\ads\models\Ad;
use site\frontend\modules\posts\models\Content;

\Yii::import('site.frontend.widgets.userAvatarWidget.Avatar');
\Yii::import('site.common.vendor.Google.src.*', true);
require_once 'Google/Api/Ads/Dfp/Util/DateTimeUtils.php';

class Command extends \CConsoleCommand
{
    public function actionIndex($all = false)
    {
        $dp = new \CActiveDataProvider('\site\frontend\modules\ads\models\Ad', array(
            'criteria' => array(
                'order' => 't.id DESC',
                'condition' => 't.active = 1',
            ),
        ));
        $iterator = new \CDataProviderIterator($dp, 100);
        /** @var \site\frontend\modules\ads\models\Ad $ad */
        foreach ($iterator as $ad) {
            echo $ad->id . "\n";
            $originEntity = $ad->getOriginEntity();
            if ($originEntity->asa('HTimestampBehavior') === null) {
                continue;
            }
            $creative = \Yii::app()->getModule('ads')->dfp->getCreative($ad->creativeId);
            $creativeLastModified = \DateTimeUtils::FromDfpDateTime($creative->lastModifiedDateTime)->getTimestamp();
            $updateAttribute = $originEntity->HTimestampBehavior->updateAttribute;
            $originEntityLastModified = $originEntity->$updateAttribute;
            if ($all || ($originEntityLastModified > $creativeLastModified)) {
                \Yii::app()->getModule('ads')->manager->update($ad);
            }
        }
    }

    public function actionAddPhotoPost($id, $iconSrc)
    {
        $post = Content::model()->byEntity('CommunityContent', $id)->find();
        \Yii::app()->getModule('ads')->manager->add('photoPost', $post->id, 'photoPost', compact('iconSrc'));
    }

    public function actionSyncPhotoPosts()
    {
        $file = \Yii::getPathOfAlias('site.common.data') . DIRECTORY_SEPARATOR . 'dfp.csv';
        $nAdded = 0;
        if (($handle = fopen($file, "r")) !== false) {
            $row = 0;
            while (($data = fgetcsv($handle)) !== false) {
                if ($row !== 0 && ! empty($data[5])) {
                    $title = $data[5];
                    $icon = $data[4];
                    $url = $data[2];

                    $post = Content::model()->findByAttributes(array('url' => $url));
                    if ($post === null) {
                        echo "problem: $url\n";
                    }

                    if ($post->title != $title) {
                        $post->title = $title;
                        $post->update(array('title'));
                    }
                    $ad = Ad::model()->entity($post)->find();

                    preg_match('#\d+#', $icon, $matches);
                    $iconSrc = 'http://www.happy-giraffe.ru/lite/images/banner/anonce/anonce-' . $matches[0] . '.png';
                    if ($ad === null) {
                        \Yii::app()->getModule('ads')->manager->add('photoPost', $post->id, 'photoPost', compact('iconSrc'));
                        $nAdded++;
                    }
                }
                $row++;
            }
            fclose($handle);
        }
        echo $nAdded . "added\n";
    }

    public function actionUpdateLicas()
    {
        $options = array(
            'endDateTime' => \DateTimeUtils::ToDfpDateTime(new \DateTime('+5 year', new \DateTimeZone('Europe/Moscow'))),
        );

        $ads = Ad::model()->preset('photoPost')->findAll();
        foreach ($ads as $ad) {
            \Yii::app()->getModule('ads')->dfp->updateLica($ad->lineId, $ad->creativeId, $options);
        }
    }
}