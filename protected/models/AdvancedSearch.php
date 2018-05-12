<?php
class AdvancedSearch extends CFormModel
{
	
	/*
	 * general propecties
	 */ 
	public $in_or_out;
	public $document_title;
	
	public $document_status_id;
	public $document_type_id;
	public $to_organization_id;
	
	
	public $from_date;
	public $to_date;
	
	/*
	 * In document properties
	 */
	public $is_application;
	public $from_organization_id;
		
	/*
	 * out document properties
	 */ 
	
	/*
	 * Application properties
	 */
	
	public $company_name;
	public $mou;
	public $develop_contract;
	
	public function attributeLabels()
	{
		return array(
			'document_title'=>Yii::t('app','Document Title'),
			'document_status_id'=>Yii::t('app','Status'),
			'document_type_id'=>Yii::t('app','Document Type'),
			'to_organization_id'=>Yii::t('app','To Organization'),
			'from_organization_id'=>Yii::t('app','From Organization'),
			'from_date'=>Yii::t('app','From Date'),
			'to_date'=>Yii::t('app','To Date'),
			'is_application'=>Yii::t('app','Is Application'),
			'company_name'=>Yii::t('app', 'Company\'s name'),
		);
	}
	
	public function rules()
	{
		return array(
			array(
				'document_title, company_name','length','max'=>255
			),
			array(
				'in_or_out','length','max'=>3
			),
			array(
				'document_type_id, to_organization_id, from_organization_id', 'numerical', 'integerOnly'=>true
			),
			array(
				'from_date, to_date', 'date', 'format'=>'dd-mm-yyyy','allowEmpty'=>true
			),
			array(
				'to_date','compare','compareAttribute'=>'from_date','operator'=>'>=','allowEmpty'=>true
			),
			array(	'document_title, document_status_id, is_application,	document_type_id, 
					to_organization_id, 
					from_organization_id,
					from_date,
					to_date,
					company_name',
					'default',
					'setOnEmpty'=> true,
					'value'=>null
			),
			array('in_or_out, is_application, document_title, company_name, document_status_id, document_type_id, to_organization_id, from_organization_id, from_date, to_date, ','safe')
		);	
	}
}