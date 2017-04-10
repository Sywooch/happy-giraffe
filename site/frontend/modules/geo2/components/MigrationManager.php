<?php
/**
 * @author Никита
 * @date 24/03/17
 */

namespace site\frontend\modules\geo2\components;


use site\frontend\modules\users\models\User;

class MigrationManager
{
    protected $dryRun;
    
    protected $counters = [
        'ambiguous' => 0,
        'success' => 0,
        'fail' => 0,
    ];

    public function run($dryRun)
    {
        $this->dryRun = $dryRun;
        $dp = new \CActiveDataProvider(\UserAddress::class, [
            'criteria' => [
                'with' => [
                    'country',
                    'city',
                ],
            ],
        ]);
        $iterator = new \CDataProviderIterator($dp, 1000);
        foreach ($iterator as $address) {
            $this->processSingle($address);
        }
        
        foreach ($this->counters as $k => $v) {
            echo $k . ': ' . $v . PHP_EOL;
        }
    }

    protected function processSingle(\UserAddress $address)
    {
        $cities = LocationRecognizer::getCities($address->country->iso_code, $address->city->name);

        if ($cities == 0) {
            $this->counters['fail']++;
        } elseif ($cities == 1) {
            $this->counters['success']++;
            if (! $this->dryRun) {
                $city = $cities[0];
                $location = User::model()->findByPk($address->user_id)->location;
                $location->cityId = $city->id;
                $location->save();
            }
        } else {
            $this->counters['ambiguous']++;
        }
    }
}