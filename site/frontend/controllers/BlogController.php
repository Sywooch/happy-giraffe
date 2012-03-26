<?php
/**
 * Author: choo
 * Date: 26.03.2012
 */
class BlogController extends Controller
{
    public function actionAdd($content_type_slug = 'post')
    {
        $content_type = CommunityContentType::model()->findByAttributes(array('slug' => $content_type_slug));
        $model = new CommunityContent;
        $model->type_id = $content_type->id;
        $slave_model_name = 'Community' . ucfirst($content_type->slug);
        $slave_model = new $slave_model_name;
        $this->render('form', array(
            'model' => $model,
            'slave_model' => $slave_model,
        ));
    }
}
