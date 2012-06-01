<?php
class ConverterController extends HController
{

    //public $layout = '//layouts/new';

    public function actionIndex()
    {
        $this->pageTitle = 'Конвертер';

        $this->render('index', array(
            'model' => new ConverterForm()
        ));
    }

    public function actionUnits()
    {
        $ingredient = CookIngredients::model()->findByPk($_POST['id']);
        header('Content-type: application/json');
        echo CJSON::encode($ingredient->getUnitsIds());
    }

    public function actionIndexOld()
    {
        $this->pageTitle = 'Конвертер';

        $basePath = Yii::getPathOfAlias('application.modules.cook.views.converter.assets');
        $baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
        Yii::app()->clientScript->registerScriptFile($baseUrl . '/script_old.js', CClientScript::POS_HEAD);

        $this->render('index_old', array(
            'model' => new ConverterForm(),
            'units' => Yii::app()->db->createCommand()->select('*')->from('cook__units')->where('type IN ("weight", "volume", "qty")', array())->queryAll()
        ));
    }

    public function actionAc($term)
    {
        $ingredients = Yii::app()->db->createCommand()->select('id, unit_id, title, title AS value, title AS label')->from('cook__ingredients')
            ->where('title LIKE :term AND (density > 0 OR weight > 0)', array(':term' => '%' . $term . '%'))
            ->limit(20)->queryAll();

        header('Content-type: application/json');
        echo CJSON::encode($ingredients);
    }

    public function actionCalculate()
    {
        $form = new ConverterForm();

        if (isset($_POST['ajax']) and $_POST['ajax'] == 'converter-form') {
            $form->attributes = $_POST['ConverterForm'];
            echo CActiveForm::validate($form);
            Yii::app()->end();
        } elseif (isset($_POST['ConverterForm'])) {
            $converter = new CookConverter();
            $result = $converter->convert($_POST['ConverterForm']);
            header('Content-type: application/json');
            $result['qty'] = (round($result['qty']) == $result['qty']) ? $result['qty'] : round($result['qty'], 2);
            echo CJSON::encode($result['qty']);
        }
    }
}