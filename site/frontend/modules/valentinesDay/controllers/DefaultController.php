<?php

class DefaultController extends HController
{
    public $body_class = ' body-gray';

	public function actionIndex()
	{
        $this->meta_title = 'День святого Валентина';

        $recipe_tag = CookRecipeTag::model()->findByPk(CookRecipeTag::TAG_VALENTINE);
        $post = $this->getPhotoPost();
        $videos = ValentineVideo::model()->with('photo')->findAll();

        $criteria = $this->getValentinesCriteria();
        $criteria->limit = 6;
        $valentines = AlbumPhoto::model()->findAll($criteria);

		$this->render('index', compact('post', 'recipe_tag', 'videos', 'valentines'));
	}

    public function actionValentines()
    {
        $dp = new CActiveDataProvider('AlbumPhoto', array(
            'criteria' => $this->getValentinesCriteria(),
        ));

        $this->render('valentines', compact('dp'));
    }

    public function actionSms()
    {
        $this->meta_title = '100 Смс о любви. Смс ко дню святого Валентина';

        $criteria = new CDbCriteria;
        $pages = new CPagination(ValentineSms::model()->count());
        $pages->pageSize = 15;
        $pages->applyLimit($criteria);
        $models = ValentineSms::model()->findAll($criteria);

        $this->render('sms', compact('models', 'pages'));
    }

    public function actionHowToSpend($open=0){
        $this->meta_title = 'Как провести День святого Валентина';

        $post = $this->getPhotoPost();
        $this->render('photo_post', compact('post'));
    }

    /**
     * @return CommunityContent
     */
    public function getPhotoPost()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('rubric.community_id', Community::COMMUNITY_VALENTINE);
        return CommunityContent::model()->full()->find($criteria);
    }

    public function actionVimeoSync()
    {
        ValentineVideo::model()->deleteAll();

        Yii::import('application.vendor.*');
        require_once('Vimeo.php');
        $vimeo = new phpVimeo('813ec2b13845c8c85b152af462c30b1ec2437c8b', '3213eb9bb337e6ad984c65f41fe3f8565c796725');
        $vimeo->setToken('80c0a65f39e0bdaf8da9009315940d48', '5ca4f96234e977b241ba22b8ce12ebd37e15d441');
        $videos = $vimeo->call('vimeo.videos.getAll', array('user_id' => 'user16279797', 'full_response' => true, 'sort' => 'oldest'));

        foreach ($videos->videos->video as $video) {
            $model = new ValentineVideo;
            $model->vimeo_id = $video->id;
            $model->title = $video->title;

            $thumbUrl = $video->thumbnails->thumbnail[3]->_content;
            $photo = AlbumPhoto::createByUrl($thumbUrl, 1, false);

            $model->photo_id = $photo->id;
            $model->save();
        }
    }

    public function actionValentinesSync()
    {
        $album = Album::model()->findByAttributes(array('author_id' => User::HAPPY_GIRAFFE, 'type' => Album::TYPE_VALENTINE));
        if ($album !== null)
            $album->delete();

        $path = Yii::getPathOfAlias('site.common.data') . DIRECTORY_SEPARATOR . 'valentines.txt';
        $urls = file($path, FILE_IGNORE_NEW_LINES);

        foreach ($urls as $i => $url) {
            if (AlbumPhoto::createByUrl($url, User::HAPPY_GIRAFFE, Album::TYPE_VALENTINE) === false)
                echo $url . '<br />';
        }
    }

    private function getValentinesCriteria()
    {
        return new CDbCriteria(array(
            'condition' => 'album_id = :type',
            'params' => array(':type' => Album::getAlbumByType(User::HAPPY_GIRAFFE, Album::TYPE_VALENTINE)->id),
        ));
    }
}