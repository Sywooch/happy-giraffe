<?php
/**
 * Author: alexk984
 * Date: 18.05.12
 */
class ExistArticlesController extends SController
{
    public $pageTitle = 'ГОТОВОЕ';
    public $layout = '//layouts/empty';

    public function beforeAction($action)
    {
        if (!Yii::app()->user->checkAccess('input-old-articles', 'main-editor', 'cook-manager'))
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return true;
    }

    public function actionIndex()
    {
        $models = Page::model()->with(array('keywordGroup', 'keywordGroup.keywords'))->findAll(array('order' => 't.id desc', 'limit'=>500));
        $this->render('index', compact('models'));
    }

    public function actionSaveArticleKeys()
    {
        $url = Yii::app()->request->getPost('url');
        preg_match("/\/([\d]+)\/$/", $url, $match);
        $id = $match[1];

        $keywords = Yii::app()->request->getPost('keywords');
        $keywords = explode("\n", $keywords);

        $article = CommunityContent::model()->findByPk($id);
        if ($article === null) {
            $response = array(
                'status' => false,
                'error' => 'Не найдена статья, обратитесь к разработчикам.',
            );
        } else {
            $exist = Page::model()->findByAttributes(array(
                'entity' => 'CommunityContent',
                'entity_id' => $article->id,
            ));
            if ($exist !== null) {
                $response = array(
                    'status' => false,
                    'error' => 'Вы уже вводили эту статью.',
                );
            } else {
                $page = new Page();
                $page->entity = 'CommunityContent';
                $page->entity_id = $article->id;
                $page->url = $url;

                $group = new KeywordGroup();

                $keyword_models = array();
                foreach ($keywords as $keyword) {
                    $keyword = trim($keyword);
                    $keyword = str_replace(',',' ',$keyword);
                    $keyword = str_replace('.',' ',$keyword);
                    $keyword = str_replace('.',' ',$keyword);
                    $keyword = str_replace('  ',' ',$keyword);
                    $keyword = str_replace('  ',' ',$keyword);

                    $keyword = mb_strtolower($keyword, 'utf8');
                    if (!empty($keyword)) {
                        $model = Keyword::GetKeyword($keyword);
                        if (!empty($model->group)) {
                            $response = array(
                                'status' => false,
                                'error' => "Кейворд <b>{$keyword}</b> уже используется.",
                            );
                            echo CJSON::encode($response);
                            Yii::app()->end();
                        }
                        $keyword_models[] = $model;
                    }
                }

                if (empty($keyword_models)) {
                    $response = array(
                        'status' => false,
                        'error' => 'Введите кейворды.',
                    );
                } else {

                    $group->keywords = $keyword_models;
                    $group->withRelated->save(true,array('keywords'));

                    $page->keyword_group_id = $group->id;
                    if ($page->save()) {
                        $response = array(
                            'status' => true,
                            'html' => $this->renderPartial('_article', array('model' => $page), true),
                            'keysCount' => count($keyword_models)
                        );
                    } else
                        $response = array(
                            'status' => false,
                            'error' => 'Не удалось сохранить статью, обретитесь к разработчикам.',
                        );
                }
            }
        }

        echo CJSON::encode($response);
    }

    public function actionValidate()
    {
        $model = new Page('check');
        $model->attributes = $_POST['Page'];
        $this->performAjaxValidation($model, 'article-form');
    }

    public function performAjaxValidation($model, $formName)
    {
        if (isset($_POST['ajax']) && $_POST['ajax'] == $formName) {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
    }

    public function actionRemove(){
        $id = Yii::app()->request->getPost('id');
        if (Yii::app()->user->checkAccess('admin')){
            $model = $this->loadArticle($id);
            if ($model->delete()){
                echo CJSON::encode(array('status' => true));
                Yii::app()->end();
            }
        }

        echo CJSON::encode(array('status' => false));
    }

    /**
     * @param int $id model id
     * @return Page
     * @throws CHttpException
     */
    public function loadArticle($id)
    {
        $model = Page::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return $model;
    }
}
