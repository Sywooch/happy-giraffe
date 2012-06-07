<?php

class YarnCalcForm extends CFormModel
{
    public $project;
    public $size;
    public $gauge;

    /**
     * @var YarnProjects
     */
    public $model;

    public function rules()
    {
        return array(
            array('project, size, gauge', 'required', 'message' => 'Выберите из списка {attribute}'),
            array('project, size, gauge', 'numerical', 'integerOnly' => true, 'message' => 'Вводите только цифры'),
        );
    }

    public function AttributeLabels()
    {
        return array(
            'project' => 'то изделие, которое вы хотите связать',
            'size' => 'нужный размер изделия',
            'gauge' => 'сколько петель умещается в 10 сантиметрах изделия',
        );
    }

    /**
     * @param $id
     * @return YarnProjects
     * @throws CHttpException
     */
    public function LoadYarnProject($id)
    {
        $this->model = YarnProjects::model()->findByPk($id);
        if ($this->model === null)
            throw new CHttpException(404, 'Запрашиваемая вами страница не найдена.');
    }

    public function GetResult()
    {
        $result = Yii::app()->db->createCommand()
            ->select('value')
            ->from('sewing__yarn_data')
            ->where('project = :project AND size = :size AND gauge = :gauge', array(
            ':project' => $this->project,
            ':gauge' => $this->gauge,
            ':size' => $this->size))
            ->queryScalar();
        if ($result !== FALSE)
            return $result;
        else
            return null;
    }
}