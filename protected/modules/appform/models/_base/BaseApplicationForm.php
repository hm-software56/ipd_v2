<?php

/**
 * This is the model base class for the table "appform_application_form".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "ApplicationForm".
 *
 * Columns in table "appform_application_form" available as properties of the model,
 * followed by relations of table "appform_application_form" available as properties of the model.
 *
 * @property integer $id
 * @property integer $application_type_id
 * @property integer $inc_document_id
 * @property integer $investor_region_id
 * @property string $contact_email
 * @property integer $application_step_id
 *
 * @property ApplicationEmail[] $applicationEmails
 * @property ApplicationStep $applicationStep
 * @property InvestorRegion $investorRegion
 * @property ApplicationType $applicationType
 * @property Electric $electric
 * @property General $general
 * @property InvestCompany[] $investCompanies
 * @property Mining $mining
 * @property RepOffice[] $repOffices
 */
abstract class BaseApplicationForm extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'appform_application_form';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'ApplicationForm|ApplicationForms', $n);
	}

	public static function representingColumn() {
		return 'contact_email';
	}

	public function rules() {
		return array(
			array('application_type_id, inc_document_id, investor_region_id, contact_email, application_step_id', 'required'),
			array('application_type_id, inc_document_id, investor_region_id, application_step_id', 'numerical', 'integerOnly'=>true),
			array('contact_email', 'length', 'max'=>60),
			array('id, application_type_id, inc_document_id, investor_region_id, contact_email, application_step_id', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'applicationEmails' => array(self::HAS_MANY, 'ApplicationEmail', 'application_form_id'),
			'applicationStep' => array(self::BELONGS_TO, 'ApplicationStep', 'application_step_id'),
			'investorRegion' => array(self::BELONGS_TO, 'InvestorRegion', 'investor_region_id'),
			'applicationType' => array(self::BELONGS_TO, 'ApplicationType', 'application_type_id'),
			'electric' => array(self::HAS_ONE, 'Electric', 'application_form_id'),
			'general' => array(self::HAS_ONE, 'General', 'application_form_id'),
			'investCompanies' => array(self::HAS_MANY, 'InvestCompany', 'application_form_id'),
			'mining' => array(self::HAS_ONE, 'Mining', 'application_form_id'),
			'repOffices' => array(self::HAS_MANY, 'RepOffice', 'application_form_id'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'ID'),
			'application_type_id' => null,
			'inc_document_id' => Yii::t('app', 'Inc Document'),
			'investor_region_id' => null,
			'contact_email' => Yii::t('app', 'Contact Email'),
			'application_step_id' => null,
			'applicationEmails' => null,
			'applicationStep' => null,
			'investorRegion' => null,
			'applicationType' => null,
			'electric' => null,
			'general' => null,
			'investCompanies' => null,
			'mining' => null,
			'repOffices' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('application_type_id', $this->application_type_id);
		$criteria->compare('inc_document_id', $this->inc_document_id);
		$criteria->compare('investor_region_id', $this->investor_region_id);
		$criteria->compare('contact_email', $this->contact_email, true);
		$criteria->compare('application_step_id', $this->application_step_id);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}