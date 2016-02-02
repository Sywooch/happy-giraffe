<?php

namespace site\frontend\modules\v1\actions;

use site\frontend\modules\photo\components\MigrateManager;
use site\frontend\modules\v1\helpers\ApiLog;

class PhotoAction extends RoutedAction implements IPostProcessable
{
    private $model;

    public function run()
    {
        $this->route(null, 'postPhoto', null, null);
    }

    public function postPhoto()
    {
        if (isset($_FILES['photo'])) {
           // ApiLog::i(print_r($_FILES, true));

            $this->model = \AlbumPhoto::model()->createUserTempPhoto($_FILES['photo']);
            MigrateManager::movePhoto($this->model);

            $this->controller->data = $this->model;

            $this->controller->setAction($this);
        } else {
            $this->controller->setError("ParamsMissing", 400);
        }
    }

    public function postProcessing(&$data)
    {
        for ($i = 0; $i < count($data); $i++) {
            $data[$i]['html'] = $this->model->getWidget(true);
            $data[$i]['comment_html'] = $this->model->getWidget(true, new \Comment());
            $data[$i]['url'] = $this->model->getPreviewUrl(480, 250, \Image::WIDTH);

            $data[$i]['new_photo_id'] = $data[$i]['newPhotoId'];
            unset($data[$i]['newPhotoId']);
        }
    }
}