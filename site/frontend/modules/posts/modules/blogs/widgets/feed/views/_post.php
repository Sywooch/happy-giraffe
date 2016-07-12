<?php 

/** 
 * @var \site\frontend\modules\posts\models\Content $data  
 */

$templateData = CJSON::decode($data->getAttribute('template'));

$type = $templateData['data']['type'];

switch ($type)
{   
    case 'photoPost':
    case 'photopost':
    case 'videoPost':
        \Yii::app()->controller->renderPartial(
            'site.frontend.modules.posts.modules.blogs.widgets.feed.views._type_videoPost',
            compact('data', 'maxTextLength')
            );
        break;
        
    case 'post':
        \Yii::app()->controller->renderPartial(
            'site.frontend.modules.posts.modules.blogs.widgets.feed.views._type_post',
            compact('data', 'maxTextLength')
        );
        break;
        
    case 'status':
        \Yii::app()->controller->renderPartial(
            'site.frontend.modules.posts.modules.blogs.widgets.feed.views._type_status',
            compact('data')
        );
        break;
    
    default:
        break;
}

?>