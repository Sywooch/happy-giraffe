<?php
/**
 * @var $this DefaultController
 * @var $data BlogContent
 */
switch($data->type_id){
    case CommunityContentType::TYPE_POST:
        $this->renderPartial('preview/type_1',compact('data', 'full'));
        break;
    case CommunityContentType::TYPE_VIDEO:
        $this->renderPartial('preview/type_2',compact('data', 'full'));
        break;
    case CommunityContentType::TYPE_STATUS:
        $this->renderPartial('preview/type_5',compact('data', 'full'));
        break;
}