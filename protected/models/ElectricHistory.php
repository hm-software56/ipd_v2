<?php

Yii::import('application.models._base.BaseElectricHistory');

class ElectricHistory extends BaseElectricHistory
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}