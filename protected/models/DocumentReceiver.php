<?php

Yii::import('application.models._base.BaseDocumentReceiver');

class DocumentReceiver extends BaseDocumentReceiver
{
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see CModel::behaviors()
	 */
	public function behaviors()
	{
	    return array(
	        'TrackChangeBehavior' => array(
	            'class' => 'TrackChangeBehavior',
	        ),
	        'CCompare' => array(
	            'class' => 'CCompare',
	        ),
	    );
	}
	
	/**
	 * (non-PHPdoc)
	 * @see CActiveRecord::afterSave()
	 */
	public function afterSave()
	{
	    if (!$this->isNewRecord) {
	            $rev_history = new DocumentReceiverHistory;
	            $rev_history->attributes = $this->oldAttributes;
	            $rev_history->user_action_id = Yii::app()->user->id;
	            $rev_history->action_time = date('Y-m-d H:i:s');
	            $rev_history->save();
	    }
	    return parent::afterSave();
	}
	
	/**
	 * (non-PHPdoc)
	 * @see CActiveRecord::beforeSave()
	 */
	public function beforeSave()
	{
	    if ($this->status_date != '' && $this->status_date != '0000-00-00 00:00:00') {
	        $this->status_date = date('Y-m-d H:i:s', strtotime($this->status_date));
	    }
	    return parent::beforeSave();
	}
	
	/**
	 * (non-PHPdoc)
	 * @see CActiveRecord::beforeDelete()
	 */
	public function beforeDelete()
	{
	    $rev_history = new DocumentReceiverHistory;
	    $rev_history->attributes = $this->attributes;
	    $rev_history->user_action_id = Yii::app()->user->id;
            $rev_history->action_time = date('Y-m-d H:i:s');
            $rev_history->save();
	    
            return parent::beforeDelete();
	}
	
	/**
	 * (non-PHPdoc)
	 * @see CActiveRecord::afterFind()
	 */
	public function afterFind()
	{
	    parent::afterFind();
	    if ($this->status_date != '' && $this->status_date != '0000-00-00 00:00:00')
	    {
	        $this->status_date = date('d-m-Y H:i:s',strtotime($this->status_date));
	    }
	}
}
