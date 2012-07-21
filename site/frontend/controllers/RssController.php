<?php
/**
 * Author: choo
 * Date: 21.05.2012
 */
class RssController extends HController
{
    public $limit = 20;

    public function init()
    {
        Yii::import('application.modules.cook.models.*');
        Yii::import('ext.EFeed.*');
    }

    public function actionIndex($page = 1)
    {
        $feed = new EFeed();

        $feed->title= 'Веселый Жираф - сайт для всей семьи';
        $feed->link = 'http://www.happy-giraffe.ru/';
        $feed->description = 'Социальная сеть для родителей и их детей';
        $feed->addChannelTag('generator', 'MyBlogEngine 1.1');
        //$feed->addChannelTag('wfw:commentRss', $this->createAbsoluteUrl('rss/comments'));
        $feed->addChannelTag('ya:more', $this->createAbsoluteUrl('rss/index', array('page' => $page + 1)));
        $feed->addChannelTag('image', array('url' => 'http://www.happy-giraffe.ru/images/logo_2.0.png', 'width' => 199, 'height' => 92));

        $sql = "(SELECT id, created, 'CommunityContent' AS entity FROM community__contents)
                UNION
                (SELECT id, created, 'CookRecipe' AS entity FROM cook__recipes)
                ORDER BY created DESC
                LIMIT :limit
                OFFSET :offset";
        $contents = $this->getContents($sql, $page);

        foreach ($contents as $c) {
            $item = $feed->createNewItem();
            $item->addTag('guid', $c->getUrl(false, true), array('isPermaLink'=>'true'));
            $item->addTag('author', $this->createAbsoluteUrl('blog/list', array('user_id' => $c->author->id)));
            $item->date = $c->created;
            $item->link = $c->getUrl(false, true);
            $item->description = $c->rssContent;
            $item->title = $c->title;
            $item->addTag('comments', $c->getUrl(true, true));
            $feed->addItem($item);
        }

        $feed->generateFeed();
        Yii::app()->end();
    }

    public function actionUser($user_id, $page = 1)
    {
        $user = User::model()->active()->findByPk($user_id);
        if ($user === null)
            throw new CHttpException(404, 'Пользователь не найден');

        Yii::import('ext.EFeed.*');
        $feed = new EFeed();

        $feed->title= 'Блог пользователя ' . $user->fullName;
        $feed->link = $this->createAbsoluteUrl('blog/list', array('user_id' => $user->id));
        $feed->description = ($user->blog_title === null) ? 'Блог - ' . $user->fullName : $user->blog_title;
        $feed->addChannelTag('generator', 'MyBlogEngine 1.1');
        $feed->addChannelTag('wfw:commentRss', $this->createAbsoluteUrl('rss/comments', array('user_id' => $user->id)));
        $feed->addChannelTag('ya:more', $this->createAbsoluteUrl('rss/user', array('user_id' => $user->id, 'page' => $page + 1)));
        $feed->addChannelTag('image', array('url' => $user->getAva(), 'width' => 72, 'height' => 72));

        if ($user->id == 1) {
            $criteria = new CDbCriteria(array(
                'condition' => 'type_id = 4 OR by_happy_giraffe = 1',
                'params' => array(':author_id' => $user->id),
                'limit' => $this->limit,
                'offset' => ($page - 1) * $this->limit,
                'order' => 'created DESC',
            ));

            $contents = CommunityContent::model()->full()->findAll($criteria);
        } else {
            if (in_array($user->id, array(10264, 10127, 10378, 23, 12678))) {
                $sql = "(SELECT id, created, 'CommunityContent' AS entity FROM community__contents WHERE author_id = :author_id AND type_id != 4 AND by_happy_giraffe = 0 AND rubric.user_id IS NOT NULL)
                        UNION
                        (SELECT id, created, 'CookRecipe' AS entity FROM cook__recipes WHERE author_id = :author_id)
                        ORDER BY created DESC
                        LIMIT :limit
                        OFFSET :offset";
            } else {
                $sql = "(SELECT id, created, 'CommunityContent' AS entity FROM community__contents WHERE author_id = :author_id AND type_id != 4 AND by_happy_giraffe = 0)
                        UNION
                        (SELECT id, created, 'CookRecipe' AS entity FROM cook__recipes WHERE author_id = :author_id)
                        ORDER BY created DESC
                        LIMIT :limit
                        OFFSET :offset";
            }

            $contents = $this->getContents($sql, $page, array(':author_id' => $user->id));
        }

        foreach ($contents as $c) {
            $item = $feed->createNewItem();
            $item->addTag('guid', $c->getUrl(false, true), array('isPermaLink'=>'true'));
            $item->addTag('author', $this->createAbsoluteUrl('blog/list', array('user_id' => $c->author->id)));
            $item->date = $c->created;
            $item->link = $c->getUrl(false, true);
            $item->description = $c->rssContent;
            $item->title = $c->title;
            $item->addTag('comments', $c->getUrl(true, true));
            $feed->addItem($item);
        }

        $feed->generateFeed();
        Yii::app()->end();
    }

