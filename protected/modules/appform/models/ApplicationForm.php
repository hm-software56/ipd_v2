<?php

Yii::import('appform.models._base.BaseApplicationForm');

class ApplicationForm extends BaseApplicationForm
{    
    public $document_no;
    public $document_title;
    public $document_date;
    
    public $invests = array();
    
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
	    $doc = Yii::app()->controller->module->documentClass;
	    $docno = Yii::app()->controller->module->documentNo;
	    $docTitle = Yii::app()->controller->module->documentTitle;
	    $document=$doc::model()->findByPk($this->inc_document_id);
	    $this->document_no = $document->$docno;
	    $this->document_title = $document->$docTitle;
	    $this->document_date = $document->document_date;
	    
	    $provider = new CArrayDataProvider($this->investCompanies);
	    $this->invests = $provider->getData();
	}
	
	/**
	 * (non-PHPdoc)
	 * @see BaseApplicationForm::relations()
	 */
	public function relations()
	{
	    $relations = array(
	        'indocument' => array(self::BELONGS_TO, Yii::app()->controller->module->documentClass,'inc_document_id'),
	    );
	    
	    return array_merge(parent::relations(), $relations);
	}
	
	/**
	 * (non-PHPdoc)
	 * @see BaseApplicationForm::rules()
	 */
	public function rules() {
		$rules = array(
		    array('contact_email','email'),
			array('document_no, document_title, document_date', 'safe', 'on'=>'search'),
		);
		
		return array_merge(parent::rules(),$rules);
	}
	
	public function search() {
	    $doc = Yii::app()->controller->module->documentClass;
	    $docno = Yii::app()->controller->module->documentNo;
	    $docTitle = Yii::app()->controller->module->documentTitle;
	    
		$criteria = new CDbCriteria;
		$criteria->with = array(
		    'indocument',    //from relation
		);
		$criteria->together=true;

		$criteria->compare('id', $this->id);
		$criteria->compare('application_type_id', $this->application_type_id);
		$criteria->compare('inc_document_id', $this->inc_document_id);
		$criteria->compare('investor_region_id', $this->investor_region_id);
		$criteria->compare('indocument.'.$docno, $this->document_no,true);
		//$criteria->compare('indocument.'.$docTitle, $this->document_title,true);
		//$criteria->compare('indocument.document_date', $this->document_date);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		    'pagination'=>array(
		        'pageSize'=>50,
		    ),
		    'sort'=>array(
		        'defaultOrder'=>'id DESC',
		        'attributes'=>array(
		            'document_no'=>array(
		                'asc'=>'indocument.'.$docno,
		                'desc'=>'indocument.'.$docno.' DESC',
		            ),
		            /*'document_title'=>array(
		                'asc'=>'indocument.'.$docTitle,
		                'desc'=>'indocument.'.$docTitle.' DESC',
		            ),
		            'document_date'=>array(
		                'asc'=>'document.document_date ASC',
		                'desc'=>'document.document_date DESC',
		            ),*/
		            '*',
		        )
		    ),
		));
	}

	public function getInvestProvider()
	{
	    return new CArrayDataProvider($this->invests);
	}
	
	public function addInvest($theInvest)
	{
	    $flag = FALSE;
	    $validateArray = array(
	        'company_name',
	        'register_place',
	        'register_date',
	        'total_capital',
	        'capital',
	        'president_first_name',
	        'president_last_name',
	        'president_nationality',
	        'president_position',
	        'headquarter_address',
	        'business_sector_id',
	    );
	    if ($theInvest->validate($validateArray)) {
	        $flag = TRUE;
            foreach ($this->invests as $invest) {
                if ($invest->company_name == $theInvest->company_name) {
                    $flag = FALSE;
                    break;
                }
            }
            if ($flag)
                $this->invests[]=$theInvest;
	    }
	        
	    Yii::app()->session->add('eappform', $this);
	}
	
	public function removeInvest($theInvest)
	{
	    foreach ($this->invests as $i=>$invest) {
	        if ($invest->company_name == $theInvest->company_name) {
	            unset($this->invests[$i]);
	            Yii::app()->session->add('eappform', $this);
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