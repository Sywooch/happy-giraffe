<?php

public class RoutedAction extends \CAction {
    #region route
    /**
     * Routing a request to a method by request type.
     *
     * @param string $get - get method name
     * @param string $post - post method name
     * @param string $update - update method name
     * @param string $delete - delete method name
     */
    protected function route($get, $post, $update, $delete) {
        switch(\Yii::app()->request->requestType){
            case 'GET':
                $this->requestType = 'Param';
                $this->$get();
                break;
            case 'POST':
                $this->requestType = 'Post';
                $this->$post();
                break;
            case 'PUT':
                $this->requestType = 'Put';
                $this->$update();
                break;
            case 'DELETE':
                $this->data = 'delete';
                $this->requestType = 'Delete';
                $this->$delete();
                break;
            default:
                $this->requestType = 'Param';
                $this->$get();
        }
    }

    /*@todo: V1ApiController methods here*/
    #endregion
}