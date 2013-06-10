<?php
/**
 * Author: alexk984
 * Date: 13.07.12
 */

class UserStats
{
    public $date;
    public $date2 = null;
    public $group = null;
    public $user_id = null;

    public function regCount()
    {
        return Yii::app()->db->createCommand('select count(id) from users where register_date >= "' . $this->date . ' 00:00:00" AND register_date <= "' . $this->date . ' 23:59:59";')->queryScalar();
    }

    public function contentsCriteria()
    {
        $criteria = new CDbCriteria;
        $this->addAuthorCriteria($criteria);
        $this->addDateCriteria($criteria);
        $criteria->compare('removed', 0);
        return $criteria;
    }

    /*************** CLUB ******************/
    public function clubPostCount()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('type_id', 1);
        $criteria->mergeWith(self::clubContentsCriteria());
        return CommunityContent::model()->count($criteria);
    }

    public function clubVideoCount()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('type_id', 2);
        $criteria->mergeWith(self::clubContentsCriteria());
        return CommunityContent::model()->count($criteria);
    }

    public function clubContentsCriteria()
    {
        $criteria = new CDbCriteria;
        $criteria->with = array(
            'rubric' => array(
                'condition' => 'rubric.user_id IS NULL'
            ),
        );
        $criteria->mergeWith(self::contentsCriteria($this->date, $this->group));
        return $criteria;
    }

    public function clubCommentsCount()
    {
        $criteria = new CDbCriteria;
        $this->addAuthorCriteria($criteria);
        $this->addDateCriteria($criteria);
        $criteria->compare('entity', 'CommunityContent');
        $criteria->compare('removed', 0);

/*        if ($this->group == UserGroup::USER) {
            $test_data = Comment::model()->findAll($criteria);
            foreach ($test_data as $comment) {
                echo '<a href="http://www.happy-giraffe.ru'.$comment->getUrl().'" target="_blank">link</a><br>';
            }
        }*/
        return Comment::model()->count($criteria);
    }


    /*************** BLOG ******************/
    public function blogContentsCriteria()
    {
        $criteria = new CDbCriteria;
        $criteria->with = array(
            'rubric' => array(
                'condition' => 'rubric.user_id IS NOT NULL'
            ),
        );
        $criteria->mergeWith(self::contentsCriteria($this->date, $this->group));
        return $criteria;
    }

    public function blogPostCount()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('type_id', 1);
        $criteria->mergeWith(self::blogContentsCriteria());
        return CommunityContent::model()->count($criteria);
    }

    public function blogVideoCount()
    {
        $criteria = new CDbCriteria;
        $criteria->compare('type_id', 2);
        $criteria->mergeWith(self::blogContentsCriteria());
        return CommunityContent::model()->count($criteria);
    }

    public function blogCommentsCount()
    {
        $criteria = new CDbCriteria;
        $this->addAuthorCriteria($criteria);
        $this->addDateCriteria($criteria);
        $criteria->compare('entity', 'BlogContent');
        $criteria->compare('removed', 0);
        return Comment::model()->count($criteria);
    }

    /*************** SERVICE ******************/
    public function servicePostCount()
    {
        Yii::import('site.frontend.modules.cook.models.*');
        $criteria = new CDbCriteria;
        $this->addAuthorCriteria($criteria);
        $this->addDateCriteria($criteria);

        return CookRecipe::model()->count($criteria);
    }

    public function serviceCommentsCount()
    {
        Yii::import('site.frontend.modules.cook.models.*');
        $criteria = new CDbCriteria;
        $this->addAuthorCriteria($criteria);
        $this->addDateCriteria($criteria);

        $criteria->compare('entity', 'CookRecipe');
        $criteria->compare('removed', 0);
        $result = Comment::model()->count($criteria);

        $criteria = new CDbCriteria;
        $this->addAuthorCriteria($criteria);
        $this->addDateCriteria($criteria);

        $criteria->compare('entity', 'AlbumPhoto');
        $criteria->compare('removed', 0);

        $result += Comment::model()->count($criteria);

        return $result;
    }

    /*************** GUESTBOOK ******************/
    public function guestBookCommentsCount()
    {
        $criteria = new CDbCriteria;
        $this->addAuthorCriteria($criteria);
        $this->addDateCriteria($criteria);

        $criteria->compare('entity', 'User');
        $criteria->compare('removed', 0);
        return Comment::model()->count($criteria);
    }

    /*************** PHOTO ******************/
    public function personalPhotoCount()
    {
        $criteria = new CDbCriteria;
        $criteria->with = array(
            'album' => array(
                'condition' => 'type = 0 OR type = 1 OR type = 3'
            ),
        );
        $this->addAuthorCriteria($criteria);
        $this->addDateCriteria($criteria);
        $criteria->compare('t.removed', 0);
        return AlbumPhoto::model()->count($criteria);
    }

    public function servicesPhotoCount()
    {
        $criteria = new CDbCriteria;
        $criteria->with = array(
            'attach' => array(
                'condition' => 'attach.entity = "CookDecoration"'
            ),
        );
        $this->addAuthorCriteria($criteria);
        $this->addDateCriteria($criteria);
        $criteria->compare('t.removed', 0);
        return AlbumPhoto::model()->count($criteria);
    }

    /*************** PERSONAL MESSAGES ******************/
    public function messagesCount()
    {
        Yii::import('site.frontend.modules.im.models.*');

        $criteria = new CDbCriteria;
        $this->addAuthorCriteria($criteria, 'author');
        $this->addDateCriteria($criteria);
        return MessagingMessage::model()->count($criteria);
    }

    public function friendsCount()
    {
        $criteria = new CDbCriteria;
        $this->addAuthorCriteria($criteria, 'from');
        $this->addDateCriteria($criteria);
        $fromCount = FriendRequest::model()->count($criteria);

        $this->addAuthorCriteria($criteria, 'to');
        $toCount = FriendRequest::model()->count($criteria);

        return ($fromCount + $toCount);
    }

    /*************** GET USERS WRITERS ******************/
    public function postWriters()
    {

    }

    /*************** GLOBAL ******************/
    /**
     * @param $criteria CDbCriteria
     * @return CDbCriteria
     */
    public function addDateCriteria($criteria)
    {
        if ($this->date2 == null)
            $criteria->mergeWith(array('condition' => 't.created >= "' . $this->date . ' 00:00:00" AND t.created <= "' . $this->date . ' 23:59:59"'));
        else
            $criteria->mergeWith(array('condition' => 't.created >= "' . $this->date2 . ' 00:00:00" AND t.created <= "' . $this->date . ' 23:59:59"'));
        return $criteria;
    }

    /**
     * @param $criteria CDbCriteria
     * @param string $rel_name
     * @return CDbCriteria
     */
    public function addAuthorCriteria($criteria, $rel_name = 'author')
    {
        $criteria2 = new CDbCriteria;
        if ($this->user_id == null)
            $criteria2->with = array(
                $rel_name => array(
                    'condition' => $rel_name . '.group = ' . $this->group
                )
            );
        else
            $criteria2->with = array(
                $rel_name => array(
                    'condition' => $rel_name . '.id = ' . $this->user_id
                )
            );
        $criteria->mergeWith($criteria2);
        return $criteria;
    }
}