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
        Yii::import('application.modules.contest.models.*');
        Yii::import('application.modules.services.modules.horoscope.models.*');
        Yii::import('ext.EFeed.*');
    }

    public function actionIndex($page = 1)
    {
        $feed = new EFeed();

        $feed->title = 'Веселый Жираф - сайт для всей семьи';
        $feed->link = 'http://www.happy-giraffe.ru/';
        $feed->description = 'Социальная сеть для родителей и их детей';
        $feed->addChannelTag('generator', 'MyBlogEngine 1.1');
        //$feed->addChannelTag('wfw:commentRss', $this->createAbsoluteUrl('rss/comments'));
        $feed->addChannelTag('ya:more', $this->createAbsoluteUrl('rss/index', array('page' => $page + 1)));
        $feed->addChannelTag('image', array('url' => 'http://www.happy-giraffe.ru/images/logo_2.0.png', 'width' => 199, 'height' => 92));

        $sql = "(SELECT id, created, 'CommunityContent' AS entity FROM community__contents)
                UNION
                (SELECT id, created, 'CookRecipe' AS entity FROM cook__recipes)
                UNION
                (SELECT id, created, 'ContestWork' AS entity FROM contest__works)
                UNION
                (SELECT id, created, 'CookDecoration' AS entity FROM cook__decorations)
                UNION
                (SELECT id, created, 'Horoscope' AS entity FROM services__horoscope)
                ORDER BY created DESC
                LIMIT :limit
                OFFSET :offset";
        $contents = $this->getContents($sql, $page);

        if (empty($contents))
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');

        foreach ($contents as $c) {
            $item = $feed->createNewItem();
            if (get_class($c) == 'Horoscope') {
                $item->addTag('guid', $c->getUrl(true), array('isPermaLink' => 'true'));
                $item->addTag('author', $this->createAbsoluteUrl('blog/list', array('user_id' => User::HAPPY_GIRAFFE)));
                $item->date = $c->created;
                $item->link = $c->getUrl(true);
                $item->description = $c->rssContent;
                $item->title = $c->getTitle();
            } else {
                $item->addTag('guid', $c->getUrl(false, true), array('isPermaLink' => 'true'));
                $item->addTag('author', $this->createAbsoluteUrl('blog/list', array('user_id' => $c->author->id)));
                $item->date = $c->created;
                $item->link = $c->getUrl(false, true);
                $item->description = $c->rssContent;
                $item->title = $c->title;
                $item->addTag('comments', $c->getUrl(true, true));
            }
            $feed->addItem($item);
        }

        $feed->generateFeed();
        Yii::app()->end();
    }

    public function actionNews($for = null)
    {
        if ($for == 'yandex')
            $headAttributes = array(
                'xmlns:yandex' => 'http://news.yandex.ru',
                'xmlns:media' => 'http://search.yahoo.com/mrss/',
                'version' => '2.0',
            );
        else
            $headAttributes = array(
                'version' => '2.0',
                'xmlns:content' => 'http://purl.org/rss/1.0/modules/content/',
                'xmlns:wfw' => 'http://wellformedweb.org/CommentAPI/',
            );

        $feed = new EFeed(EFeed::RSS2, $headAttributes);

        $feed->title = 'Веселый Жираф - сайт для всей семьи';
        $feed->link = 'http://www.happy-giraffe.ru/';
        $feed->description = 'Социальная сеть для родителей и их детей';
        $feed->addChannelTag('image', array(
            'title' => 'Веселый Жираф - сайт для всей семьи',
            'link' => 'http://www.happy-giraffe.ru/',
            'url' => 'http://www.happy-giraffe.ru/images/logo_rss.png',
            'width' => 144,
            'height' => 144,
        ));

        $contents = CommunityContent::model()->active()->full()->findAll(array(
            'condition' => 'rubric.community_id = :community_id',
            'params' => array(':community_id' => Community::COMMUNITY_NEWS),
            'order' => 'created DESC',
            'limit' => 20,
        ));

        foreach ($contents as $c) {
            $item = $feed->createNewItem();
            $item->title = $c->title;
            $item->link = $c->getUrl(false, true);
            $item->date = $c->created;
            $item->addTag('category', $c->rubric->title);
            if ($for == 'yandex') {
                $item->addTag('yandex:full-text', strip_tags($c->content->text));

                $src = $c->getContentImage(600);
                $size = getimagesize($src);
                $item->addTag('enclosure', '', array('url' => $src, 'type' => $size['mime']));

                if ($c->content->genre)
                    $item->addTag('yandex:genre', $c->content->genre);
            } else {
                $item->description = $c->rssContent;
            }
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

        $feed->title = 'Блог пользователя ' . $user->fullName;
        $feed->link = $this->createAbsoluteUrl('blog/list', array('user_id' => $user->id));
        $feed->description = ($user->blog_title === null) ? 'Блог - ' . $user->fullName : $user->blog_title;
        $feed->addChannelTag('generator', 'MyBlogEngine 1.1');
        $feed->addChannelTag('wfw:commentRss', $this->createAbsoluteUrl('rss/comments', array('user_id' => $user->id)));
        $feed->addChannelTag('ya:more', $this->createAbsoluteUrl('rss/user', array('user_id' => $user->id, 'page' => $page + 1)));
        $feed->addChannelTag('image', array('url' => $user->getAva(), 'width' => 72, 'height' => 72));

        if ($user->id == User::HAPPY_GIRAFFE) {
            $sql = "(SELECT id, created, 'CommunityContent' AS entity FROM community__contents WHERE type_id = 4 OR by_happy_giraffe = 1)
                        UNION
                        (SELECT id, created, 'Horoscope' AS entity FROM services__horoscope)
                        ORDER BY created DESC
                        LIMIT :limit
                        OFFSET :offset";
            $contents = $this->getContents($sql, $page);
        } else {
            if (in_array($user->id, array(10264, 10127, 10378, 23, 12678))) {
                $sql = "(SELECT community__contents.id, created, 'CommunityContent' AS entity FROM community__contents JOIN community__rubrics ON community__contents.rubric_id = community__rubrics.id WHERE author_id = :author_id AND type_id != 4 AND by_happy_giraffe = 0 AND community__rubrics.user_id IS NOT NULL)
                        UNION
                        (SELECT id, created, 'CookRecipe' AS entity FROM cook__recipes WHERE author_id = :author_id)
                        UNION
                        (SELECT id, created, 'ContestWork' AS entity FROM contest__works WHERE user_id = :author_id)
                        UNION
                        (SELECT cook__decorations.id, cook__decorations.created, 'CookDecoration' AS entity FROM cook__decorations INNER JOIN album__photos ON cook__decorations.photo_id = album__photos.id WHERE album__photos.author_id = :author_id)
                        ORDER BY created DESC
                        LIMIT :limit
                        OFFSET :offset";
            } else {
                $sql = "(SELECT id, created, 'CommunityContent' AS entity FROM community__contents WHERE author_id = :author_id AND type_id != 4 AND by_happy_giraffe = 0)
                        UNION
                        (SELECT id, created, 'CookRecipe' AS entity FROM cook__recipes WHERE author_id = :author_id)
                        UNION
                        (SELECT id, created, 'ContestWork' AS entity FROM contest__works WHERE user_id = :author_id)
                        UNION
                        (SELECT cook__decorations.id, cook__decorations.created, 'CookDecoration' AS entity FROM cook__decorations INNER JOIN album__photos ON cook__decorations.photo_id = album__photos.id WHERE album__photos.author_id = :author_id)
                        ORDER BY created DESC
                        LIMIT :limit
                        OFFSET :offset";
            }

            $contents = $this->getContents($sql, $page, array(':author_id' => $user->id));
        }

        if (empty($contents))
            Yii::app()->end();

        foreach ($contents as $c) {
            $item = $feed->createNewItem();
            if (get_class($c) == 'Horoscope') {
                $item->addTag('guid', $c->getUrl(true), array('isPermaLink' => 'true'));
                $item->addTag('author', $this->createAbsoluteUrl('blog/list', array('user_id' => User::HAPPY_GIRAFFE)));
                $item->date = $c->created;
                $item->link = $c->getUrl(true);
                $item->description = $c->rssContent;
                $item->title = $c->getTitle();
            } else {
                $item->addTag('guid', $c->getUrl(false, true), array('isPermaLink' => 'true'));
                $item->addTag('author', $this->createAbsoluteUrl('blog/list', array('user_id' => $c->author->id)));
                $item->date = $c->created;
                $item->link = $c->getUrl(false, true);
                $item->description = $c->rssContent;
                $item->title = $c->title;
                $item->addTag('comments', $c->getUrl(true, true));
            }
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

        if (!$comments)
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
            $item->addTag('guid', $comment->getUrl(true), array('isPermaLink' => 'true'));
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
        if ($a->created == $b->created)
            return 0;
        return ($a->created > $b->created) ? -1 : 1;
    }

    public function actionSocial($page = 1)
    {
        $feed = new EFeed();
        $this->limit = 1;
        $feed->title = 'Веселый Жираф - сайт для всей семьи';
        $feed->link = 'http://www.happy-giraffe.ru/';
        $feed->description = 'Социальная сеть для родителей и их детей';
        $feed->addChannelTag('generator', 'MyBlogEngine 1.1');
        //$feed->addChannelTag('wfw:commentRss', $this->createAbsoluteUrl('rss/comments'));
        $feed->addChannelTag('ya:more', $this->createAbsoluteUrl('rss/index', array('page' => $page + 1)));
        $feed->addChannelTag('image', array('url' => 'http://www.happy-giraffe.ru/images/logo_2.0.png', 'width' => 199, 'height' => 92));

        $sql = "SELECT id, created, 'CommunityContent' AS entity FROM community__contents
                ORDER BY created DESC
                LIMIT :limit
                OFFSET :offset";
        $contents = $this->getContents($sql, $page);

        foreach ($contents as $c) {
            $item = $feed->createNewItem();
            $item->addTag('guid', $c->getUrl(false, true), array('isPermaLink' => 'true'));
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
}

