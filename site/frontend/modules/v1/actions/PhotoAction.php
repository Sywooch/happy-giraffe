<?php

namespace site\frontend\modules\v1\actions;

use site\frontend\modules\photo\components\MigrateManager;

class PhotoAction extends RoutedAction implements IPostProcessable
{
    private $model;

    public function run()
    {
        $this->route(null, 'postPhoto', null, null);
    }

    public function postPhoto()
    {
        if (isset($_FILES)) {
            \Yii::log(print_r($_FILES, true), 'info', 'api');
            foreach ($_FILES as $file) {
                $this->model = \AlbumPhoto::model()->createUserTempPhoto($file);
                MigrateManager::movePhoto($this->model);
            }

            $this->controller->data = $this->model;
        } else {
            $this->controller->setError("ParamsMissing", 400);
        }
    }

    public function postProcessing(&$data) {
        $data['html'] = $this->model->getWidget(true);
        $data['comment_html'] = $this->model->getWidget(true, new \Comment());
        $data['url'] = $this->model->getPreviewUrl(480, 250, \Image::WIDTH);
    }
}