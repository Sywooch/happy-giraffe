<?php

namespace site\common\components\closureTable;

interface INode
{
    public function getId();

    public function setId($id);

    public function appendChild(INode $node);
}