<?php
class MapWidget extends CWidget
{
    /**
     * @var User
     */
    public $user;
    public $width = 322;
    public $height = 199;

    public $country_id;
    public $location;

    public function init()
    {
        parent::init();

    }

    public function run()
    {
        $map_id = md5(microtime());
        $this->registerScripts();
        if ($this->user) {
            $this->country_id = $this->user->address->country_id;
            $this->location = $this->user->address->fullTextLocation();
        }

        if (empty($this->country_id))
            return ;
        if ($this->country_id == 174){
            //yandex map
            $this->render('yandex_map', array(
                'map_id'=>$map_id
            ));
        }else{
            //google map
            $this->render('google_map', array(
                'map_id'=>$map_id
            ));
        }
    }

    public function registerScripts()
    {
        $basePath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR;
        $baseUrl = Yii::app()->getAssetManager()->publish($basePath, false, 1, YII_DEBUG);
        $cs = Yii::app()->clientScript;
        $cs->registerScriptFile($baseUrl . '/map_script.js', CClientScript::POS_HEAD)
            ->registerScriptFile('/javascripts/jquery.flip.js')
            ->registerCoreScript('jquery.ui')
        ->registerScriptFile('http://maps.googleapis.com/maps/api/js?key=' . Yii::app()->params['google_map_key'].'&sensor=true')
        ->registerScriptFile('http://api-maps.yandex.ru/1.1/index.xml?key=' . Yii::app()->params['yandex_map_key']);
    }
}
