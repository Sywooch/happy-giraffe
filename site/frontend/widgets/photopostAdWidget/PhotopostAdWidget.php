<?php
/**
 * @author Никита
 * @date 30/06/15
 */

require_once('mobiledetect/Mobile_Detect.php');

class PhotopostAdWidget extends CWidget
{
    public static $banners = array(
        array(
            'url' => 'http://www.happy-giraffe.ru/community/39/forum/photoPost/103108/#openGallery',
            'image' => 'http://banners.adfox.ru/140428/adfox/369194/999311.jpg',
        ),
        array(
            'url' => 'http://www.happy-giraffe.ru/community/22/forum/photoPost/103434/#openGallery',
            'image' => 'http://banners.adfox.ru/140428/adfox/369194/999292.jpg',
        ),
        array(
            'url' => 'http://www.happy-giraffe.ru/community/2/forum/photoPost/103402/#openGallery',
            'image' => 'http://banners.adfox.ru/140428/adfox/369194/999098.jpg',
        ),
        array(
            'url' => 'http://www.happy-giraffe.ru/community/21/forum/photoPost/103600/#openGallery',
            'image' => 'http://banners.adfox.ru/140428/adfox/369194/999101.jpg',
        ),
        array(
            'url' => 'http://www.happy-giraffe.ru/community/26/forum/photoPost/109818/#openGallery',
            'image' => 'http://banners.adfox.ru/140428/adfox/369194/999095.jpg',
        ),
        array(
            'url' => 'http://www.happy-giraffe.ru/community/34/forum/photoPost/108138/#openGallery',
            'image' => 'http://banners.adfox.ru/140428/adfox/369194/999084.jpg',
        ),
    );

    public function run()
    {

        $this->showMailRu();
        Yii::app()->controller->renderDynamic(array($this, 'showPhotoPost'));
    }

    public function showPhotoPost()
    {
        $detect = new Mobile_Detect();
        if (! $detect->isMobile() && ! isset(Yii::app()->request->cookies['photo-popup-1'])) {
            $el = self::$banners[array_rand(self::$banners)];
            return $this->render('photopost', $el, true);
        }
        return '';
    }

    public function showMailRu()
    {
        $detect = new Mobile_Detect();
        if ($detect->isMobile() && ! $detect->isiOS()) {
            $this->render('mailru');
        }
    }
}