<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of NotificationArticle
 *
 * @author Кирилл
 */
class NotificationArticle extends CModel
{

    public $count;
    public $entity_id;
    public $entity;
    protected $_model = null;

    public function attributeNames()
    {
        return array();
    }

    public function getModel()
    {

        if (is_null($this->_model))
        {
            $this->_model = CActiveRecord::model($this->entity)->findByPk($this->entity_id);
        }

        return $this->_model;
    }

}

?>
