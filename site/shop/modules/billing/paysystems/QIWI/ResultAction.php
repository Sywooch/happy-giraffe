<?php
class ResultAction extends PSAction
{

    public function run()
    {
		$system = $this->getSystem();
		$pids = BillingPayment::model()->dbConnection->createCommand(
			'SELECT payment_id FROM '.BillingPayment::model()->tableName()
			.' WHERE payment_system_id='.$system->system_id
			.' AND payment_status=0 AND payment_accept_time'
		)->queryColumn();
		if(!$pids) return;

		require_once(($dir=dirname(__FILE__)).'/qiwi.inc.php');
		$qiwi = QIWI::getInstance(array_merge(
			require_once($dir . '/qiwi.cfg.php'),
			$system->getParameters()
		));
		foreach($qiwi->billStatus($pids) as $pid=>$result)
		{
		//	echo "<br>$txnId ".$info['amount'].": ".$info['status'];

			if ($result['status']<60) continue;
			$info = http_build_query($result, null, "\n");
			$payment = BillingPayment::model()->findByPk($pid);
			$payment->invoke('result', $info, time(), $result['status']==60 ?1 :-1);
		}
    }

}?>
