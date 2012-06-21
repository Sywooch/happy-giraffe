<?php

class UserController extends HController
{
    public $layout = '//layouts/user';
    public $user;
    public $rubric_id;
    public $content_type_slug;

    private $_publicActions = array('profile', 'blog', 'friends', 'clubs', 'rss');

    public function filters()
    {
        return array(
            'accessControl',
            'locationForm, saveLocation + ajaxOnly'
        );
    }

    public function accessRules()
    {
        return array(
            array('allow',
                'actions' => $this->_publicActions,
                'users' => array('*'),
            ),
            array('allow',
                'actions' => array('myFriendRequests', 'createRelated', 'updateMood', 'testt'),
                'users' => array('@'),
            ),
            array('deny',
                'users' => array('*'),
            ),
        );
    }

    public function beforeAction($action)
    {
        Yii::app()->clientScript->scriptMap = array(
            'global.css' => false,
        );

        $user_id = (in_array($this->action->id, $this->_publicActions)) ? $this->actionParams['user_id'] : Yii::app()->user->id;
        $this->user = User::model()->getUserById($user_id);
        if ($this->user === null)
            throw new CHttpException(404, 'Пользователь не найден');
        return parent::beforeAction($action);
    }

    public function actionProfile($user_id)
    {
        $this->layout = '//layouts/main';
        $this->pageTitle = 'Анкета';

        Yii::import('application.widgets.user.*');
        Yii::import('site.common.models.interest.*');

        $user = User::model()->active()->with(array(
            'status',
            'purpose',
        ))->findByPk($user_id);
        if ($user === null)
            throw new CHttpException(404, 'Пользователь не найден');
        //if (!$user->calculateAccess('profile_access', Yii::app()->user->id))
        //    throw new CHttpException(403, 'Вы не можете просматривать страницу этого пользователя');

        if ($user->id == Yii::app()->user->id) {
            UserNotification::model()->deleteByEntity(UserNotification::NEW_COMMENT, $user);
        }

        $this->render('profile', array(
            'user' => $user,
        ));
    }

    public function actionClubs($user_id)
    {
        $this->pageTitle = 'Клубы';
        $this->render('clubs');
    }

    public function actionBlog($user_id, $rubric_id = null)
    {
        $this->layout = '//layouts/user_blog';
        $this->user = User::model()->with('blog_rubrics')->findByPk($user_id);
        if ($this->user === null)
            throw new CHttpException(404, 'Клуб не найден');
        $this->rubric_id = $rubric_id;

        $contents = CommunityContent::model()->getBlogContents($user_id, $rubric_id);
        $this->render('blog', array(
            'contents' => $contents,
        ));
    }

    public function actionFriends($user_id, $show = 'all')
    {
        $this->pageTitle = 'Друзья';
        $dataProvider = ($show == 'online') ? $this->user->getFriends('online = 1') : $this->user->getFriends();
        $dataProvider->pagination = array(
            'pageSize' => 12,
        );
        $this->render('friends', array(
            'dataProvider' => $dataProvider,
            'show' => $show,
        ));
    }

    public function actionMyFriendRequests($direction)
    {
        $dataProvider = Yii::app()->user->model->getFriendRequests($direction);
        $dataProvider->pagination = array(
            'pageSize' => 12,
        );
        $this->render('myFriendRequests', array(
            'dataProvider' => $dataProvider,
            'direction' => $direction,
        ));
    }

    /*
     * @todo убрать $model->refresh()
     */
    public function actionCreateRelated($relation)
    {
        if (Yii::app()->request->isAjaxRequest) {
            $entity = 'User' . ucfirst($relation);
            $model = new $entity;
            $model->user_id = Yii::app()->user->id;
            $model->text = Yii::app()->request->getPost('text');
            if ($model->save()) {
                $model->refresh();
                $response = array(
                    'status' => true,
                    'html' => $this->renderPartial('application.widgets.user.views._' . $relation, array(
                        $relation => $model,
                        'canUpdate' => true,
                    ), true),
                );
            } else {
                $response = array(
                    'status' => false,
                );
            }
            echo CJSON::encode($response);
        }
    }

