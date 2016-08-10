<?php

namespace site\frontend\modules\referals\components\handlers;

use site\frontend\modules\referals\models\UserRefLink;
use site\frontend\modules\referals\models\UserRefVisitor;

/**
 * @property UserRefLink $ref
 * @property UserRefVisitor $visitor
 */
abstract class Handler
{
    protected $ref;
    protected $visitor;

    /**
     * @return UserRefLink
     *
     * @throws \HttpException
     */
    protected function getRef()
    {
        if (!$this->ref) {
            throw new \HttpException('InvalidRef', 400);
        }

        return $this->ref;
    }

    /**
     * @param UserRefLink $ref
     *
     * @return string redirect url
     */
    public function handle($ref)
    {
        $this->ref = $ref;

        if (!$this->getVisitor()) {
            $this->addVisitor();
        }

        return $this->continueHandle();
    }

    /**
     * @return string redirect url
     */
    protected abstract function continueHandle();

    /**
     * @return UserRefVisitor
     */
    protected function getVisitor()
    {
        if (!$this->visitor) {
            $this->visitor = UserRefVisitor::model()
                ->byRef($this->getRef()->id)
                ->byIP(\Yii::app()->request->userHostAddress)
                ->byFrom(\Yii::app()->request->urlReferrer)
                ->find();
        }

        return $this->visitor;
    }

    /**
     * @return UserRefVisitor
     *
     * @throws \HttpException
     */
    protected function addVisitor()
    {
        $visitor = new UserRefVisitor();

        $visitor->ref = $this->getRef()->id;
        $visitor->ip = \Yii::app()->request->userHostAddress;
        $visitor->from = \Yii::app()->request->urlReferrer;

        if ($visitor->save()) {
            $this->visitor = $visitor;
            return $this->visitor;
        }

        throw new \HttpException('VisitorNotSaved', 500);
    }
}