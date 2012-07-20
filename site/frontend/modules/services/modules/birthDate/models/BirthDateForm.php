<?php

class BirthDateForm extends HFormModel
{
    public $day;
    public $month;
    public $year;

    public function rules()
    {
        return array(
            array('day, month, year', 'required', 'message' => 'Выберите из списка {attribute}'),
            array('day, month, year', 'numerical', 'message' => 'Введите число')
        );
    }

    public function attributeLabels()
    {
        return array(
            'day' => 'день начала последней менструации',
            'month' => 'месяц, в котором началась последняя менструация',
            'year' => 'год, в котором началась последняя менструация',
        );
    }

    public function calculate()
    {
        $result = array();
        $result['start'] = strtotime($this->year . '-' . $this->month . '-' . $this->day);
        $result['start_str'] = date('c', $result['start']);
        $result['finish'] = strtotime(date('c', $result['start']) . ' - 3 months + 7 days + 1 year');
        $result['conception'] = strtotime(date('c', $result['start']) . ' + 14 days');
        $result['conception_str'] = date('c', $result['conception']);

        if ((time() - $result['start']) > 0)
            $result['days'] = (time() - $result['start']) / (60 * 60 * 24);

        return $result;
    }
}