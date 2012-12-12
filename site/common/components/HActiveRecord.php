<?php
/**
 * Author: choo
 * Date: 25.04.2012
 */
class HActiveRecord extends CActiveRecord
{
    public function getPhotoCollection()
    {
        return $this->photos;
    }

    public function getErrorsText()
    {
        $errorText = '';
        foreach ($this->getErrors() as $error) {
            foreach($error as $errorPart)
                $errorText.= $errorPart.' ';
        }

        return $errorText;
    }

    public function getShare($service)
    {
        switch ($service) {
            case 'vkontakte':
                $url = 'http://vk.com/share.php?title={title}&description={description}&url={url}&image={image}';
                break;
            case 'facebook':
                $url = 'http://www.facebook.com/sharer.php?s=100&p[url]={url}&p[title]={title}&p[summary]={description}&p[images][0]={image}';
                break;
            case 'odnoklassniki':
                $url = 'http://www.odnoklassniki.ru/dk?st.cmd=addShare&st.s=1&st.comments={title} {description}&st._surl={url}';
                break;
            case 'twitter':
                $url = 'https://twitter.com/intent/tweet?text={title} {description}&url={url}';
                break;
        }

        return strtr($url, array(
            '{title}' => urlencode($this->shareTitle),
            '{description}' => urlencode($this->shareDescription),
            '{image}' => urlencode($this->shareImage),
            '{url}' => urlencode($this->shareUrl),
        ));
    }

    public function getShareTitle()
    {
        return ($this->hasAttribute('title') ? $this->title : '');
    }

    public function getShareDescription()
    {
        return ($this->hasAttribute('description') ? $this->description : '');
    }

    public function getShareImage()
    {
        return (isset($this->getMetaData()->relations['photo']) && $this->photo instanceof AlbumPhoto) ? $this->photo->getPreviewPath(180, 180) : '';
    }

    public function getShareUrl()
    {
        return $this->getUrl(false, true);
    }

    public function getRelatedModel($condition = '', $params = array())
    {
        return ($this->hasAttribute('entity') && $this->hasAttribute('entity_id')) ? CActiveRecord::model($this->entity)->findByPk($this->entity_id, $condition, $params) : null;
    }
}
