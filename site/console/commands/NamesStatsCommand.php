<?php

class NamesStatsCommand extends CConsoleCommand
{

    public function actionIndex()
    {
        $month = date('m');
        $year = date('Y');

        $models = Name::model()->with(array(
            'nameStats' => array('order' => 'year,month')
        ))->findAll(array('select' => 'id'));

        foreach ($models as $model) {
            $exist = false;
            foreach ($model->nameStats as $nameStats) {
                if ($nameStats->month == $month && $nameStats->year == $year) {
                    $nameStats->likes = $model->likes;
                    $nameStats->update(array('likes'));
                    $exist = true;
                    break;
                }
            }

            if (!$exist) {
                $nameStats = new NameStats();
                $nameStats->month = $month;
                $nameStats->year = $year;
                $nameStats->name_id = $model->id;
                $nameStats->likes = $model->likes;
                $nameStats->save();
            }

            $model->refresh();
            $this->GenerateImageFromModel($model);
        }
    }

    /**
     * @param Name $model
     */
    public function GenerateImageFromModel($model)
    {
        $data = array(1);
        foreach ($model->nameStats as $nameStats) {
            $data[] = $nameStats->likes;
        }

        $this->GenerateImage($data, $model->id);
    }

    public function GenerateImage($data, $model_id)
    {
        //        $data = array(2875, 3204, 3874, 4576, 3204, 3874, 4576);
        $min = min($data);
        $max = max($data);
        $diff = $max - $min;
        $w = 45;

        $image_width = $w * (count($data) - 1);
        $image_height = 132;

        $im = new Imagick();
        $im->newImage($image_width, $image_height, new ImagickPixel('#f4fdff'));

        $draw = new ImagickDraw();

        //draw vertical lines
        $draw->setStrokeColor(new ImagickPixel('#d1e7ec'));
        $draw->setStrokeWidth(1);
        for ($i = 1; $i < count($data); $i++) {
            $draw->line($i * $w, 0, $i * $w, $image_height);
        }

        //draw chart line
        $point1 = array(0, $this->GetY($data[0], $max, $diff));
        $draw->setStrokeColor(new ImagickPixel('#fd93b9'));
        $draw->setStrokeWidth(1.5);

        for ($i = 1; $i < count($data); $i++) {
            $y = $this->GetY($data[$i], $max, $diff);
            $draw->line($point1[0], $point1[1], $i * $w, $y);

            $point1 = array($i * $w, $y);
        }
        $im->drawImage($draw);

        //draw chart points
        for ($i = 1; $i < count($data) - 1; $i++) {
            $y = $this->GetY($data[$i], $max, $diff);

            $draw->setStrokeColor(new ImagickPixel('#fd93b9'));
            $draw->setStrokeWidth(1.5);
            $draw->setFillColor(new ImagickPixel('#ffffff'));
            $draw->ellipse($i * $w, $y, 4, 4, 0, 360);
            $im->drawImage($draw);

            $draw->clear();
            $draw->setFontSize(11);
            $draw->setFillColor(new ImagickPixel('#b68cd4'));
            $draw->setFont("font/arial.ttf");
            $draw->annotation($i * $w - strlen($data[$i]) * 3, $y + 16, $data[$i]);
            $im->drawImage($draw);
        }

        $im->drawImage($draw);
        $im->borderImage('#e3d8ea', 2, 2);
        $im->writeImage(Yii::app()->basePath . '\..\frontend\www\images\modules\names\name_'.$model_id.'.jpg');

        //draw hearts on image
        $marker = imagecreatefrompng(Yii::app()->basePath . '\..\frontend\www\images\heart.png');
        $img = imagecreatefromjpeg(Yii::app()->basePath . '\..\frontend\www\images\modules\names\name_'.$model_id.'.jpg');

        for ($i = 1; $i < count($data) - 1; $i++) {
            $y = $this->GetY($data[$i], $max, $diff);
            imagecopy($img, $marker, $i * $w - 10, $y - 23, 0, 0, imagesx($marker), imagesy($marker));
        }

        imagejpeg($img, Yii::app()->basePath . '\..\frontend\www\images\modules\names\name_'.$model_id.'.jpg', 100);

        //$thumb = new Imagick();
        //$heart = new Imagick(Yii::app()->basePath.'\www\images\heart.png');
        //$im->setImageFormat("png");
        //echo $im;
    }

    public function GetY($value, $max, $diff)
    {
        if ($diff == 0)
            return 30;
        return 30 + ($max - $value) * 85 / $diff;
    }
}