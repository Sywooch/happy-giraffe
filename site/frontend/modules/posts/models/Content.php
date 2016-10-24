<?php

namespace site\frontend\modules\posts\models;

use site\frontend\modules\comments\models\Comment;
use site\frontend\modules\quests\components\QuestTypes;
use site\frontend\modules\quests\models\Quest;

/**
 * This is the model class for table "post__contents".
 *
 * The followings are the available columns in table 'post__contents':
 * @property string $id
 * @property string $url
 * @property string $authorId
 * @property string $title
 * @property string $text
 * @property string $html
 * @property string $preview
 * @property string $labels
 * @property array $labelsArray
 * @property string $dtimeCreate
 * @property string $dtimeUpdate
 * @property string $dtimePublication
 * @property string $originService
 * @property string $originEntity
 * @property string $originEntityId
 * @property string $originManageInfo
 * @property string $originManageInfoObject
 * @property integer $isDraft
 * @property integer $uniqueIndex
 * @property integer $isNoindex
 * @property integer $isNofollow
 * @property integer $isAutoMeta
 * @property integer $isAutoSocial
 * @property integer $isRemoved
 * @property integer $views
 * @property string $meta
 * @property site\frontentd\modules\posts\models\MetaInfo $metaObject
 * @property string $social
 * @property site\frontentd\modules\posts\models\SocialInfo $socialObject
 * @property string $template
 * @property site\frontentd\modules\posts\models\TemplateInfo $templateObject
 *
 * The followings are the available model relations:
 * @property PostLabels[] $labelModels
 * @property \User $author
 * @property int $comments_count
 * @property Quest $quest
 */
class Content extends \HActiveRecord implements \IHToJSON
{
    const BLOG_SERVICE = 'oldBlog';
    const COMMUNITY_SERVICE = 'oldCommunity';

