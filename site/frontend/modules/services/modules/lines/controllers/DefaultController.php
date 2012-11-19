<?php

class DefaultController extends HController
{
    public function actionIndex($id)
    {
        header("Content-type: image/jpeg");
        $path = Yii::getPathOfAlias('site.frontend.www-submodule.images.widget.lines') . DIRECTORY_SEPARATOR;
        $model = Line::model()->findByPk($id);

        $temp_path = Yii::getPathOfAlias('site.common.uploads.images.lines') . DIRECTORY_SEPARATOR . date("Y-m-d");
        if (!file_exists($temp_path))
            mkdir($temp_path);
        if (file_exists($temp_path . DIRECTORY_SEPARATOR . $id . '.jpeg')) {
            $file = $temp_path . DIRECTORY_SEPARATOR . $id . '.jpeg';
            header('Content-Length: ' . filesize($file));
            readfile($file);
        } else {
            if ($model == null) {
                $im = imagecreatefromjpeg($path . 'wedding.jpg');
                ImageJpeg($im);
            } else {
                $im = imagecreatefromjpeg($path . $model->getImage());
                $font = $path . 'Candara.ttf';
                $color = imagecolorallocate($im, 123, 123, 123);
                $text = $model->getDateText();
                $length = strlen($text);

                imagettftext($im, 8, 0, 200-round(2.5*$length), 87, $color, $font, $text);

                ImageJpeg($im, $temp_path . DIRECTORY_SEPARATOR . $id . '.jpeg', 80);
                ImageJpeg($im);
            }
        }
    }
}