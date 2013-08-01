<?php

class PhotoGrid extends CWidget
{
    public $model;
    public $width;
    public $thresholdCoefficient = 0.775;
    public $minPhotos = 3;

    public function run()
    {
        $collection = $this->model->getPhotoCollection();

        $grid = array();
        $buffer = array();
        foreach ($collection['photos'] as $photo) {
            $buffer[] = $photo;
            $height = floor($this->getHeight($buffer));

            if (count($buffer) >= $this->minPhotos && $height <= $this->getThreshold($buffer)) {
                $grid[] = array(
                    'height' => $height,
                    'photos' => $buffer,
                );
                $buffer = array();
            }
        }

        $this->render('index', compact('collection', 'grid'));
    }

    public function getHeight($photos)
    {
        return ($this->width - count($photos) * 4) / array_reduce($photos, function($v, $w) {
            $v += $w->width / $w->height;
            return $v;
        }, 0);
    }

    public function getThreshold($photos)
    {
        $balance = array_reduce($photos, function($v, $w) {
            $v += (($w->width / $w->height) > 1) ? 1 : -1;
            return $v;
        }, 0);
        $orientCoefficient = $balance <= 0 ? 2 : 1;
        return 580 / count($photos) * $this->thresholdCoefficient * $orientCoefficient;
    }
}