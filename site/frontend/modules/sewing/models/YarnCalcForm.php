<?php

class YarnCalcForm extends CFormModel
{
    public $project = 1;
    public $size = 1;
    public $gauge = 1;

    /**
     * @var YarnProjects
     */
    public $model;

    public function rules()
    {
        return array(
            array('project, size, gauge', 'required'),
            array('project, size, gauge', 'numerical', 'integerOnly' => true),
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

    public function GetResult(){
        $result = Yii::app()->db->createCommand()
            ->select('value')
            ->from('yarn')
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