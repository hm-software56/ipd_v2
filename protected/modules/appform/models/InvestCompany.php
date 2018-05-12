<?php

Yii::import('appform.models._base.BaseInvestCompany');

class InvestCompany extends BaseInvestCompany
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see CActiveRecord::beforeSave()
	 */
	public function beforeSave()
	{
	    if ($this->register_date != '' && $this->register_date != '0000-00-00') {
	        $this->register_date = date('Y-m-d',strtotime($this->register_date));
	    }
	    return parent::beforeSave();
	}
	
	/**
	 * (non-PHPdoc)
	 * @see CActiveRecord::afterFind()
	 */
	public function afterFind()
	{
	    parent::afterFind();
	    if ($this->register_date != '' && $this->register_date != '0000-00-00') {
	        $this->register_date = date('d-m-Y',strtotime($this->register_date));
	    }
	}
	
	/**
	 * (non-PHPdoc)
	 * @see CModel::behaviors()
	 */
	public function behaviors()
	{
	    return array(
	        'historyBehavior'=>'appform.components.behaviors.HistoryBehavior',
	    );
	}
}