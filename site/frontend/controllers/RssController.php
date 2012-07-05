<?php
/**
 * Author: choo
 * Date: 21.05.2012
 */
class RssController extends HController
{
    public $limit = 20;

    public function actionIndex($page = 1)
    {
        Yii::import('ext.EFeed.*');
        $feed = new EFeed();

        $feed->title= 'Веселый Жираф - сайт для всей семьи';
        $feed->link = 'http://www.happy-giraffe.ru/';
        $feed->description = 'Социальная сеть для родителей и их детей';
        $feed->addChannelTag('generator', 'MyBlogEngine 1.1');
        //$feed->addChannelTag('wfw:commentRss', $this->createAbsoluteUrl('rss/comments'));
        $feed->addChannelTag('ya:more', $this->createAbsoluteUrl('rss/index', array('page' => $page + 1)));
        $feed->addChannelTag('image', array('url' => 'http://www.happy-giraffe.ru/images/logo_2.0.png', 'width' => 199, 'height' => 92));

        $contents = CommunityContent::model()->full()->findAll(array(
            'limit' => $this->limit,
            'offset' => ($page - 1) * $this->limit,
            'order' => 'created DESC',
        ));

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
        $user = User::model()->findByPk($user_id);

        Yii::import('ext.EFeed.*');
        $feed = new EFeed();

        $feed->title= 'Блог пользователя ' . $user->fullName;
        $feed->link = $this->createAbsoluteUrl('blog/list', array('user_id' => $user->id));
        $feed->description = 'Мой личный блог';
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
        } else {
            if (in_array($user->id, array(10264, 10127, 10378, 23, 12678))) {
                $criteria = new CDbCriteria(array(
                    'condition' => 'author_id = :author_id AND type_id != 4 AND by_happy_giraffe = 0 AND rubric.user_id IS NOT NULL',
                    'params' => array(':author_id' => $user->id),
                    'limit' => $this->limit,
                    'offset' => ($page - 1) * $this->limit,
                    'order' => 'created DESC',
                ));
            } else {
                $criteria = new CDbCriteria(array(
                    'condition' => 'author_id = :author_id AND type_id != 4 AND by_happy_giraffe = 0',
                    'params' => array(':author_id' => $user->id),
                    'limit' => $this->limit,
                    'offset' => ($page - 1) * $this->limit,
                    'order' => 'created DESC',
                ));
            }
        }
        $contents = CommunityContent::model()->full()->findAll($criteria);

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

        Yii::import('ext.EFeed.*');
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
}

