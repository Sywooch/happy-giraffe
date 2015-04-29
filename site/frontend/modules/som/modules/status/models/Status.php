<?php

namespace site\frontend\modules\som\modules\status\models;

use \site\frontend\modules\som\modules\community\models\api\Label;

/**
 * This is the model class for table "som__status".
 *
 * The followings are the available columns in table 'som__status':
 * @property string $id
 * @property string $text
 * @property string $moodId
 * @property string $authorId
 * @property string $isRemoved
 * @property string $dtimeCreate
 *
 * The followings are the available model relations:
 * @property \site\frontend\modules\som\modules\status\models\Moods $moodModel
 */
class Status extends \CActiveRecord implements \IHToJSON
{

    protected $_author = null;

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'som__status';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        return array(
            array('text, authorId', 'required'),
            array('moodId', 'numerical', 'allowEmpty' => true, 'integerOnly' => true, 'min' => 1),
            array('authorId', 'numerical', 'allowEmpty' => false, 'integerOnly' => true, 'min' => 1),
            array('text', 'length', 'max' => 500),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'moodModel' => array(self::BELONGS_TO, 'site\frontend\modules\som\modules\status\models\Moods', 'moodId'),
        );
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return site\frontend\modules\som\modules\status\models\Status the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
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
                    return 'posts/post/view';
                },
                'params' => function($model) {
                    // Если из форума, то в клубы, иначе в блоги
                    return array('content_type_slug' => 'status', 'user_id' => $model->authorId, 'content_id' => $model->id,);
                },
            ),
        );
    }
    public function afterSave()
    {
        parent::afterSave();

        $labels = Label::model()->findForBlog();

        $post = new \site\frontend\modules\posts\models\api\Content();
        $post->url = $this->getUrl(false);
        $post->authorId = (int) $this->authorId;
        $post->dtimeCreate = (int) $this->dtimeCreate;
        $post->dtimePublication = (int) $post->dtimeCreate;
        $post->dtimeUpdate = time();
        $post->isRemoved = (int) $this->isRemoved;
        $post->isDraft = 0;
        $post->isNoindex = true;
        $post->title = $this->author->fullName . ' - статус от ' . date('d.m.y h:i', $this->dtimeCreate);
        $post->text = strip_tags($this->text);
        $post->preview = $this->render('site.frontend.modules.som.modules.status.views.common.statusPreview', array('status' => $this));
        $post->html = $this->render('site.frontend.modules.som.modules.status.views.common.status', array('status' => $this));
        $post->labels = array_map(function($labelModel) {
            return $labelModel->text;
        }, $labels);
        $post->originEntity = array_search(get_class($this), \site\frontend\modules\posts\models\Content::$entityAliases);
        $post->originEntityId = (int) $this->id;
        $post->originService = 'status';

        $post->template = array(
            'layout' => 'newBlogPost',
            'data' => array(
                'type' => 'status',
                'noWysiwyg' => true,
                'hideTitle' => true,
            ),
        );
        $post->originManageInfo = array(
            'link' => array(
                'url' => '/blogs/edit/status',
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

    }
    public function onAfterSoftDelete()
    {
        // заглушка, для того, что бы можно было слушать события от SoftDeleteBehavior
    }

    public function onAfterSoftRestore()
    {
        // заглушка, для того, что бы можно было слушать события от SoftDeleteBehavior
    }

    public function toJSON()
    {
        return array(
            'id' => (int) $this->id,
            'text' => $this->text,
            'url' => $this->getUrl(),
            'mood' => is_null($this->moodModel) ? null : array(
                'id' => $this->moodModel->id,
                'text' => $this->moodModel->text,
            ),
        );
    }
    
    public function getAuthor() {
        if(is_null($this->_author)) {
            $this->_author = \site\frontend\components\api\models\User::model()->findByPk($this->authorId);
        }
        return $this->_author;
    }
    
    protected function render($file, $data)
    {
        $file = \Yii::getPathOfAlias($file) . '.php';
        if (\Yii::app() instanceof \CConsoleApplication) {
            return \Yii::app()->command->renderFile($file, $data, true);
        } else {
            return \Yii::app()->controller->renderInternal($file, $data, true);
        }
    }
    /* scopes */

    public function defaultScope()
    {
        $alias = $this->getTableAlias(true, false);
        return array(
            'condition' => $alias . '.`isRemoved` = 0',
            'order' => $alias . '.`dtimeCreate` DESC',
        );
    }

}
