<?php

Yii::import('application.models._base.BaseMiningHistory');

class MiningHistory extends BaseMiningHistory
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}