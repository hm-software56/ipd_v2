<?php

Yii::import('appform.models._base.BaseGeneral');

class General extends BaseGeneral
{
    public $sites = array();
    
	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	/**
	 * (non-PHPdoc)
	 * @see CActiveRecord::afterFind()
	 */
	public function afterFind()
	{
	    parent::afterFind();
	    $provider = new CArrayDataProvider($this->generalProjectSites);
	    $this->sites = $provider->getData();
	}
	
	public function getSiteProvider()
	{
	    return new CArrayDataProvider($this->sites);
	}
	
	public function addSite($theSite)
	{
	    $flag = FALSE;
	    if ($theSite->province_id != '' && $theSite->district_id != '') {
	        $flag = TRUE;
            foreach ($this->sites as $site) {
                if ($site->province_id == $theSite->province_id && $site->district_id== $theSite->district_id && $site->village_id==$theSite->village_id) {
                    $flag = FALSE;
                    break;
                }
            }
            if ($flag)
                $this->sites[]=$theSite;
	    }
	        
	    Yii::app()->session->add('general', $this);
	}
	
	public function removeSite($theSite)
	{
	    foreach ($this->sites as $i=>$site) {
	        if ($site->province_id == $theSite->province_id && $site->district_id== $theSite->district_id && $site->village_id==$theSite->village_id) {
	            unset($this->sites[$i]);
	            Yii::app()->session->add('general', $this);
	            break;
	        }
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