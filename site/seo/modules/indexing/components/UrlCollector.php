<?php
/**
 * Author: alexk984
 * Date: 23.08.12
 */
class UrlCollector
{
    const PER_PAGE = 50;

    function __construct()
    {
        Yii::import('site.frontend.modules.services.modules.recipeBook.models.*');
        Yii::import('site.frontend.modules.services.modules.names.models.*');
        Yii::import('site.frontend.components.ManyToManyBehavior');
        Yii::import('site.frontend.modules.cook.models.*');
    }

    public function collectUrls()
    {
        echo "club posts\n";
        $this->collectClubContent();
        echo "blog posts\n";
        $this->collectBlogs();

        //morning
        echo "morning\n";
        $morning = array_merge(range(14, 21), range(146, 213));
        foreach ($morning as $letter)
            $this->addUrl('http://www.happy-giraffe.ru/morning/' . $letter, 1);

        //весь контент
        $articles = array(1);
        $criteria = new CDbCriteria;
        $criteria->limit = 100;
        $criteria->offset = 0;
        $criteria->condition = 'rubric.user_id IS NULL AND created > :created';
        $criteria->params = array(
            ':created' => date("Y-m-d H:i:s", strtotime('-4 weeks'))
        );
        $criteria->with = array(
            'rubric' => array(
                'with' => array(
                    'community' => array(
                        'select' => 'id, title, position',
                    )
                ),
            ),
            'type' => array(
                'select' => 'slug',
            ));
        $i = 0;

        echo "all club posts\n";
        while (!empty($articles)) {
            $articles = CommunityContent::model()->findAll($criteria);
            foreach ($articles as $article) {
                $url = $article->getUrl();
                $url = trim($url, '.');
                $this->addUrl('http://www.happy-giraffe.ru' . $url);
            }
            $i++;
            $criteria->offset = $i * 100;

            echo $i . "\n";
        }

        $this->collectServices();
    }

    public function collectBlogs()
    {
        $users = User::model()->findAll('t.deleted = 0');

        foreach ($users as $user) {

            $posts = $user->blogPosts;
            if (count($posts) > 0) {
                $this->addUrl('http://www.happy-giraffe.ru/user/' . $user->id . '/', 1);
                $ids = array();

                foreach ($posts as $post) {
                    $ids [] = $post->id;
                }
                if (count($ids) >= self::PER_PAGE) {
                    $ids = $this->getIdsForQueries($ids);
                    foreach ($ids as $id)
                        $this->addUrl('http://www.happy-giraffe.ru/user/' . $user->id . '/blog/post' . $id, 1);
                    $this->addUrl('http://www.happy-giraffe.ru/user/' . $user->id . '/blog/', 1);
                } elseif (count($ids) < self::PER_PAGE && count($ids) > 1)
                    $this->addUrl('http://www.happy-giraffe.ru/user/' . $user->id . '/blog/', 1);
            } else {
                if ($user->commentsCount > 0 || $user->communityPostsCount > 0)
                    $this->addUrl('http://www.happy-giraffe.ru/user/' . $user->id . '/', 1);
            }
        }
    }

    public function collectClubContent()
    {
        $communities = Community::model()->findAll();
        foreach ($communities as $community) {
            echo 'community ' . $community->id . "\n";
            $types = array(1 => 'post', 2 => 'video');
            foreach ($types as $key => $type) {
                $posts = CommunityContent::model()->with('rubric', 'rubric.community')->findAll('community.id=' . $community->id . ' AND type.id = ' . $key);
                if (count($posts) > 0) {
                    $this->addUrl('http://www.happy-giraffe.ru/community/' . $community->id . '/forum/' . $type . '/', 1);

                    if (count($posts) >= self::PER_PAGE) {
                        $ids = array();

                        foreach ($posts as $post) {
                            $ids [] = $post->id;
                        }
                        if (count($ids) >= self::PER_PAGE) {
                            $ids = $this->getIdsForQueries($ids);
                            foreach ($ids as $id)
                                $this->addUrl('http://www.happy-giraffe.ru/community/' . $community->id . '/forum/' . $type . '/' . $id, 1);
                        }
                    }
                }
            }
        }

    }


