<?php

class Baby extends CActiveRecord
{
	public function getAge()
	{
		if ($this->birthday === null) return null;
		
		$date1 = new DateTime($this->birthday);
		$date2 = new DateTime(date('Y-m-d'));
		$interval = $date1->diff($date2);
		return $interval->y;
	}

    public function getBirthdayDates()
    {

    }

	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return '{{user_baby}}';
	}

	public function relations()
	{
		return array(
			'parent' => array(self::BELONGS_TO, 'User', 'id'),
		);
	}
	
	public function rules()
	{
		return array(
            array('name, sex, birthday, parent_id', 'required'),
			array('birthday', 'type', 'type' => 'date', 'message' => '{attribute}: is not a date!', 'dateFormat' => 'yyyy-MM-dd'),
            array('sex', 'numerical', 'integerOnly' => true, 'min' => 0, 'max' => 1),
			array('name', 'length', 'max'=>255),
		);
	}
    
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'parent_id' => 'Родитель',
			'age_group' => 'Возрастная группа',
			'name' => 'Имя',
			'birthday' => 'День рождения',
            'sex' => 'Пол',
		);
	}

    public function behaviors()
    {
        return array(
            'behavior_ufiles' => array(
                'class' => 'site.frontend.extensions.ufile.UFileBehavior',
                'fileAttributes' => array(
                    'photo' => array(
                        'fileName' => 'upload/partner/*/<date>-{id}-<name>.<ext>',
                        'fileItems' => array(
                            'ava' => array(
                                'fileHandler' => array('FileHandler', 'run'),
                                'accurate_resize' => array(
                                    'width' => 76,
                                    'height' => 79,
                                ),
                            ),
                            'mini' => array(
                                'fileHandler' => array('FileHandler', 'run'),
                                'accurate_resize' => array(
                                    'width' => 38,
                                    'height' => 37,
                                ),
                            ),
                            'original' => array(
                                'fileHandler' => array('FileHandler', 'run'),
                            ),
                        )
                    ),
                ),
            ),
        );
    }
}