    public function actionComments($user_id, $page = 1)
    {
        $user = User::model()->findByPk($user_id);

        $commentsCount = Comment::model()->count(array(
            'join' => 'LEFT OUTER JOIN community__contents ON community__contents.id = t.entity_id AND (t.entity = \'CommunityContent\' OR t.entity = \'BlogContent\')',
            'condition' => 'community__contents.author_id = :user_id AND community__contents.removed = 0',
            'params' => array(':user_id' => $user->id),
        ));

        $comments = Comment::model()->findAll(array(
            'join' => 'LEFT OUTER JOIN community__contents ON community__contents.id = t.entity_id AND (t.entity = \'CommunityContent\' OR t.entity = \'BlogContent\')',
            'condition' => 'community__contents.author_id = :user_id AND community__contents.removed = 0',
            'params' => array(':user_id' => $user->id),
            'limit' => $this->limit,
            'offset' => ($page - 1) * $this->limit,
            'with' => 'response',
        ));

        if (! $comments)
            throw new CHttpException(404, 'Такой записи не существует');

        $feed = new EFeed();
        $feed->link = $this->createAbsoluteUrl('blog/list', array('user_id' => $user->id));
        $feed->addChannelTag('generator', 'MyBlogEngine 1.1:comments');
        if ($commentsCount > $this->limit * $page)
            $feed->addChannelTag('ya:more', $this->createAbsoluteUrl('rss/comments', array('user_id' => $user->id, 'page' => $page + 1)));
        $feed->addChannelTag('category', 'ya:comments');

        foreach ($comments as $comment) {
            $content = CActiveRecord::model($comment->entity)->findByPk($comment->entity_id);

            $item = $feed->createNewItem();
            $item->addTag('guid', $comment->getUrl(true), array('isPermaLink'=>'true'));
            $item->addTag('ya:post', $content->getUrl(false, true));
            if ($comment->response) {
                $item->addTag('ya:parent', $comment->response->getUrl(true));
            }
            $item->date = $comment->created;
            $item->addTag('author', $comment->author->getUrl(true));
            $item->link = $comment->getUrl(true);
            $item->title = 'Комментарий к записи ' . $content->title;
            $item->description = $comment->text;
            $feed->addItem($item);
        }

        $feed->generateFeed();
        Yii::app()->end();
    }

    function getContents($sql, $page, $params = array())
    {
        $command = Yii::app()->db->createCommand($sql);
        $command->bindValue(':limit', $this->limit, PDO::PARAM_INT);
        $command->bindValue(':offset', ($page - 1) * $this->limit, PDO::PARAM_INT);
        foreach ($params as $name => $value)
            $command->bindValue($name, $value);
        $rows = $command->queryAll();
        $rowsByEntity = array();
        foreach ($rows as $r)
            $rowsByEntity[$r['entity']][] = $r['id'];
        $contents = array();
        foreach ($rowsByEntity as $entity => $ids) {
            $criteria = new CDbCriteria;
            $criteria->addInCondition('t.id', $ids);
            switch ($entity) {
                case 'CommunityContent':
                    $_contents = CActiveRecord::model($entity)->full()->findAll($criteria);
                    break;
                default:
                    $_contents = CActiveRecord::model($entity)->findAll($criteria);
            }
            foreach ($_contents as $c)
                $contents[] = $c;
        }
        usort($contents, array($this, 'cmp'));
        return $contents;
    }

    function cmp($a, $b)
    {
        if ($a->id == $b->id)
            return 0;
        return ($a->id < $b->id) ? -1 : 1;
    }
}

