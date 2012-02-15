<?php

class AddressForm extends CFormModel
{
    public $country_id;
    public $region_id;
    public $city_id;
    public $city_name;
    public $district_id;
    public $street_id;
    public $street_name;
    public $house;
    public $room;

    public function rules()
    {
        return array(
            array('country_id, region_id, city_id, district_id, street_id', 'numerical', 'integerOnly' => true),
            array('city_name, street_name, house, room', 'safe')
        );
    }

    /**
     * @param User $user
     */
    public function saveAddress($user)
    {
        if (!empty($this->country_id)) {
            $user->country_id = $this->country_id;
            if (!empty($this->city_id) && !empty($this->region_id)) {
                $user->settlement_id = $this->city_id;
            } elseif (!empty($this->city_name) && !empty($this->region_id)) {
                //add new city
                $city = new GeoRusSettlement();
                $city->name = CHtml::encode($this->city_name);
                $city->region_id = $this->region_id;
                if (!empty($this->district_id))
                    $city->district_id = $this->district_id;
                $city->by_user = 1;
                if (!$city->save()) {
                    throw new CHttpException(404, 'Ошибка при добавлении населенного пункта.');
                }
                $user->settlement_id = $city->id;
            } else{
                $user->settlement_id = null;
                $user->street_id = null;
                $user->house = null;
                $user->room = null;
                return;
            }

            if (!empty($this->street_id) && !empty($this->city_id)) {
                $user->street_id = $this->street_id;
            } elseif (!empty($this->street_name) && !empty($this->city_id)) {
                //add new street
                $street = new GeoRusStreet();
                $street->name = $this->street_name;
                $street->settlement_id = $this->city_id;
                $street->by_user = 1;
                if (!$street->save()) {
                    throw new CHttpException(404, 'Ошибка при добавлении улицы.');
                }
                $user->street_id = $street->id;
            } else{
                $user->street_id = null;
                $user->house = null;
                $user->room = null;
                return;
            }

            $user->house = $this->house;
            $user->room = $this->room;
        }else{
            $user->country_id = null;
            $user->settlement_id = null;
            $user->street_id = null;
            $user->house = null;
            $user->room = null;
        }
    }
}