    public function collectServices()
    {
        //services
        echo "names\n";
        $this->addUrl('http://www.happy-giraffe.ru/names/saint/');
        $this->addUrl('http://www.happy-giraffe.ru/names/top10/');
        foreach (range('A', 'Z') as $letter)
            $this->addUrl('http://www.happy-giraffe.ru/names/' . $letter, 1);
        $this->addUrl('http://www.happy-giraffe.ru/names/');
        $names = Name::model()->findAll();
        foreach ($names as $name)
            $this->addUrl('http://www.happy-giraffe.ru/names/' . $name->slug . '/');


        $this->addUrl('http://www.happy-giraffe.ru/babySex/');
        $this->addUrl('http://www.happy-giraffe.ru/sewing/');

        echo "horoscope\n";
        $this->addUrl('http://www.happy-giraffe.ru/horoscope/');
        $this->addUrl('http://www.happy-giraffe.ru/horoscope/compatibility/');
        foreach (array('a', 't', 'g', 'c', 'l', 'v', 's', 'p') as $letter)
            $this->addUrl('http://www.happy-giraffe.ru/horoscope/' . $letter, 1);
        foreach (array('a', 't', 'g', 'c', 'l', 'v', 's', 'p') as $letter)
            $this->addUrl('http://www.happy-giraffe.ru/horoscope/compatibility/' . $letter, 1);

        $this->addUrl('http://www.happy-giraffe.ru/test/');
        $this->addUrl('http://www.happy-giraffe.ru/pregnancyWeight/');
        $this->addUrl('http://www.happy-giraffe.ru/placentaThickness/');
        $this->addUrl('http://www.happy-giraffe.ru/menstrualCycle/');
        $this->addUrl('http://www.happy-giraffe.ru/babyBloodGroup/');
        $this->addUrl('http://www.happy-giraffe.ru/contractionsTime/');

        echo "childrenDiseases\n";
        $this->addUrl('http://www.happy-giraffe.ru/childrenDiseases/');
        foreach (range('a', 'z') as $letter)
            $this->addUrl('http://www.happy-giraffe.ru/childrenDiseases/' . $letter, 1);
        $models = RecipeBookDisease::model()->findAll();
        foreach ($models as $model)
            $this->addUrl('http://www.happy-giraffe.ru/childrenDiseases/' . $model->slug . '/');
        $models = RecipeBookDiseaseCategory::model()->findAll();
        foreach ($models as $model)
            $this->addUrl('http://www.happy-giraffe.ru/childrenDiseases/' . $model->slug . '/');

        // Cook recipes
        echo "Cook recipes\n";
        $this->collectCookRecipes();

        $this->addUrl('http://www.happy-giraffe.ru/cook/converter/');
        $this->addUrl('http://www.happy-giraffe.ru/cook/calorisator/');

        // Cook choose
        echo "Cook choose\n";
        foreach (range('a', 'z') as $letter)
            $this->addUrl('http://www.happy-giraffe.ru/cook/choose/' . $letter, 1);
        $models = CookChoose::model()->findAll();
        foreach ($models as $model)
            $this->addUrl('http://www.happy-giraffe.ru/cook/choose/' . $model->slug . '/');
        $models = CookChooseCategory::model()->findAll();
        foreach ($models as $model)
            $this->addUrl('http://www.happy-giraffe.ru/cook/choose/' . $model->slug . '/');

        // Cook spices
        echo "Cook spices\n";
        foreach (range('a', 'z') as $letter)
            $this->addUrl('http://www.happy-giraffe.ru/cook/spice/' . $letter, 1);
        $models = CookSpice::model()->findAll();
        foreach ($models as $model)
            $this->addUrl('http://www.happy-giraffe.ru/cook/spice/' . $model->slug . '/');
        $models = CookSpiceCategory::model()->findAll();
        foreach ($models as $model)
            $this->addUrl('http://www.happy-giraffe.ru/cook/spice/' . $model->slug . '/');

        echo "Cook decor\n";
        $this->addUrl('http://www.happy-giraffe.ru/cook/decor/');
        for ($i = 0; $i <= 7; $i++) {
            $this->addUrl('http://www.happy-giraffe.ru/cook/decor/' . $i . '/', 1);
        }
    }

    public function collectCookRecipes()
    {
        $types = array(0 => 'recipe', 1 => 'multivarka');
        foreach ($types as $key => $type) {
            $ids = Yii::app()->db
                ->createCommand()
                ->select('id')
                ->from('cook__recipes')
                ->where('section = ' . $key)
                ->queryColumn();

            foreach ($ids as $id)
                $this->addUrl('http://www.happy-giraffe.ru/cook/' . $type . '/' . $id . '/');

            $ids = $this->getIdsForQueries($ids);
            foreach ($ids as $id)
                $this->addUrl('http://www.happy-giraffe.ru/cook/' . $type . '/' . $id, 1);
        }
    }

    public function getIdsForQueries($ids, $start = '')
    {
        $limit = 10;
        $result = array();
        for ($i = 0; $i <= 9; $i++) {
            $count = 0;
            foreach ($ids as $id) {
                if (strpos($id, $start . $i) === 0)
                    $count++;
            }

            if ($count > 1 && $count < $limit) {
                $result [] = $start . $i;
                //remove from array
                foreach ($ids as $key => $id) {
                    if (strpos($id, $start . $i) === 0)
                        unset($ids[$key]);
                }

            } elseif ($count >= $limit) {
                $ids2 = array();
                foreach ($ids as $key => $id) {
                    if (strpos($id, $start . $i) === 0) {
                        $ids2[] = $id;
                        unset($ids[$key]);
                    }
                }

                $q = $this->getIdsForQueries($ids2, $start . $i);
                $result = array_merge($q, $result);
            }
        }

        return $result;
    }

    public function addUrl($url, $type = 0)
    {
        $model = IndexingUrl::model()->findByAttributes(array('url' => $url));
        if ($model === null) {
            $model = new IndexingUrl;
            $model->url = $url;
            $model->type = $type;
            $model->active = 0;
            $model->save();
        } else {
            if ($type != 0 && $model->type != $type) {
                $model->type = $type;
                $model->save();
            }
        }
    }

    public function removeUrls()
    {
        $models = IndexingUrl::model()->findAll('type=1');
        foreach ($models as $model) {
            if ($model->countUrls == 0)
                $model->delete();
        }
    }
}
