<?php

class ServicesModule extends CWebModule
{
    public function init()
    {
        // this method is called when the module is being created
        // you may place code here to customize the module or the application

        // import the module-level models and components
        $this->setImport(array(
            'services.models.*',
            'services.components.*',
        ));
        $this->setModules(array(
            'repair',
            'babyBloodGroup',
            'babySex',
            'contractionsTime',
            'horoscope',
            'hospitalBag',
            'maternityLeave',
            'menstrualCycle',
            'pregnancyWeight',
            'placentaThickness',
            'vaccineCalendar'
        ));
    }

    public function beforeControllerAction($controller, $action)
    {
        if (parent::beforeControllerAction($controller, $action)) {
            // this method is called before any module controller action is performed
            // you may place customized code here
            return true;
        }
        else
            return false;
    }
}
