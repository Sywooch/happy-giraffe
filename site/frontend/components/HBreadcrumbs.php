<?php
/**
 * insert Description
 *
 * @author Alex Kireev <alexk984@gmail.com>
 */

class HBreadcrumbs extends CWidget
{
    public $tagName = 'ul';
    public $htmlOptions = array('class' => 'crumbs-small_ul');
    public $encodeLabel=true;
    public $homeLink;
    public $links=array();
    public $activeLinkTemplate='<li class="crumbs-small_li"><a href="{url}" class="crumbs-small_a">{label}</a></li>';
    public $inactiveLinkTemplate='<li class="crumbs-small_li"><span class="crumbs-small_last">{label}</span></li>';
    public $separator=' &gt; ';

    public function run()
    {
        if(empty($this->links))
            return;

        echo CHtml::openTag($this->tagName,$this->htmlOptions)."\n";
        echo "<li class=\"crumbs-small_li\">Я здесь:</li>\n";
        $links=array();
        if($this->homeLink===null)
            $links[]=CHtml::link('Главная',Yii::app()->homeUrl);
        elseif($this->homeLink!==false)
            $links[]=$this->homeLink;
        foreach($this->links as $label=>$url)
        {
            if(is_string($label) || is_array($url))
                $links[]=strtr($this->activeLinkTemplate,array(
                    '{url}'=>CHtml::normalizeUrl($url),
                    '{label}'=>$this->encodeLabel ? CHtml::encode($label) : $label,
                ));
            else
                $links[]=str_replace('{label}',$this->encodeLabel ? CHtml::encode($url) : $url,$this->inactiveLinkTemplate);
        }
        echo implode($this->separator,$links);
        echo CHtml::closeTag($this->tagName);
    }
}