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
        $this->route('getIdeas', 'postIdea', 'updateIdea', 'deleteIdea');
    }

    public function getIdeas()
    {
        $this->controller->get(Idea::model(), $this);
    }

    public function postIdea()
    {
        /**@todo: fix access denied*/
        /*if (!\Yii::app()->user->checkAccess('createIdea')) {
            //throwing exception grants 502 error
            throw new \CHttpException('Ќедостаточно прав дл€ выполнени€ операции', 403);
        }*/

        $required = array(
            'title' => true,
            'collectionId' => true,
            //club, forums, rubrics
        );

        if ($this->controller->checkparams($required)) {
            $idea = new Idea('default');

            $params = $this->controller->getParams($required);

            $idea->attributes = array(
                'authorId' => \Yii::app()->user->id,
                'title' => $params['title'],
                'collectionId' => $params['collectionId'],
            );
            if ($idea->save()) {
                $idea->refresh();
                $this->controller->data = $idea;
            } else {
                $this->controller->setError('SavingFailed', 500);
            }
        } else {
            $this->controller->setError('MissingParams', 400);
        }
    }

    public function updateIdea()
    {
        $required = array(
            'id' => true,
            'title' => true,
            'collectionId' => true,
        );

        if ($this->controller->checkParams($required)) {
            $params = $this->controller->getParams($required);

            $idea = Idea::model()->findByPk($params['id']);

            /**@todo: access check here*/
            $idea->title = $params['title'];
            $idea->collectionId = $params['collectionId'];

            if ($idea->save()) {
                $idea->refresh();
                $this->controller->data = $idea;
            } else {
                $this->controller->setError('SavingFailed', 500);
            }
        } else {
            $this->controller->setError('MissingParams', 400);
        }


    }

    public function deleteIdea()
    {

    }

    public function postProcessing(&$data)
    {
        $with = $this->controller->getWithParameters(Idea::model());
        if ($with && in_array('collection', $with)) {
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