    protected $labelDelimiter = '|';
    protected $_relatedModels = array();
    protected $_user = null;
    public static $slugAliases = array(
        'nppost' => 'NewPhotoPost',
        'post' => 'CommunityContent',
        'photopost' => 'CommunityContent', // до этого ключ был "photoPost"
        'status' => 'NewStatus',
        'advpost' => 'AdvPost',
        'video' => 'CommunityContent',
        'question' => 'CommunityContent',
    );
    public static $entityAliases = array(
        'CommunityContent' => 'CommunityContent',
        'BlogContent' => 'BlogContent',
        'NewPhotoPost' => 'site\frontend\modules\som\modules\photopost\models\Photopost',
        'NewStatus' => 'site\frontend\modules\som\modules\status\models\Status',
        'AdvPost' => 'site\frontend\modules\posts\models\Content',
    );
    protected $tagList = [];

    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'post__contents';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('text', 'filter', 'filter' => array($this, 'fillText'), 'on' => 'oldPost'),
            array('meta', 'filter', 'filter' => array($this->metaObject, 'serialize')),
            array('social', 'filter', 'filter' => array($this->socialObject, 'serialize')),
            array('template', 'filter', 'filter' => array($this->templateObject, 'serialize')),
            array('originManageInfo', 'filter', 'filter' => array($this->originManageInfoObject, 'serialize')),
            array('authorId, html, dtimeCreate, originService, originEntity, originEntityId, originManageInfo', 'required'),
            array('title', 'required', 'except' => 'oldStatusPost'),
            array('isDraft, isNoindex, isNofollow, isAutoMeta, isAutoSocial, isRemoved', 'boolean'),
            array('isDraft, isNoindex, isNofollow, isAutoMeta, isAutoSocial, isRemoved, dtimePublication', 'safe'),
            array('uniqueIndex', 'numerical', 'integerOnly' => true),
            array('url, title', 'length', 'max' => 255),
            array('authorId, dtimeCreate, dtimeUpdate, dtimePublication', 'length', 'max' => 10),
            array('originService, originEntity, originEntityId', 'length', 'max' => 100),
            array('text, preview, meta, social, template', 'safe'),
        );
    }

    public function fillText()
    {
        return trim(preg_replace('~\s+~', ' ', strip_tags(preg_replace('#<\/li>\s*<li>#', ' ', $this->html))));
    }

    /**
     * @return array relational rules.
     */
    public function relations()
    {
        return array(
            'labelModels' => array(self::MANY_MANY, '\site\frontend\modules\posts\models\Label', 'post__tags(contentId, labelId)'),
            'tagModels' => array(self::HAS_MANY, '\site\frontend\modules\posts\models\Tag', 'contentId'),
            'author' => array(self::BELONGS_TO, get_class(\User::model()), 'authorId'),
            'communityContent' => array(self::BELONGS_TO, 'CommunityContent', 'originEntityId'),
            'comments' => array(self::HAS_MANY, get_class(Comment::model()), 'new_entity_id'),
            'comments_count' => array(self::STAT, get_class(Comment::model()), 'new_entity_id'),
            'forum' => array(self::BELONGS_TO, get_class(\Community::model()), array('forum_id' => 'id'), 'through' => 'communityContent'),
            'club' => array(self::BELONGS_TO, get_class(\CommunityClub::model()), array('club_id' => 'id'), 'through' => 'forum'),
        );
    }

    public function apiRelations()
    {
        return array(
            'user' => array('site\frontend\components\api\ApiRelation', 'site\frontend\components\api\models\User', 'authorId', 'params' => array('avatarSize' => 40)),
        );
    }

    public function behaviors()
    {
        return array(
            'CacheDelete' => array(
                'class' => \site\frontend\modules\api\ApiModule::CACHE_DELETE,
            ),
            'PushStream' => array(
                'class' => \site\frontend\modules\api\ApiModule::PUSH_STREAM,
            ),
            'HTimestampBehavior' => array(
                'class' => 'HTimestampBehavior',
                'createAttribute' => 'dtimeCreate',
                'updateAttribute' => 'dtimeUpdate',
                'publicationAttribute' => 'dtimePublication',
                'owerwriteAttributeIfSet' => false,
            ),
            'ContentBehavior' => array(
                'class' => 'site\frontend\modules\notifications\behaviors\ContentBehavior',
                'pkAttribute' => 'originEntityId',
                'entityClass' => array('\site\frontend\modules\posts\models\Content', 'getEntityClassByContent'),
            ),
            'ActivityBehavior' => 'site\frontend\modules\som\modules\activity\behaviors\PostBehavior',
            'site\frontend\modules\posts\modules\myGiraffe\behaviors\PostBehavior',
            'RssBehavior' => array(
                'class' => 'site\frontend\modules\rss\behaviors\ContentRssBehavior',
            ),
            'softDelete' => array(
                'class' => 'site.common.behaviors.SoftDeleteBehavior',
                'removeAttribute' => 'isRemoved',
            ),
            'site\frontend\modules\posts\behaviors\HotBehavior',
            [
                'class' => 'site\frontend\modules\comments\behaviors\CommentableBehavior',
                'fk' => 'new_entity_id',
                'joinOn' => 'commentable.entity_id = ' . $this->getTableAlias(true) . '.originEntityId AND commentable.entity = ' . $this->getTableAlias(true) . '.originEntity',
            ],
            [
                'class'  => 'site\frontend\modules\comments\behaviors\BlogsCommentableBehavior',
                'fk'     => 'new_entity_id',
                'joinOn' => 'commentable.entity_id = ' . $this->getTableAlias(true) . '.originEntityId AND commentable.entity = "BlogContent"',
            ]
        );
    }

    public function getSlug()
    {
        return array_search($this->originEntity, Content::$slugAliases);
    }

    public function setSlug($slug)
    {
        $this->originEntity = Content::$slugAliases[$slug];
    }

    public static function getEntityByObject($obj)
    {
        // Костыль для блогов
        $entity = $obj->originService == 'oldBlog' ? 'BlogContent' : $obj->originEntity;
        return Content::$entityAliases[$entity];
    }

    public function getClass()
    {
        return self::$entityAliases[$this->originEntity];
    }

    public function setEntityClass($class)
    {
        $this->originEntity = array_search($class, Content::$entityAliases);
    }

    public static function getEntityClassByContent($content)
    {
        return Content::$entityAliases[$content->originEntity];
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'id' => 'ID',
            'url' => 'Url',
            'authorId' => 'Author',
            'title' => 'Title',
            'text' => 'Text',
            'html' => 'Html',
            'preview' => 'Preview',
            'labels' => 'Labels',
            'dtimeCreate' => 'Dtime Create',
            'dtimeUpdate' => 'Dtime Update',
            'dtimePublication' => 'Dtime Publication',
            'originService' => 'Origin Service',
            'originEntity' => 'Origin Entity',
            'originEntityId' => 'Origin Entity',
            'originManageInfo' => 'Origin Manage Info',
            'isDraft' => 'Is Draft',
            'uniqueIndex' => 'Unique Index',
            'isNoindex' => 'Is Noindex',
            'isNofollow' => 'Is Nofollow',
            'isAutoMeta' => 'Is Auto Meta',
            'isAutoSocial' => 'Is Auto Social',
            'isRemoved' => 'Is Removed',
            'meta' => 'Meta',
            'social' => 'Social',
            'template' => 'Template',
        );
    }

    public function toJSON()
    {
        return array(
            'id' => (int) $this->id,
            'url' => (string) $this->url,
            'authorId' => (int) $this->authorId,
            'title' => (string) $this->title,
            'text' => (string) $this->text,
            'html' => (string) $this->html,
            'preview' => (string) $this->preview,
            'labels' => $this->labelsArray,
            'dtimeCreate' => (int) $this->dtimeCreate,
            'dtimeUpdate' => (int) $this->dtimeUpdate,
            'dtimePublication' => is_null($this->dtimePublication) ? null : (int) $this->dtimePublication,
            'originService' => (string) $this->originService,
            'originEntity' => (string) $this->originEntity,
            'originEntityId' => (string) $this->originEntityId,
            'originManageInfo' => $this->originManageInfoObject->toJSON(),
            'isDraft' => (bool) $this->isDraft,
            'uniqueIndex' => is_null($this->uniqueIndex) ? null : (int) $this->uniqueIndex,
            'isNoindex' => (bool) $this->isNoindex,
            'isNofollow' => (bool) $this->isNofollow,
            'isAutoMeta' => (bool) $this->isAutoMeta,
            'isAutoSocial' => (bool) $this->isAutoSocial,
            'isRemoved' => (bool) $this->isRemoved,
            'meta' => $this->metaObject->toJSON(),
            'social' => $this->socialObject->toJSON(),
            'template' => $this->templateObject->toJSON(),
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     *
     * @return CActiveDataProvider the data provider that can return the models
     * based on the search/filter conditions.
     */
    public function search()
    {
        $criteria = new CDbCriteria;

        $criteria->compare('id', $this->id, true);
        $criteria->compare('url', $this->url, true);
        $criteria->compare('authorId', $this->authorId, true);
        /** @todo Переписать условие для тегов */
        $criteria->compare('labels', $this->labels, true);

        $criteria->compare('originService', $this->originService, true);
        $criteria->compare('originEntity', $this->originEntity, true);
        $criteria->compare('originEntityId', $this->originEntityId, true);

        $criteria->compare('isDraft', $this->isDraft);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function defaultScope()
    {
        return array(
            'condition' => $this->getTableAlias(true, false) . '.`isRemoved`=0',
        );
    }

    public function afterSave()
    {
        /** @todo убрать в поведение */
        $labels = $this->labelsArray;
        $oldLabels = $this->labelModels;
        foreach ($oldLabels as $oldLabel)
        {
            $i = array_search($oldLabel->text, $labels);
            if ($i === false)
            {
                // старого тега больше нет
                Tag::model()->deleteByPk(array('labelId' => $oldLabel->id, 'contentId' => $this->id));
            }
            else
            {
                // тег уже есть
                unset($labels[$i]);
            }
        }
        $ids = array();

        foreach ($labels as $label)
        {
            $model = Label::model()->findByAttributes(array('text' => $label));
            if (!$model)
            {
                $model = new Label();
                $model->text = $label;
                $model->save();
            }
            if ($model->id && !isset($ids[$model->id]))
            {
                $tag = new Tag();
                $tag->attributes = array('labelId' => $model->id, 'contentId' => $this->id);
                $tag->save();
            }
            $ids[$model->id] = 1;
        }

        return parent::afterSave();
    }

    public function getUser()
    {
        if (is_null($this->_user))
        {
            $this->_user = \site\frontend\components\api\models\User::model()->query('get', array(
                'id' => (int) $this->authorId,
                'avatarSize' => \Avatar::SIZE_MEDIUM,
            ));
        }

        return $this->_user;
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Content the static model class
     */
    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public function getCommentsUrl()
    {
        return $this->parsedUrl . '#commentsList';
    }

    public function getLabelsArray()
    {
        return empty($this->labels) ? array() : explode($this->labelDelimiter, $this->labels);
    }

    public function setLabelsArray($array)
    {
        $array = array_unique($array);
        $this->labels = implode($this->labelDelimiter, $array);
    }

    public function getOriginManageInfoObject()
    {
        if (!isset($this->_relatedModels['originalManageInfo']))
            $this->_relatedModels['originalManageInfo'] = new ManageInfo($this->originManageInfo, $this);

        return $this->_relatedModels['originalManageInfo'];
    }

    public function getMetaObject()
    {
        if (!isset($this->_relatedModels['metaObject']))
            $this->_relatedModels['metaObject'] = new MetaInfo($this->meta, $this);

        return $this->_relatedModels['metaObject'];
    }

    public function getSocialObject()
    {
        if (!isset($this->_relatedModels['socialObject']))
            $this->_relatedModels['socialObject'] = new SocialInfo($this->social, $this);

        return $this->_relatedModels['socialObject'];
    }

    public function getTemplateObject()
    {
        if (!isset($this->_relatedModels['templateObject']))
            $this->_relatedModels['templateObject'] = new TemplateInfo($this->template, $this);

        return $this->_relatedModels['templateObject'];
    }

    public function getParsedUrl()
    {
        return parse_url($this->url, PHP_URL_PATH);
    }

    /**
     *
     * @return string blog|community|other
     */
    public function getPostType()
    {
        $blogs = array(
            'oldBlog',
        );
        $community = array(
            'oldCommunity',
            'oldRecipe',
        );

        if (in_array($this->originService, $blogs))
        {
            return 'blog';
        }

        if (in_array($this->originService, $community))
        {
            return 'community';
        }

        return 'other';
    }

    /* scopes */

    /**
     *
     * @param int $authorId
     * @return site\frontend\modules\posts\models\Content
     */
    public function byAuthor($authorId)
    {
        $this->getDbCriteria()->addColumnCondition(array(
            'authorId' => $authorId,
        ));

        return $this;
    }

    /**
     *
     * @param string $entity
     * @param string $entityId
     * @return site\frontend\modules\posts\models\Content
     */
    public function byEntity($entity, $entityId)
    {
        $this->getDbCriteria()->addColumnCondition(array(
            'originEntity' => $entity,
            'originEntityId' => $entityId,
        ));

        return $this;
    }

    /**
     * @param string $slug
     * @param int $entityId
     *
     * @return Content
     */
    public function bySlug($slug, $entityId)
    {
        $slug = strtolower($slug);

        return $this->byEntity(Content::$slugAliases[$slug], $entityId);
    }

    /**
     * @return Content
     */
    public function published()
    {
        $this->getDbCriteria()->addCondition($this->tableAlias . '.dtimePublication IS NOT NULL');

        return $this;
    }

    /**
     * @return Content
     */
    public function orderAsc()
    {
        $this->getDbCriteria()->order = $this->tableAlias . '.dtimePublication ASC';

        return $this;
    }

    /**
     * @return Content
     */
    public function orderDesc()
    {
        $this->getDbCriteria()->order = $this->tableAlias . '.dtimePublication DESC';

        return $this;
    }

    /**
     * @param string $service
     *
     * @return Content
     */
    public function byService($service)
    {
        $this->getDbCriteria()->addColumnCondition(array('originService' => $service));

        return $this;
    }

    /**
     * Поиск по id тегов
     *
     * @param type $tags
     * @return \site\frontend\modules\posts\models\Content
     */
    public function byTags($tags)
    {
        if (! empty($tags)) {
            $criteria = $this->getDbCriteria();
            $criteria->addCondition($this->getTableAlias(true) . '.`id` IN (SELECT `contentId`
            FROM `post__tags`
            WHERE `labelId` IN (' . implode(', ', $tags) . ')
            GROUP BY `contentId`
            HAVING COUNT(`labelId`) = ' . count($tags) . ')');
        }
        return $this;
    }

    /**
     * Поиск по текстовым "ярлыкам"
     *
     * @param type $labels
     * @return \site\frontend\modules\posts\models\Content
     */
    public function byLabels($labels)
    {
        $tags = \site\frontend\modules\posts\models\Label::getIdsByLabels($labels);
        if (count($labels) != count($tags))
        {
            $this->getDbCriteria()->addCondition('1=0');
            return $this;
        }

        return $this->byTags($tags);
    }

    /**
     * @param string $entity
     *
     * @return Content
     */
    public function byEntityClass($entity)
    {
        $this->getDbCriteria()->addColumnCondition(array('originEntity' => $entity));

        return $this;
    }

    /**
     * @param int $offset
     *
     * @return Content
     */
    public function publishedAtLast($offset)
    {
        $this->getDbCriteria()->compare('dtimePublication', '>', time() - $offset);

        return $this;
    }

    /**
     * @param int $userId
     *
     * @return Content
     */
    public function withoutUserComments($userId)
    {
        $this->getDbCriteria()->addCondition('(select COUNT(*) from comments as c where `c`.author_id = ' . $userId . ' and `c`.new_entity_id = ' . $this->tableAlias . '.id) = 0');

        return $this;
    }

    /**
     * @param int $forumId
     *
     * @return Content
     */
    public function byForum($forumId)
    {
        if (!isset($this->getDbCriteria()->with['communityContent'])) {
            $this->getDbCriteria()->with[] = 'communityContent';
        }
        $this->getDbCriteria()->compare('communityContent.forum_id', $forumId);

        return $this;
    }

    /**
     * @param array $forumIds
     *
     * @return Content
     */
    public function byForums($forumIds)
    {
        if (!isset($this->getDbCriteria()->with['communityContent'])) {
            $this->getDbCriteria()->with[] = 'communityContent';
        }
        $this->getDbCriteria()->addInCondition('communityContent.forum_id', $forumIds);

        return $this;
    }

    /**
     * @param array $clubIds
     *
     * @return Content
     */
    public function byClubs($clubIds)
    {
        if (!isset($this->getDbCriteria()->with['club'])) {
            $this->getDbCriteria()->with[] = 'club';
        }
        $this->getDbCriteria()->addInCondition('club.id', $clubIds);

        return $this;
    }

    /**
     * @return int
     */
    public function getDistinctComments()
    {
        return \Comment::model()->count(array(
            'condition' => 'new_entity_id = :new_entity_id',
            'params' => array(':new_entity_id' => $this->id),
            'distinct' => true,
            'select' => 'author_id'
        ));
    }

    /**
     * @return Content
     */
    public function byActiveQuest()
    {
        $alias = $this->getTableAlias();
        $userId = \Yii::app()->user->id;

        $this->getDbCriteria()
            ->addCondition("not exists(select * from `quests` `q` where `q`.model_id = {$alias}.id and `q`.model_name = 'Content' and `q`.user_id = {$userId})
                or (select count(`quest`.id) from `quests` `quest` where `quest`.model_id = {$alias}.id and `quest`.is_completed = 0 and `quest`.is_dropped = 0
                and `quest`.model_name = 'Content' and `quest`.user_id = {$userId}) = 1");

        return $this;
    }

    /**
     * @return Content
     */
    public function notMine()
    {
        $this->getDbCriteria()->addCondition($this->getTableAlias() . '.authorId != ' . \Yii::app()->user->id);

        return $this;
    }

    /**
     * возвращает модифицированный критерий выборки из бд списка постов форума
     * @param array $labelsId
     */
    public function createCriteriaForForum(array $labelsId)
    {

        $tags = \site\frontend\modules\posts\models\Label::getIdsByLabels($labelsId);
        if (count($labelsId) != count($tags))
        {
            $this->getDbCriteria()->addCondition('1=0');
            return $this;
        }
        $cr = $this->getDbCriteria();
        $cr->with = [];
        $cr->having = '';
        $cr->join = 'JOIN (SELECT pt.contentId FROM post__tags AS pt WHERE pt.labelId in ('
                . implode(', ', $tags)
                . ') GROUP BY pt.contentId HAVING (count(pt.contentId) = ' . count($tags) . ')'
                . ') AS tmp ON (tmp.contentId=t.id)';
        $cr->order = $this->tableAlias . '.dtimePublication DESC';
        return $cr;
    }

    /**
     * возвращает список последних постов по метке, в частности для форума
     * @param int $labelId
     * @param int $limit
     * @return \site\frontend\modules\posts\models\Content
     * @author crocodile
     */
//    public function getLastByLabel($labelId, $limit)
//    {
//
//        $tags = \site\frontend\modules\posts\models\Label::getIdsByLabels(array($labelId));
//        if (sizeof($tags) == 0)
//        {
//            return [];
//        }
//        $this->resetScope();
//        $criteria = $this->getDbCriteria();
//        $criteria->with = [];
//        $criteria->having = '';
//        $criteria->join = "JOIN (SELECT pt.contentId  FROM post__tags AS pt "
//                . " WHERE pt.labelId=" . intval($tags[0])
//                . " ORDER BY pt.contentId desc LIMIT 100)  AS tmp on (tmp.contentId=t.id)";
//        return $this->orderDesc()->findAll(array(
//                    'limit' => $limit
//        ));
//    }

    /**
     * Создаёт критерй для выбора поста, стоящего с "лева" от переданого поста.
     * Из за некой специфики выборки, критерий представляет из себя
     * выборку требуемого поста по id
     * @param site\frontend\modules\posts\models\Content $post
     * @return site\frontend\modules\posts\models\Content
     */
    public function leftFor($post)
    {
//        $labelsList = [];
//        if (sizeof($this->tagList) > 0)
//        {
//            $labelsList = $this->tagList;
//        }
//        else
//        {
//            $labelsList = array_map(function($lb)
//            {
//                return $lb->id;
//            }, $post->labelModels);
//        }
//        $labelsCount = sizeof($labelsList);
//        $labelsList = implode(', ', $labelsList);
//
//        $sql = "SELECT *
//FROM post__contents AS pc
//	JOIN (SELECT pt.contentId
//	FROM post__tags AS pt
//	WHERE pt.labelId in ({$labelsList})
//	GROUP BY pt.contentId
//	HAVING COUNT(pt.contentId) = {$labelsCount}
//	) AS tmp ON (pc.id=tmp.contentId)
//WHERE  pc.isRemoved = 0
//    AND (pc.dtimePublication<{$post->dtimePublication})
//ORDER BY pc.dtimePublication DESC
//LIMIT 1";
//        $itm = \Yii::app()->db->createCommand($sql)->queryAll(true);
//        if (isset($itm[0]))
//        {
//            $criteria = $this->getDbCriteria();
//            $criteria->condition = 'id=' . $itm[0]['id'];
//            $criteria->with = [];
//            $criteria->params = [];
//            $criteria->group = '';
//            $criteria->having = '';
//        }
//        else
//        {
//            $this->getDbCriteria()->condition = 'id=-1';
//        }
//        return $this;

        $this->getDbCriteria()->compare('dtimePublication', '<' . $post->dtimePublication);
        $this->orderDesc();
        $this->getDbCriteria()->limit = 1;
        return $this;
    }

    /**
     *
     * @param site\frontend\modules\posts\models\Content $post
     * @return site\frontend\modules\posts\models\Content
     */
    public function rightFor($post)
    {
        $this->getDbCriteria()->compare('dtimePublication', '>' . $post->dtimePublication);
        $this->orderAsc();
        $this->getDbCriteria()->limit = 1;

        return $this;
    }

    /**
     * @todo переосмыслить (метод поощряет нарушение SOA)
     * @param string $prefix
     * @return null|Label
     */
    public function getLabelTextByPrefix($prefix)
    {
        foreach ($this->labelsArray as $label) {
            if (strpos($label, $prefix) !== false) {
                return str_replace($prefix, '', $label);
            }
        }
        return null;
    }
}
