<?php

Yii::import('application.models._base.BaseFee');

class Fee extends BaseFee
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}