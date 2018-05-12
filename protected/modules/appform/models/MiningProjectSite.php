<?php

Yii::import('appform.models._base.BaseMiningProjectSite');

class MiningProjectSite extends BaseMiningProjectSite
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
	        'historyBehavior'=>'appform.components.behaviors.HistoryBehavior',
	    );
	}
}