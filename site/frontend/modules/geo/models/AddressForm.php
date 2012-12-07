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
     * @throws CHttpException
     * @return void
     */
    public function saveAddress($user)
    {
        $user->address->country_id = (!empty($this->country_id)) ? $this->country_id : null;
        $user->address->region_id = (!empty($this->region_id)) ? $this->region_id : null;
        if (empty($this->city_id) && !empty($this->city_name) && !empty($this->region_id)) {
            // check city
            $city = GeoCity::model()->findByAttributes(array('name' => trim($this->city_name)));
            if ($city)
                $user->address->city_id = $city->id;
            else {
                //add new city
                $city = new GeoCity();
                $city->name = CHtml::encode($this->city_name);
                $city->country_id = $this->country_id;
                $city->region_id = $this->region_id;

                if (!$city->save())
                    throw new CHttpException(404, 'Ошибка при добавлении населенного пункта.');
                $user->address->city_id = $city->id;
            }
        } else {
            if (!empty($this->city_id))
                $user->address->city_id = $this->city_id;
            else
                $user->address->city_id = null;
        }
        $user->address->save();
    }
}