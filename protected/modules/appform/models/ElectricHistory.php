<?php

Yii::import('appform.models._base.BaseElectricHistory');

class ElectricHistory extends BaseElectricHistory
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see CActiveRecord::primaryKey()
	 */
	public function primaryKey()
	{
	    return 'action_time';
	}
	
}