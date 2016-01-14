<?php

namespace site\frontend\modules\som\modules\idea\actions;

//use site\frontend\modules\v1\models\UserApiToken;
use site\frontend\modules\v1\actions\RoutedAction;
use site\frontend\modules\som\modules\idea\models\Idea;
use site\frontend\modules\v1\actions\IPostProcessable;
use site\frontend\modules\photo\models\PhotoAttach;
use site\frontend\modules\photo\models\Photo;

class IdeasAction extends RoutedAction implements IPostProcessable
{
    public function run()
    {
        $this->controller->setAction($this);
        $this->route('getIdeas', null, null, null);
    }

    public function getIdeas()
    {
        $this->controller->get(Idea::model(), $this);
    }

    public function postProcessing(&$data)
    {
        if (in_array('collection', $this->controller->getWithParameters(Idea::model()))) {
            for ($i = 0; $i < count($data); $i++) {
                $data[$i]['collection']['attaches'] = array();

                $attaches = PhotoAttach::model()->findAll(array(
                    'condition' => 'collection_id=' . $data[$i]['collection']['id'],
                    'with' => array('photo'),
                ));

                foreach ($attaches as $attach) {
                    $photo = $attach->photo;
                    $data[$i]['collection']['attaches'][] = array(
                        'id' => $attach->id,
                        'photo_id' => $attach->photo_id,
                        'position' => $attach->position,
                        'created' => strtotime($attach->created),
                        'updated' => strtotime($attach->updated),
                        'removed' => $attach->removed,
                        'photo' => array(
                            'id' => $photo->id,
                            'title' => $photo->title,
                            'description' => $photo->description,
                            'width' => $photo->width,
                            'height' => $photo->height,
                            'original_name' => $photo->original_name,
                            'fs_name' => $photo->fs_name,
                            'created' => strtotime($photo->created),
                            'updated' => strtotime($photo->updated),
                            'author_id' => $photo->author_id
                        ),
                    );
                }
            }
        }
    }
}