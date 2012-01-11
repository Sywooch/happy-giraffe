<?php

class DefaultController extends Controller
{
    public $layout = 'names';
    public $likes = 0;

    public function actionIndex($letter = null, $gender = null)
    {
        $this->SetLikes();
        $like_ids = Name::GetLikeIds();

        $criteria = new CDbCriteria;
        $show_all = false;
        if ($letter !== null && strlen($letter) < 3) {
            $criteria->compare('name', strtolower($letter) . '%', true, 'AND', false);
            $show_all = true;
        }
        if (!empty($gender))
            $criteria->compare('gender', $gender);

        if (!$show_all) {
            $count = Name::model()->count($criteria);
            $pages = new CPagination($count);
            $pages->pageSize = 30;
            $pages->applyLimit($criteria);
            $names = Name::model()->findAll($criteria);
            if (Yii::app()->request->isAjaxRequest) {
                $this->renderPartial('index_data', array(
                    'names' => $names,
                    'pages' => $pages,
                    'likes' => Name::GetLikeIds(),
                    'like_ids' => $like_ids,
                ));
            } else
                $this->render('index', array(
                    'names' => $names,
                    'pages' => $pages,
                    'likes' => Name::GetLikeIds(),
                    'like_ids' => $like_ids,
                ));
        } else {
            $names = Name::model()->findAll($criteria);
            if (Yii::app()->request->isAjaxRequest) {
                $this->renderPartial('index_data', array(
                    'names' => $names,
                    'pages' => null,
                    'likes' => Name::GetLikeIds(),
                    'like_ids' => $like_ids,
                ));
            } else
                $this->render('index', array(
                    'names' => $names,
                    'pages' => null,
                    'likes' => Name::GetLikeIds(),
                    'like_ids' => $like_ids,
                ));
        }
    }

    public function actionTop10()
    {
        $this->SetLikes();
        $topMen = Name::model()->Top10Man();
        $topWomen = Name::model()->Top10Woman();

        $this->render('top10', array(
            'topMen' => $topMen,
            'topWomen' => $topWomen,
            'like_ids' => Name::GetLikeIds()
        ));
    }

    public function actionSaint()
    {
        $this->SetLikes();
        $this->render('saint');
    }

    public function actionSaintCalc($month, $gender = null)
    {
        $data = Name::GetSaintMonthArray($month, $gender);
        $this->renderPartial('saint_res', array(
            'data' => $data,
            'like_ids' => Name::GetLikeIds(),
            'month' => $month
        ));
    }

    public function actionLikes()
    {
        $this->SetLikes();
        $data = Name::model()->GetLikes(Yii::app()->user->getId());
        $man = array();
        $woman = array();
        foreach ($data as $name) {
            if ($name['gender'] == 1)
                $man[] = $name;
            if ($name['gender'] == 2)
                $woman[] = $name;
        }

        $this->render('likes', array(
            'data' => $data,
            'man' => $man,
            'woman' => $woman,
            'like_ids' => Name::GetLikeIds(),
        ));
    }

    public function actionName($name)
    {
        $this->SetLikes();
        $name = $this->LoadModelByName($name);

        $this->render('name_view', array('name' => $name));
    }

    public function actionLike($id)
    {
        $name = $this->LoadModelById($id);
        echo CJSON::encode(array(
            'success' => $name->like(Yii::app()->user->getId()),
            'count' => Name::GetLikesCount(Yii::app()->user->getId()),
        ));
    }

    public function actionCreateFamous($id)
    {
        $model = new NameFamous;
        $name = $this->LoadModelById($id);
        $this->performAjaxValidation($model);
        $model->name = $name;

        if (isset($_POST['NameFamous'])) {
            $model->attributes = $_POST['NameFamous'];
            $model->image = CUploadedFile::getInstance($model, 'image');
            $model->name_id = $name->id;

            if ($model->save()) {
                $model->SaveImage();
                $this->redirect(array('name', 'name' => $model->name->name));
            }
        }

        $this->render('create_famous', array(
            'model' => $model,
        ));
    }

    protected function performAjaxValidation($model)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] === 'name-famous-form') {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    /**
     * @param string $name
     * @return Name
     */
    public function LoadModelByName($name)
    {
        $model = Name::model()->with(array(
            'nameFamouses' => array('order' => 'nameFamouses.last_name'),
            'nameSaintDates' => array('order' => 'nameSaintDates.month, nameSaintDates.day')
        ))->findByAttributes(array('name' => $name));
        if ($model === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return $model;
    }

    /**
     * @param int $id
     * @return Name
     * @throws CHttpException
     */
    public function LoadModelById($id)
    {
        $model = Name::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return $model;
    }

    public function SetLikes()
    {
        if (!Yii::app()->user->isGuest)
            $this->likes = Name::GetLikesCount(Yii::app()->user->getId());
    }

    public function actionImg()
    {
        $this->layout = null;
        $data = array(2875, 3204, 3874, 4576, 3204, 3874, 4576);
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
        $im->writeImage(Yii::app()->basePath . '\www\images\modules\names\test.jpg');

        //draw hearts on image
        $marker = imagecreatefrompng(Yii::app()->basePath . '\www\images\heart.png');
        $img = imagecreatefromjpeg(Yii::app()->basePath . '\www\images\modules\names\test.jpg');

        for ($i = 1; $i < count($data) - 1; $i++) {
            $y = $this->GetY($data[$i], $max, $diff);
            imagecopy($img, $marker, $i * $w - 10, $y - 23, 0, 0, imagesx($marker), imagesy($marker));
        }

        imagejpeg($img, Yii::app()->basePath . '\www\images\modules\names\test.jpg', 100);

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