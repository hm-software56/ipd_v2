<?php

Yii::import('application.models._base.BaseDocumentReceiverHistory');

class DocumentReceiverHistory extends BaseDocumentReceiverHistory
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
	    if ($this->status_date != '' && $this->status_date != '0000-00-00 00:00:00') {
	        $this->status_date = date('Y-m-d H:i:s', strtotime($this->status_date));
	    }
	    return parent::beforeSave();
	}
	
	/**
	 * (non-PHPdoc)
	 * @see BaseDocumentReceiverHistory::relations()
	 */
	public function relations() {
		$new = array(
			'documentStatus' => array(self::BELONGS_TO, 'DocumentStatus', 'document_status_id'),
			'organization' => array(self::BELONGS_TO, 'Organization', 'to_organization_id'),
			'userProfile'=> array(self::BELONGS_TO, 'UserProfile', 'user_action_id'),
		);
		return array_merge(parent::relations(),$new);
	}
	
	
}