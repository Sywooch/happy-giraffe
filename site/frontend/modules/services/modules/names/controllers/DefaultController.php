<?php

class DefaultController extends HController
{
    /**
     * @todo имена
     */

    public $layout = 'names';
    public $likes = 0;

    public function filters()
    {
        return array(
            'ajaxOnly + like',
        );
    }

    public function init()
    {
        $service = Service::model()->findByPk(1);
        $service->userUsedService();

        parent::init();
    }

    public function actionIndex($letter = null, $gender = null)
    {
        if ($letter == 'null')
            $letter = null;

        if (!empty($letter) && !in_array($letter, array('А','Б','В','Г','Д','Е','Ж','З','И','К','Л','М','Н','О',
            'П','Р','С','Т','У','Ф','Х','Ц','Ч','Э','Ю','Я')))
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        if (empty($letter))
            $this->pageTitle = 'Выбор имени';
        else
            $this->pageTitle = 'Имена для ребенка на букву '.$letter;

        $like_ids = Name::GetLikeIds();
        $this->likes = count($like_ids);

        $criteria = new CDbCriteria;
        $criteria->order = 'name';
        $show_all = false;
        if (!empty($letter) && strlen($letter) < 3) {
            $criteria->compare('name', $letter . '%', true, 'AND', false);
            $show_all = true;
        }
        if (!empty($gender))
            $criteria->compare('gender', $gender);
        $criteria->scopes = 'filled';

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
                    'like_ids' => $like_ids,
                ));
            } else
                $this->render('index', array(
                    'names' => $names,
                    'pages' => $pages,
                    'like_ids' => $like_ids,
                    'letter' => $letter,
                ));
        } else {
            $names = Name::model()->findAll($criteria);
            if (Yii::app()->request->isAjaxRequest) {
                $this->renderPartial('index_data', array(
                        'names' => $names,
                        'pages' => null,
                        'like_ids' => $like_ids,
                    ));
            } else
                $this->render('index', array(
                    'names' => $names,
                    'pages' => null,
                    'like_ids' => $like_ids,
                    'letter' => $letter,
                ));
        }
    }

    public function actionTop10()
    {
        $this->pageTitle = 'Топ 10 имен';
        $this->SetLikes();
        $topMen = Name::model()->Top10Man();
        $topWomen = Name::model()->Top10Woman();

        $this->render('top10', array(
            'topMen' => $topMen,
            'topWomen' => $topWomen,
            'like_ids' => Name::GetLikeIds()
        ));
    }

    public function actionSaint($month = null, $gender = null)
    {
        if (isset($_GET['m']))
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        if ($month !== null) {
            $month = HDate::getMonthIndex($month);
            $data = Name::GetSaintMonthArray($month, null);
            $this->pageTitle = 'Имена по святцам - '.HDate::ruMonth($month);
        } else{
            $this->pageTitle = 'Имена по святцам';
            $data = null;
        }

        if (Yii::app()->request->isAjaxRequest) {
            if ($month === null) {
                $response = array(
                    'month' => null,
                    'html' => '',
                    'month_num' => null
                );
            } else {
                $data = Name::GetSaintMonthArray($month, $gender);
                $response = array(
                    'month' => HDate::ruMonth($month),
                    'html' => $this->renderPartial('saint_res', array(
                        'data' => $data,
                        'like_ids' => Name::GetLikeIds(),
                        'month' => $month,
                    ), true),
                    'month_num' => $month
                );
            }
            echo CJSON::encode($response);
        } else {
            $this->SetLikes();
            $this->render('saint', array(
                'month' => $month,
                'data' => $data,
                'like_ids' => Name::GetLikeIds(),
            ));
        }
    }

    public function actionLikes()
    {
        $this->pageTitle = 'Мне нравится';
        $this->SetLikes();
        $data = Name::model()->GetLikes(Yii::app()->user->id);
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

    /**
     * @sitemap dataSource=sitemapView
     */
    public function actionName($name)
    {
        $this->SetLikes();
        $name = $this->LoadModelBySlugName($name);
        $name->reorderSaints();
        $name->initOptionsSweetMiddles();
        $this->meta_title = 'Значение и характеристика имени '.$name->name;
        $this->meta_description = "Значение имени $name->name. Характеристика имени $name->name. Подходящие отчества к имени $name->name.";
        $this->meta_keywords = "$name->name, значение имени, характеристика имени, подходящие отчества, известные личности, варианты имени, ласковые обращения";

        $this->render('name_view', array('name' => $name));
    }

    public function actionLike()
    {
        $id = Yii::app()->request->getPost('id');
        if (Yii::app()->user->isGuest)
            Yii::app()->end();

        $name = $this->LoadModelById($id);
        echo CJSON::encode(array(
            'success' => $name->like(Yii::app()->user->id),
            'count' => Name::GetLikesCount(Yii::app()->user->id),
            'likes' => $name->likes,
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
    public function LoadModelBySlugName($name)
    {
        $model = Name::model()->with(array(
            'famous' => array('order' => 'famous.last_name'),
            'nameSaintDates' => array('order' => 'nameSaintDates.month, nameSaintDates.day'),
//            'nameMiddles'=>array('select'=>'value'),
//            'nameOptions'=>array('select'=>'value'),
//            'nameSweets'=>array('select'=>'value'),
        ))->findByAttributes(array('slug' => $name));
        if ($model === null)
            throw new CHttpException(404, 'Такое имя не найдено.');
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
            throw new CHttpException(404, 'Такое имя не найдено.');
        return $model;
    }

    public function SetLikes()
    {
        if (!Yii::app()->user->isGuest)
            $this->likes = Name::GetLikesCount(Yii::app()->user->id);
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

    /*public function ParsePage2()
    {
        Yii::import('ext.phpQuery.phpQuery.phpQuery');
        $urls = array(
            'http://www.baby.ru/names/svyatki/january/',
            'http://www.baby.ru/names/svyatki/february/',
            'http://www.baby.ru/names/svyatki/march/',
            'http://www.baby.ru/names/svyatki/april/',
            'http://www.baby.ru/names/svyatki/may/',
            'http://www.baby.ru/names/svyatki/june/',
            'http://www.baby.ru/names/svyatki/july/',
            'http://www.baby.ru/names/svyatki/august/',
            'http://www.baby.ru/names/svyatki/september/',
            'http://www.baby.ru/names/svyatki/october/',
            'http://www.baby.ru/names/svyatki/november/',
            'http://www.baby.ru/names/svyatki/december/',
        );
        $month = 0;
        foreach ($urls as $url) {
            $month++;
            $html = file_get_contents($url);
            $document = phpQuery::newDocument($html);
            foreach ($document->find('ul.table_of_names div.name_title a') as $link) {
                $name = pq($link)->text();
                $woman = pq($link)->hasClass('pink_color');
                $date = pq($link)->parents('ul.table_of_names')->find('div.main_journal_font')->text() . '<br>';
                $link = pq($link)->attr('href');
                $day = preg_replace("/([^0-9]+)/", "", $date);

                $model = Name::model()->findByAttributes(array(
                    'name' => $name,
                ));
                if ($model === null) {
                    $model = new Name;
                    $model->name = $name;
                    $model->gender = $woman ? 2 : 1;
                    $model->middle_names = $link;
                    if (!$model->save())
                        var_dump($model->getErrors());
                }

                $exist = NameSaintDate::model()->findByAttributes(array(
                    'day' => $day,
                    'month' => $month,
                    'name_id' => $model->id,
                ));
                if ($exist === null) {
                    $saint = new NameSaintDate;
                    $saint->day = $day;
                    $saint->month = $month;
                    $saint->name_id = $model->id;
                    if (!$saint->save())
                        var_dump($saint->getErrors());
                }
            }
            sleep(1);
        }
    }


    public function ParsePage()
    {
        Yii::import('ext.phpQuery.phpQuery.phpQuery');

        for ($page = 0; $page < 20; $page++) {
            $url = 'http://www.baby.ru/names/ajax';
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url); // set url to post to
            curl_setopt($ch, CURLOPT_FAILONERROR, 1);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1); // allow redirects
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // return into a variable
            curl_setopt($ch, CURLOPT_TIMEOUT, 3); // times out after 4s
            curl_setopt($ch, CURLOPT_POST, 1); // set POST method
            curl_setopt($ch, CURLOPT_POSTFIELDS, "action=getAllNames&ethnic_id=0&letter_id=0&page=$page&random=1&sex=all"); // add POST fields
            $html = curl_exec($ch); // run the whole process
            curl_close($ch);

            $document = phpQuery::newDocument($html);
            echo $document;
            foreach ($document->find('ul.table_of_names div.name_title a') as $link) {
                $name = trim(pq($link)->text());
                $woman = trim(pq($link)->hasClass('pink_color'));
                $link = trim(pq($link)->attr('href'));

                $model = Name::model()->findByAttributes(array(
                    'name' => $name,
                ));
                if ($model === null) {
                    $model = new Name;
                    $model->name = $name;
                    $model->gender = $woman ? 2 : 1;
                    $model->middle_names = $link;
                    if (!$model->save())
                        var_dump($model->getErrors());
                }
            }
            sleep(1);
        }
    }


    public function ParseName()
    {
        Yii::import('ext.phpQuery.phpQuery.phpQuery');

        $models = Name::model()->findAll();
        foreach ($models as $model) {
            $html = file_get_contents($model->middle_names);
            $document = phpQuery::newDocument($html);
            $i = 0;
            foreach ($document->find('.name_group .cont_main .padding_5 .padding_0_0_10') as $link) {
                if ($i == 1) {
                    $name = pq($link)->text();
                    $model->translate = $name;
                    echo $name . "<br>";
                }
                $i++;
            }
            $i = 0;
            foreach ($document->find('div.name_full_info .description_info p') as $p) {
                if ($i == 5) {
                    $name = pq($p)->text();
                    $name = substr($name, strpos($name, ':') + 1, strlen($name));
                    $model->origin = $name;
                    echo trim($name) . "<br>";
                }
                $i++;
            }

            $model->update(array('translate', 'origin'));

            sleep(1);
        }
    }*/

    public function sitemapView()
    {
        $models = Yii::app()->db->createCommand()
            ->select('slug')
            ->from('name__names')
            ->queryAll();

        $data = array();
        foreach ($models as $model)
        {
            $data[] = array(
                'params' => array(
                    'name' => $model['slug'],
                ),
            );
        }

        return $data;

    }
}