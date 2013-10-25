<?php
/**
 * Created by JetBrains PhpStorm.
 * User: mikita
 * Date: 5/31/13
 * Time: 10:43 AM
 * To change this template use File | Settings | File Templates.
 */

class IndexDen extends CApplicationComponent
{
    public $apiUrl;

    public function init()
    {
        Yii::import('site.common.vendor.*');
        require_once 'Indextank/Exception.php';
        require_once 'Indextank/Exception/IndexAlreadyExists.php';
        require_once 'Indextank/Exception/IndexDoesNotExist.php';
        require_once 'Indextank/Exception/InvalidDefinition.php';
        require_once 'Indextank/Exception/InvalidQuery.php';
        require_once 'Indextank/Exception/InvalidResponseFromServer.php';
        require_once 'Indextank/Exception/InvalidUrl.php';
        require_once 'Indextank/Exception/TooManyIndexes.php';
        require_once 'Indextank/Exception/Unauthorized.php';
        require_once 'Indextank/Exception/HttpException.php';
        require_once 'Indextank/Response.php';
        require_once 'Indextank/Api.php';
        require_once 'Indextank/Index.php';
        parent::init();
    }

    public function save($indexName, $docId, $fields, $variables = null, $categories = null)
    {
        $index = $this->getIndex($indexName);
        $index->add_document($docId, $fields, $variables, $categories);
    }

    public function delete($indexName, $docId)
    {
        $index = $this->getIndex($indexName);
        $index->delete_document($docId);
    }
    
    public function search($indexName, $query, $start = null, $len = null, $scoring_function = null, $snippet_fields = null, $fetch_fields = null, $category_filters = null, $variables = null, $docvar_filters = null, $function_filters = null)
    {
        $index = $this->getIndex($indexName);
        return $index->search($query, $start, $len, $scoring_function, $snippet_fields, $fetch_fields, $category_filters, $variables, $docvar_filters, $function_filters);
    }

    protected function getIndex($indexName)
    {
        $client = new Indextank_Api($this->apiUrl);
        return $client->get_index($indexName);
    }
}