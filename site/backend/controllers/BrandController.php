<?php

class BrandController extends BController
{
    public function actionIndex($query = null)
    {
        $dataProvider = ProductBrand::model()->getAll($query);

        $count = array(
            'total' => ProductBrand::model()->count(),
            'on' => ProductBrand::model()->count('active = 1'),
            'off' => ProductBrand::model()->count('active = 0'),
        );

        $this->render('index', array(
            'brands' => $dataProvider->data,
            'pages' => $dataProvider->pagination,
            'count' => $count,
        ));
    }

    public function loadModel($id)
    {
        $model = ProductBrand::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return $model;
    }

    public function actionAdd()
    {
        if (isset($_POST['ProductBrand']))
        {
            $brand = new ProductBrand;
            $brand->attributes = $_POST['ProductBrand'];
            if ($brand->save())
            {
                $response = array(
                    'status' => true,
                    'attributes' => $brand->attributes,
                    'modelPk' => $brand->primaryKey,
                );
            }
            else
            {
                $response = array(
                    'status' => $brand->getErrors(),
                );
            }

            echo CJSON::encode($response);
        }
    }

    public function actionUploadImage()
    {
        if (isset($_POST['ProductBrand']))
        {
            $brand = $this->loadModel($_POST['ProductBrand']['brand_id']);
            $brand->attributes = $_POST['ProductBrand'];
            if ($brand->save(true, array('brand_image')))
            {
                $response = array(
                    'status' => true,
                    'url' => $brand->brand_image->getUrl('display'),
                    'title' => $brand->brand_title,
                );
            }
            else
            {
                $response = array(
                    'status' => false,
                );
            }
            echo CJSON::encode($response);
        }
    }
}