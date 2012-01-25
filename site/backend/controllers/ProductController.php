<?php

class ProductController extends BController
{
    public $layout = 'main';

    public function actionIndex($category_id = null, $brand_id = null)
    {
        $dataProvider = Product::model()->getAll($category_id, $brand_id);
        $count = Product::model()->count();

        $this->render('index', array(
            'goods' => $dataProvider->data,
            'pages' => $dataProvider->pagination,
            'count' => $count,
            'category_id' => $category_id,
            'brand_id' => $brand_id,
        ));
    }

    public function actionCreate($category_id)
    {
        if (Yii::app()->request->isAjaxRequest) {
            $title = Yii::app()->request->getParam('title');
            $product = new Product(Product::SCENARIO_FILL_PRODUCT);
            $product->product_title = $title;
            $product->product_category_id = $category_id;

            if ($product->save()) {
                echo CJSON::encode(array('success' => true, 'id' => $product->product_id));
            } else
                echo CJSON::encode(array('success' => false, 'error' => $product->getErrors()));
            Yii::app()->end();
        }

        $category = $this->loadCategoryModel($category_id);
        $attributeMap = $category->GetAttributesMap();

        $this->render('form', array(
            'category' => $category,
            'attributeMap' => $attributeMap,
            'model' => new Product
        ));
    }

    public function actionUpdate($product_id)
    {
        $model = $this->loadModel($product_id);
        $attributeMap = $model->category->GetAttributesMap();

        $this->render('form', array(
            'category' => $model->category,
            'attributeMap' => $attributeMap,
            'model' => $model
        ));
    }

    public function actionSetAttributeValue()
    {
        $attr_id = Yii::app()->request->getPost('attr_id');
        $product_id = Yii::app()->request->getPost('product_id');
        $value = Yii::app()->request->getPost('value');

        $eav_id = Y::command()
            ->select('eav_id')
            ->from('shop_product_eav')
            ->where('eav_product_id=:eav_product_id AND eav_attribute_id=:eav_attribute_id', array(
            ':eav_product_id' => $product_id,
            ':eav_attribute_id' => $attr_id,
        ))
            ->limit(1)
            ->queryScalar();

        if ($eav_id) {
            Y::command()
                ->update('shop_product_eav', array(
                'eav_attribute_value' => $value,
            ), 'eav_id=:eav_id', array(
                ':eav_id' => $eav_id,
            ));
        }
        else
        {
            Y::command()
                ->insert('shop_product_eav', array(
                'eav_product_id' => $product_id,
                'eav_attribute_id' => $attr_id,
                'eav_attribute_value' => $value,
            ));
        }
    }

    public function actionSetAttributeTextValue()
    {
        $attr_id = Yii::app()->request->getPost('attr_id');
        $product_id = Yii::app()->request->getPost('product_id');
        $value = Yii::app()->request->getPost('value');

        $eav_id = Y::command()
            ->select('eav_id')
            ->from('shop_product_eav_text')
            ->where('eav_product_id=:eav_product_id AND eav_attribute_id=:eav_attribute_id', array(
            ':eav_product_id' => $product_id,
            ':eav_attribute_id' => $attr_id,
        ))
            ->limit(1)
            ->queryScalar();

        if ($eav_id) {
            Y::command()
                ->update('shop_product_eav_text', array(
                'eav_attribute_value' => $value,
            ), 'eav_id=:eav_id', array(
                ':eav_id' => $eav_id,
            ));
        }
        else
        {
            Y::command()
                ->insert('shop_product_eav_text', array(
                'eav_product_id' => $product_id,
                'eav_attribute_id' => $attr_id,
                'eav_attribute_value' => $value,
            ));
        }
    }

    public function actionSetBrand()
    {
        $product_id = Yii::app()->request->getPost('product_id');
        $brand_id = Yii::app()->request->getPost('brand_id');

        $model = $this->loadModel($product_id);
        $brand = $this->loadProductBrand($brand_id);
        $model->product_brand_id = $brand_id;
        if ($model->update(array('product_brand_id'))) {
            $image = $brand->GetImageUrl();
            echo CJSON::encode(array('success' => true, 'image' => $image->getUrl(), 'name'=>$brand->brand_title));
        } else
            echo CJSON::encode(array('success' => false, 'error' => $model->getErrors()));
    }

    /**
     * @param int $id model id
     * @return Product
     * @throws CHttpException
     */
    public function loadModel($id)
    {
        $model = Product::model()->with(array(
            'brand',
            'category'
        ))->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return $model;
    }

    /**
     * @param int $id model id
     * @return Category
     * @throws CHttpException
     */
    public function loadCategoryModel($id)
    {
        $model = Category::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return $model;
    }

    /**
     * @param int $id model id
     * @return ProductBrand
     * @throws CHttpException
     */
    public function loadProductBrand($id)
    {
        $model = ProductBrand::model()->findByPk($id);
        if ($model === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return $model;
    }

    public function actionUploadBigPhoto()
    {
        if (isset($_POST['Product'])) {
            $product = $this->loadModel($_POST['Product']['product_id']);
            $product->attributes = $_POST['Product'];
            if ($product->save(true, array('product_image'))) {
                $response = array(
                    'status' => true,
                    'url' => $product->product_image->getUrl('product'),
                    'title' => $product->product_title,
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

    public function actionUploadSmallPhoto()
    {
        if (isset($_POST['ProductImage'])) {
            $product_image = new ProductImage;
            $product_image->attributes = $_POST['ProductImage'];
            $product_image->image_product_id = $_POST['Product']['product_id'];
            if ($product_image->save()) {
                $response = array(
                    'status' => true,
                    'url' => $product_image->image_file->getUrl('product_thumb'),
                    'modelPk' => $product_image->primaryKey,
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

    public function actionAddAttrListElem()
    {
        if (isset($_POST['value']) && isset($_POST['product_id']) && isset($_POST['attribute_id'])) {
            $text = $_POST['value'];
            $id = $_POST['product_id'];
            $attr_id = $_POST['attribute_id'];

            $attr_val = new ProductEavText;
            $attr_val->eav_attribute_id = $attr_id;
            $attr_val->eav_attribute_value = $text;
            $attr_val->eav_product_id = $id;

            if ($attr_val->save())
            {
                $response = array(
                    'status' => true,
                    'html' => $this->renderPartial('_attribute_value_view',array('attr_val'=>$attr_val), true),
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
