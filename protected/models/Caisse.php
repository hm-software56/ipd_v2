<?php

Yii::import('application.models._base.BaseCaisse');

class Caisse extends BaseCaisse
{
	public $inc_document_no;
	public $start_date;
	public $end_date;
	
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	
	public function rules()
	{
		$new = array(
				array('inc_document_no', 'safe', 'on'=>'search'),
				array('start_date,end_date','length', 'max'=>255),
		);
		return array_merge(parent::rules(),$new);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see CActiveRecord::afterFind()
	 */
	public function afterFind()
	{
	    parent::afterFind();
	    
	    if ($this->payment_date != '' && $this->payment_date != '0000-00-00 00:00:00')
	    {
	        $this->payment_date = date('d-m-Y H:i:s',strtotime($this->payment_date));
	    }
	    
	    if($this->create_date  != '' && $this->create_date != '0000-00-00 00:00:00')
	    {
	    	$this->create_date = date('d-m-Y H:i:s',strtotime($this->create_date));
	    }
	}
	
	/**
	 * (non-PHPdoc)
	 * @see CActiveRecord::beforeSave()
	 */
	public function beforeSave()
	{
	    if ($this->payment_date != '' && $this->payment_date != '0000-00-00 00:00:00')
	    {
	        $this->payment_date = date('Y-m-d H:i:s',strtotime($this->payment_date));
	    }
	    
		if ($this->create_date != '' && $this->create_date != '0000-00-00 00:00:00')
	    {
	        $this->create_date = date('Y-m-d H:i:s',strtotime($this->create_date));
	    }
	    
	    return parent::beforeSave();
	}
	
	public function search() {
		$criteria = new CDbCriteria;
		
		$criteria->with = array('incDocument');
		
		$c_date="";
	 	if ($this->create_date != '' && $this->create_date != '0000-00-00')
	    {
	        $c_date = date('Y-m-d',strtotime($this->create_date));
	    }
	    $p_date="";
		if ($this->payment_date != '' && $this->payment_date != '0000-00-00')
	    {
	        $p_date = date('Y-m-d',strtotime($this->payment_date));
	    }
		
		$criteria->compare('id', $this->id);
		$criteria->compare('inc_document_id', $this->inc_document_id);
		$criteria->compare('incDocument.inc_document_no', $this->inc_document_no,true);
		$criteria->compare('payment_status', $this->payment_status);
		$criteria->compare('amount_to_budget', $this->amount_to_budget);
		$criteria->compare('amount_to_department', $this->amount_to_department);
		$criteria->compare('date(`create_date`)', '='.$c_date);
		//$criteria->compare('payment_date', $this->payment_date, true);
		$criteria->compare('date(`payment_date`)','='.$p_date);
		$criteria->compare('payment_status', $this->payment_status);
		$criteria->compare('user_id', $this->user_id);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}