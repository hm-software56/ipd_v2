<?php

Yii::import('appform.models._base.BaseApplicationType');

class ApplicationType extends BaseApplicationType
{
    /**
     * Office Representative Application
     * @var integer
     */
    const REPRESENTATIVE = 1;
    
    /**
     * Electricity Application
     * @var integer
     */
    const ELECTRICITY = 2;
    
    /**
     * Mining Application
     * @var integer
     */
    const MINING = 3;
    
    /**
     * General Application
     * @var integer
     */
    const GENERAL = 4;
    
    public static function model($className=__CLASS__) {
		return parent::model($className);
	}
}