<?php
class ConverterController extends HController
{

    public $layout = '//layouts/new';

    public function actionIndex()
    {
        $this->pageTitle = 'Конвертер';

        $basePath = Yii::getPathOfAlias('application.modules.cook.views.converter.assets');
        $baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
        Yii::app()->clientScript->registerScriptFile($baseUrl . '/script.js', CClientScript::POS_HEAD);


        $this->render('index', array(
            'model' => new ConverterForm(),
            'units' => Yii::app()->db->createCommand()->select('*')->from('cook__units')->where('parent_id IS NULL AND type IN ("weight", "volume", "qty")', array())->queryAll()
        ));
    }

    public function actionAc($term)
    {
        $ingredients = Yii::app()->db->createCommand()->select('id, unit_id, title, weight, density')->from('cook__ingredients')
            ->where('title LIKE :term AND (density > 0 OR weight > 0)', array(':term' => '%' . $term . '%'))
            ->limit(20)->queryAll();

        foreach ($ingredients as &$ing) {
            $ing['value'] = $ing['label'] = $ing['title'];
            $ing['weight'] = ($ing['weight'] > 0) ? 1 : 0;
            $ing['density'] = ($ing['density'] > 0) ? 1 : 0;
        }

        if (Yii::app()->request->isAjaxRequest) {
            header('Content-type: application/json');
            echo CJSON::encode($ingredients);
        } else {
            echo '<pre>' . print_r($ingredients, true) . '</pre>';
        }
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
            $this->renderPartial('_result', array('result' => $result));
        }
    }
}