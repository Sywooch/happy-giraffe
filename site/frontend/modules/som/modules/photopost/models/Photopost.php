<?php

namespace site\frontend\modules\som\modules\photopost\models;

use \site\frontend\modules\som\modules\community\models\api\Label;

/**
 * This is the model class for table "som__photopost".
 *
 * The followings are the available columns in table 'som__photopost':
 * @property string $id
 * @property string $title
 * @property string $collectionId
 * @property string $authorId
 * @property integer $isDraft
 * @property integer $isRemoved
 * @property string $dtimeCreate
 * @property string $labels
 * @property integer $forumId
 */
class Photopost extends \CActiveRecord implements \IHToJSON
{

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'som__photopost';
    }

    public function behaviors()
    {
        return array(
            'softDelete' => array(
                'class' => 'site.common.behaviors.SoftDeleteBehavior',
                'removeAttribute' => 'isRemoved',
            ),
            'HTimestampBehavior' => array(
                'class' => 'HTimestampBehavior',
                'createAttribute' => 'dtimeCreate',
                'updateAttribute' => null,
            ),
            'UrlBehavior' => array(
                'class' => 'site\common\behaviors\UrlBehavior',
                'route' => function($model) {
                    // Если из форума, то в клубы, иначе в блоги
                    return $model->forumId ? 'posts/community/view' : 'posts/post/view';
                },
                'params' => function($model) {
                    // Если из форума, то в клубы, иначе в блоги
                    if ($model->forumId) {
                        return array(
                            'forum_id' => $model->forumId,
                            'content_type_slug' => 'nppost',
                            'content_id' => $model->id,
                        );
                    } else {
                        return array(
                            'content_type_slug' => 'nppost',
                            'user_id' => $model->authorId,
                            'content_id' => $model->id,
                        );
                    }
                },
            ),
        );
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('title, collectionId, authorId', 'required'),
            array('isDraft, isRemoved', 'numerical', 'integerOnly' => true),
            array('title', 'length', 'max' => 255),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'title' => 'Title',
            'collectionId' => 'Collection',
            'authorId' => 'Author',
            'isDraft' => 'Is Draft',
            'isRemoved' => 'Is Removed',
            'dtimeCreate' => 'Dtime Create',
            'labels' => 'Labels',
            'forumId' => 'Forum',
        );
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Photopost the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function toJSON()
    {
        return array(
            'id' => (int) $this->id,
            'url' => $this->getUrl(),
            'collectionId' => (int) $this->collectionId,
            'title' => $this->title,
            'isDraft' => (int) $this->isDraft,
            'isRemoved' => (int) $this->isRemoved,
            'dtimeCreate' => (int) $this->dtimeCreate,
            'lables' => $this->labels,
            'forumId' => is_null($this->forumId) ? null : (int) $this->forumId,
        );
    }

    public function afterSave()
    {
        $result = parent::afterSave();

        $labels = is_null($this->forumId) ? Label::model()->findForBlog() : Label::model()->findByForum($this->forumId);

        $post = new \site\frontend\modules\posts\models\api\Content();
        $post->url = $this->getUrl(false);
        $post->authorId = (int) $this->authorId;
        $post->dtimeCreate = (int) $this->dtimeCreate;
        $post->dtimePublication = (int) $post->dtimeCreate;
        $post->dtimeUpdate = time();
        $post->isRemoved = (int) $this->isRemoved;
        $post->isDraft = (int) $this->isDraft;
        $post->title = htmlspecialchars(trim($this->title));
        $post->text = '';
        $post->preview = $this->getPhotopostTag();
        $post->html = $post->preview;
        $post->labels = array_map(function($labelModel) {
            return $labelModel->text;
        }, $labels);
        $post->originEntity = array_search(get_class($this), \site\frontend\modules\posts\models\Content::$entityAliases);
        $post->originEntityId = (int) $this->id;
        $post->originService = 'photopost';

        $post->template = array(
            'layout' => $this->forumId ? 'newCommunityPost' : 'newBlogPost',
            'data' => array(
                'type' => 'photoPost',
                'noWysiwyg' => true,
            ),
        );
        $post->originManageInfo = array(
            'link' => array(
                'url' => '/' . ($this->forumId ? 'community' : 'blogs') . '/edit/photopost',
                'get' => array('id' => $this->id)
            ),
        );
        $post->isAutoMeta = true;
        $post->meta = array(
            'description' => '',
            'title' => $post->title,
        );

        $post->social = array(
            'description' => $post->meta['description'],
        );

        $post->save();

        return $result;
    }

    public function getPhotopostTag()
    {
        try {
            $collection = \site\frontend\modules\photo\models\api\Collection::model()->findByPk($this->collectionId);
            $cover = new \site\frontend\modules\photo\models\Photo();
            $cover->fromJSON($collection->cover['photo']);
            $thumb = \Yii::app()->thumbs->getThumb($cover, 'postCollectionCover');
            $photoAlbumTag = '<div class="b-album-cap">'
                    . '<div class="b-album-cap_hold">'
                    . '<div class="b-album">'
                    . '<a class="b-album_img-hold" href="' . $this->getUrl() . '" title="Начать просмотр">'
                    . '<div class="b-album-img_a">'
                    . '<div class="b-album_img-pad"></div>'
                    . '<img width="' . $thumb->getWidth() . '" height="' . $thumb->getHeight() . '" class="b-album_img-big" alt="'
                    . $cover->title . '" src="' . $thumb->getUrl() . '">'
                    . '</div>'
                    . '<div class="b-album_img-hold-ovr">'
                    . '<div class="ico-zoom ico-zoom__abs"></div>'
                    . '</div>'
                    . '</a>'
                    . '</div>'
                    . '</div>'
                    . \CHtml::tag('photo-collection', array(
                        'params' =>
                        'id: ' . (int) $collection->id . ', ' .
                        'attachCount: ' . (int) $collection->attachesCount . ', ' .
                        'userId: ' . (int) $this->authorId . ', ' .
                        'coverId: ' . $cover->id,
                            ), '') . '</div>';
            return $photoAlbumTag;
        } catch (\Exception $e) {
            throw $e;
        }
    }

}
        