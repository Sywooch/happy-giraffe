<?php

class DefaultController extends LiteController
{
    protected function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            $cs = Yii::app()->clientScript;
            $package = Yii::app()->user->isGuest ? 'lite_recipes' : 'lite_recipes_user';
            $cs->registerPackage($package);
            $cs->useAMD = true;
            return true;
        }
    }

    public function actionIndex()
    {
        $dp = RecipeBookRecipe::getDp(null, null);
        $categories = RecipeBookDiseaseCategory::model()->alphabetical()->findAll();

        $title = 'Народные рецепты';
        $links = array();
        foreach ($categories as $c) {
            $links[$c->title] = $c->getUrl();
        }

        $this->pageTitle = 'Народные рецепты';
        $this->meta_description = 'Народные рецепты | ' . implode(', ', array_map(function($category) {
            return $category->title;
            }, $categories));
        $this->breadcrumbs = array(
            'Народные рецепты',
        );
        $this->render('index', compact('links', 'dp', 'title'));
    }

    /**
     * @sitemap dataSource=sitemapDisease
     */
    public function actionDisease($slug)
    {
        $disease = RecipeBookDisease::model()->findByAttributes(array('slug' => $slug));
        if ($disease === null) {
            throw new CHttpException(404);
        }
        $dp = RecipeBookRecipe::getDp($disease->id, null);

        $title = 'Народные рецепты. ' . $disease->title;
        $links = array();

        $this->pageTitle = $disease->title;
        $this->meta_description = $disease->title . ' | ' . $disease->text;
        $this->breadcrumbs = array(
            'Народные рецепты' => array('/services/recipeBook/default/index'),
            $disease->category->title => $disease->category->getUrl(),
            $disease->title,
        );
        $this->render('index', compact('links', 'dp', 'title'));
    }

    /**
     * @sitemap dataSource=sitemapCategory
     */
    public function actionCategory($slug)
    {
        $category = RecipeBookDiseaseCategory::model()->with('diseases')->findByAttributes(array('slug' => $slug));
        if ($category === null) {
            throw new CHttpException(404);
        }
        $dp = RecipeBookRecipe::getDp(null, $category->id);

        $title = 'Народные рецепты. ' . $category->title;
        $links = array();
        foreach ($category->diseases as $d) {
            $links[$d->title] = $d->getUrl();
        }

        $this->pageTitle = $category->title;
        $this->meta_description = $category->title . ' | ' . implode(', ', array_map(function($disease) {
                return $disease->title;
            }, $category->diseases));
        $this->breadcrumbs = array(
            'Народные рецепты' => array('/services/recipeBook/default/index'),
            $category->title,
        );
        $this->render('index', compact('links', 'dp', 'title'));
    }

    /**
     * @sitemap dataSource=sitemapView
     */
    public function actionView($id)
    {
        $recipe = RecipeBookRecipe::model()->single()->findByPk($id);
        if ($recipe === null) {
            throw new CHttpException(404);
        }

        $this->pageTitle = $recipe->title . ' | ' . $recipe->disease->title;
        $this->meta_description = $recipe->title . ' | ' . $recipe->disease->title . ' | ' . $recipe->text;
        $this->breadcrumbs = array(
            'Народные рецепты' => array('/services/recipeBook/default/index'),
            $recipe->disease->category->title => $recipe->disease->category->getUrl(),
            $recipe->disease->title => $recipe->disease->getUrl(),
            $recipe->title,
        );
        $this->render('view', compact('recipe'));
    }

    public function sitemapView()
    {
        $models = Yii::app()->db->createCommand()
            ->select('id, created, updated')
            ->from('recipe_book__recipes')
            ->queryAll();

        $data = array();
        foreach ($models as $model)
        {
            $data[] = array(
                'params' => array(
                    'id' => $model['id'],
                ),
                'changefreq' => 'daily',
                'lastmod' => ($model['updated'] === null) ? $model['created'] : $model['updated'],
            );
        }

        return $data;
    }

    public function sitemapCategory()
    {
        $models = Yii::app()->db->createCommand()
            ->select('slug')
            ->from('recipe_book__disease_categories')
            ->queryAll();

        return array_map(function($model) {
            return array(
                'params' => array(
                    'slug' => $model['slug'],
                ),
            );
        }, $models);
    }

    public function sitemapDisease()
    {
        $models = Yii::app()->db->createCommand()
            ->select('slug')
            ->from('recipe_book__diseases')
            ->queryAll();

        return array_map(function($model) {
            return array(
                'params' => array(
                    'slug' => $model['slug'],
                ),
            );
        }, $models);
    }
}