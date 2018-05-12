<?php

Yii::import('appform.models._base.BaseRepOffice');

class RepOffice extends BaseRepOffice
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see CActiveRecord::afterFind()
	 */
	public function afterFind()
	{
	    if ($this->birth_date != '' && $this->birth_date != '0000-00-00') {
	        $this->birth_date = date('d-m-Y',strtotime($this->birth_date));
	    }
	    parent::afterFind();
	}
	
	/**
	 * (non-PHPdoc)
	 * @see CActiveRecord::beforeSave()
	 */
	public function beforeSave()
	{
	    if ($this->birth_date != '' && $this->birth_date != '0000-00-00') {
	        $this->birth_date = date('Y-m-d',strtotime($this->birth_date));
	    }
	    return parent::beforeSave();
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