    public function actionUpdateMood()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $user = Yii::app()->user->model;
            $user->mood_id = Yii::app()->request->getPost('mood_id');
            if ($user->save(true, array('mood_id'))) {
                echo $this->renderPartial('application.widgets.user.views._mood', array(
                    'mood' => $user->mood,
                    'canUpdate' => true,
                ));
            }
            else {
                print_r($user->errors);
            }
        }
    }

    public function actionRss($user_id)
    {
        Yii::import('ext.EFeed.*');
        $feed = new EFeed();

        $feed->title= 'Веселый Жираф - сайт для всей семьи';
        $feed->description = 'Социальная сеть для родителей и их детей';
        $feed->setImage('Веселый Жираф - сайт для всей семьи', 'http://www.happy-giraffe.ru/rss/', 'http://www.happy-giraffe.ru/images/logo_2.0.png');
        $feed->addChannelTag('language', 'ru-ru');
        $feed->addChannelTag('pubDate', date(DATE_RSS, time()));
        $feed->addChannelTag('link', 'http://www.happy-giraffe.ru/rss/' );

        if ($user_id == 1) {
            $criteria = new CDbCriteria(array(
                'condition' => 'type_id = 4 OR by_happy_giraffe = 1',
                'params' => array(':author_id' => $this->user->id),
                'limit' => 20,
                'order' => 'created DESC',
            ));
        } else {
            $criteria = new CDbCriteria(array(
                'condition' => 'author_id = :author_id AND type_id != 4 AND by_happy_giraffe = 0',
                'params' => array(':author_id' => $this->user->id),
                'limit' => 20,
                'order' => 'created DESC',
            ));
        }
        $contents = CommunityContent::model()->full()->findAll($criteria);

        foreach ($contents as $c) {
            $item = $feed->createNewItem();
            $item->title = $c->title;
            $item->link = $c->getUrl(false, true);
            $item->date = $c->created;
            $item->description = $c->preview;
            $item->addTag('author', $c->author->email);
            $feed->addItem($item);
        }

        $feed->generateFeed();
        Yii::app()->end();
    }

    public function actionTestt()
    {
        $virtuals = '10000
10003
10004
10007
10008
10009
10010
10011
10014
10017
10020
10021
10024
10025
10027
10028
10029
10031
10034
10036
10037
10039
10040
10041
10042
10043
10044
10046
10047
10048
10049
10050
10051
10053
10054
10057
10059
10061
10063
10065
10066
10067
10069
10070
10071
10072
10074
10075
10077
10078
10080
10084
10089
10092
10106
10138
10139
10140
10141
10142
10143
10144
10145
10146
10147
10149
10150
10151
10152
10156
10157
10158
10160
10161
10166
10169
10170
10171
10173
10175
10176
10177
10178
10179
10185
10188
10190
10191
10192
10194
10195
10199
10200
10207
10217
10218
10219
10220
10221
10226
10228
10229
10230
10235
10236
10237
10238
10239
10240
10241
10242
10246
10247
10248
10250
10252
10254
10255
10256
10257
10258
10259
10260
10261
10262
10263
10275
10276
10277
10278
10279
10280
10281
10282
10283
10284
10285
10286
10287
10288
10289
10291
10293
10294
10295
10297
10299
10300
10301
10302
10303
10304
10305
10306
10307
10308
10309
10310
10311
10312
10313
10314
10315
10316
10317
10318
10319
10320
10321
10322
10323
10324
10325
10326
10327
10328
10329
10330
10331
10332
10333
10334
10335
10336
10337
10338
10339
10340
10341
10343
10344
10345
10347
10348
10349
10350
10351
10352
10353
10356
116
120
121
123
124
126
127
128
129
130
131
132
133
134
135
136
137
138
139
140
141
142
143
144
145
146
147
148
149
150
151
152
153
154
155
156
157
161
171
176
19
25
30
31
32
33
34
35
36
37
39
40
41
42
44
45
46
47
5
9989
9992
9993
9994
9995
9996
9997';
        $virtuals = explode("\n", $virtuals);
        foreach($virtuals as $virtual){
            $model = User::model()->findByPk($virtual);
            if ($model !== null){
                $password = $this->createPassword(12);
                $model->password = $model->hashPassword($password);
                $model->recovery_disable = 1;
                $model->save('password', 'recovery_disable');

                Yii::app()->authManager->assign('virtual_user', $model->id);
            }
        }

        $moders = array(10186, 10127, 12678, 10229, 12980);
        foreach($moders as $moder){
            $model = User::model()->findByPk($moder);
            if ($model !== null){
                $password = $this->createPassword(12);
                $model->password = $model->hashPassword($password);
                $model->recovery_disable = 1;
                $model->save('password', 'recovery_disable');
            }
        }
    }

    function createPassword($length) {
        $chars = 'abcefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $i = 0;
        $password = "";
        while ($i <= $length) {
            $password .= $chars{mt_rand(0,strlen($chars) - 1)};
            $i++;
        }
        return $password;
    }
}