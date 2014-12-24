<?php

/**
 * Временный контроллер, для реализации форм добавления/редактирования статей в старом интерфейсе
 *
 * @author Кирилл
 */
class TmpController extends HController
{

    public $layout = '//layouts/main';

    public function getUser()
    {
        return Yii::app()->user->model;
    }

    public function actionIndex($id = null, $type = null)
    {
        /* (с) site.frontend.blog.controllers.DefaultController::actionForm */
        if (!($id xor $type)) {
            throw new CHttpException(400);
        }

        if (Yii::app()->user->isGuest)
            throw new CHttpException(403);

        if ($id) {
            $model = BlogContent::model()->findByPk($id);
            if (!$model) {
                throw new CHttpException(404);
            }
            $slaveModel = $model->getContent();
        } else {
            $model = new BlogContent('default');
            $model->type_id = $type;
            $slug = $model->type->slug;
            $slaveModelName = 'Community' . ucfirst($slug);
            $slaveModel = new $slaveModelName();
        }

        if (!$model->isNewRecord && !$model->canEdit()) {
            throw new CHttpException(403);
        }

        $rubricsList = array_map(function ($rubric) {
            return array(
                'id' => $rubric->id,
                'title' => $rubric->title,
            );
        }, Yii::app()->user->model->blog_rubrics);

        $json = array(
            'title' => (string) $model->title,
            'privacy' => (int) $model->privacy,
            'text' => (string) $slaveModel->text,
            'rubricsList' => $rubricsList,
            'selectedRubric' => $id === null ? null : $model->rubric_id,
        );

        if ($model->type_id == CommunityContent::TYPE_STATUS) {
            $json['moods'] = array_map(function ($mood) {
                return array(
                    'id' => (int) $mood->id,
                    'title' => (string) $mood->title,
                );
            }, UserMood::model()->findAll(array('order' => 'id ASC')));
            $json['mood_id'] = $slaveModel->mood_id;
        }

        if ($model->type_id == CommunityContent::TYPE_PHOTO_POST) {
            if ($model->isNewRecord)
                $json['photos'] = array();
            else
                $json['photos'] = $model->getContent()->getPhotoPostData();
            $json['albumsList'] = array_map(function ($album) {
                return array(
                    'id' => $album->id,
                    'title' => $album->title,
                );
            }, $this->user->simpleAlbums);
        }

        if ($model->type_id == CommunityContent::TYPE_VIDEO) {
            if ($model->isNewRecord) {
                $json['link'] = '';
                $json['embed'] = null;
            } else {
                $json['link'] = $model->video->link;
                $json['embed'] = $model->video->embed;
            }
        }

        $club_id = null;

        $this->render('index', compact('model', 'slaveModel', 'json', 'club_id'));
    }

    public function actionFavourites($entity, $entityId)
    {
        echo CJSON::encode(array(
            array('class' => 'social', 'title' => 'Посты в соцсети', 'num' => 1, 'active' => true),
            array('class' => 'mail', 'title' => 'Посты в рассылку', 'num' => 2, 'active' => false),
            array('class' => 'interest', 'title' => 'На главную', 'num' => 3, 'active' => true),
        ));
        die;
        if (Yii::app()->user->model->checkAuthItem('manageFavourites')) {
            if ($entity == 'SimpleRecipe' || $entity == 'MultivarkaRecipe') {
                /* <a class="ico-redactor ico-redactor__social js-tooltipsy<?php if (Favourites::inFavourites($model, Favourites::BLOCK_SOCIAL_NETWORKS)) echo ' active'; ?>" href="#"
                  onclick="Favourites.toggle(this, 7);return false;" title="Посты в соцсети"></a> */
            } else {

                /* <a class="ico-redactor ico-redactor__interest js-tooltipsy<?php if (Favourites::inFavourites($model, Favourites::BLOCK_INTERESTING)) echo ' active'; ?>" href="#"
                  onclick="Favourites.toggle(this, 2);return false;" title="На главную"></a>

                  <a class="ico-redactor ico-redactor__social js-tooltipsy<?php if (Favourites::inFavourites($model, Favourites::BLOCK_SOCIAL_NETWORKS)) echo ' active'; ?>" href="#"
                  onclick="Favourites.toggle(this, 7);return false;" title="Посты в соцсети"></a>

                  <a class="ico-redactor ico-redactor__mail js-tooltipsy<?php if (Favourites::inFavourites($model, Favourites::WEEKLY_MAIL)) echo ' active'; ?>" href="#"
                  onclick="Favourites.toggle(this, <?=Favourites::WEEKLY_MAIL ?>);return false;" title="Посты в рассылку"></a> */
            }
        }

        if (Yii::app()->user->model->checkAuthItem('clubFavourites')) {
            if (get_class($model) == 'CommunityContent') {
                /* <a class="ico-redactor ico-redactor__interest js-tooltipsy<?php if (Favourites::inFavourites($model, Favourites::CLUB_MORE)) echo ' active'; ?>" href="#"
                  onclick="Favourites.toggle(this, <?=Favourites::CLUB_MORE ?>);return false;" title="Интересное в клубах"></a> */
            }
        }
    }

}

?>
