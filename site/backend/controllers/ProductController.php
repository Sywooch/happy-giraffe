<?php

class ProductController extends BController
{
    public $layout = 'shop';

    public function beforeAction($action)
    {
        if (!Yii::app()->user->checkAccess('shop'))
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
        return true;
    }

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
            ->from('shop__product_eav')
            ->where('eav_product_id=:eav_product_id AND eav_attribute_id=:eav_attribute_id', array(
            ':eav_product_id' => $product_id,
            ':eav_attribute_id' => $attr_id,
        ))
            ->limit(1)
            ->queryScalar();

        if ($eav_id) {
            Y::command()
                ->update('shop__product_eav', array(
                'eav_attribute_value' => $value,
            ), 'eav_id=:eav_id', array(
                ':eav_id' => $eav_id,
            ));
        }
        else
        {
            Y::command()
                ->insert('shop__product_eav', array(
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
            ->from('shop__product_eav_text')
            ->where('eav_product_id=:eav_product_id AND eav_attribute_id=:eav_attribute_id', array(
            ':eav_product_id' => $product_id,
            ':eav_attribute_id' => $attr_id,
        ))
            ->limit(1)
            ->queryScalar();

        if ($eav_id) {
           
            $pet = ProductEavText::model()->findByPk($eav_id);
            $pet->eav_attribute_value = $value;
            $pet->save();
        }
        else
        {
            $pet = new ProductEavText;
            $pet->eav_product_id = $product_id;
            $pet->eav_attribute_id = $attr_id;
            $pet->eav_attribute_value = $value;
            $pet->save();
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
            echo CJSON::encode(array('success' => true, 'image' => $image->getUrl('display'), 'name'=>$brand->brand_title));
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

    public function actionUploadPhoto()
    {
        if (!isset($_POST['Product']))
            Yii::app()->end();
        $product = $this->loadModel($_POST['Product']['product_id']);

        $photo = new AlbumPhoto();
        $photo->file = CUploadedFile::getInstanceByName('Product[product_image]');
        $photo->author_id = Yii::app()->user->id;
        $photo->create();

        $attach = new AttachPhoto;
        $attach->entity = 'Product';
        $attach->entity_id = $product->primaryKey;
        $attach->photo_id = $photo->id;
        $attach->save();

        $image = new ProductImage;
        $image->product_id = $product->primaryKey;
        $image->type = $_POST['type'];
        $image->photo_id = $photo->id;
        $image->save();
    }

    public function actionPutIn($id, $put = false)
    {
        $product = $this->loadModel($id);

        $attributes = array();
        if($put == false)
        {
            $attributeSetMap = $product->category->GetAttributesMap();
            foreach ($attributeSetMap as $attribute)
            {

                if ($attribute->map_attribute->attribute_in_price == 1) {
                    $attribute_values = $product->GetCardAttributeValues($attribute->map_attribute->attribute_id);
                    if(count($attribute_values) == 0)
                        continue;
                    $attributes[$attribute->map_attribute->attribute_id] = array(
                        'attribute' => $attribute,
                        'items' => array(),
                    );
                    foreach($attribute_values as $attribute_value)
                        $attributes[$attribute->map_attribute->attribute_id]['items'][$attribute_value['eav_id']] = $attribute_value['eav_attribute_value'];
                }
            }
        }

        if(count($attributes) == 0)
            $put = true;

        if(isset($_POST['Attribute']))
            $product->cart_attributes = $_POST['Attribute'];

        if($put !== false && isset($_POST['count']))
        {
            $item = new ProductItem;
            $item->product_id = $product->primaryKey;
            $item->count = $_POST['count'];
            $item->properties = $product->cart_attributes;
            $item->save();
            echo $product->itemsCount;
            Yii::app()->end();
        }

        if (Y::isAjaxRequest())
        {
                $this->renderPartial('putInAttributes', array(
                    'model' => $product,
                    'attributes' => $attributes
                ));
        }
        else
        {
            $this->redirect(Y::request()->urlReferrer);
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

    public function actionAddVideo()
    {
        if (isset($_POST['video_url']))
        {
            $video = new Video($_POST['video_url']);
            $productVideo = new ProductVideo;
            $productVideo->code = $video->code;
            $productVideo->title = $video->title;
            $productVideo->description = $video->description;
            $productVideo->preview = $video->preview;
            $productVideo->url = $_POST['video_url'];
            $productVideo->product_id = $_POST['product_id'];
            if ($productVideo->save())
            {
                $response = array(
                    'status' => true,
                    'video' => $this->renderPartial('_video', array(
                        'model' => $productVideo,
                    ), true),
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

    public function actionSetAge(){
        $id = Yii::app()->request->getPost('id');
        $age_from = Yii::app()->request->getPost('age_from');
        $age_to = Yii::app()->request->getPost('age_to');
        $age_interval = Yii::app()->request->getPost('age_interval');

        if ($age_interval == 2){
            $age_from *= 12;
            $age_to *= 12;
        }

        $product = $this->loadModel($id);

        $product->age_from = $age_from;
        $product->age_to = $age_to;

        if ($product->save()){
            $response = array(
                'status' => true,
                'text'=>$product->GetAgeRangeText()
            );
        }else{
            $response = array(
                'status' => false,
            );
        }

        echo CJSON::encode($response);
    }
}
