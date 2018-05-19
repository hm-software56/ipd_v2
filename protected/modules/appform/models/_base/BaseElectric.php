<?php


/**
 * This is the model base class for the table "appform_electric".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "Electric".
 *
 * Columns in table "appform_electric" available as properties of the model,
 * followed by relations of table "appform_electric" available as properties of the model.
 *
 * @property integer $application_form_id
 * @property string $project_name
 * @property string $company_name
 * @property string $mou
 * @property string $develop_contract
 * @property string $consession_contract
 *
 * @property ApplicationForm $applicationForm
 * @property ElectricProjectSite[] $electricProjectSites
 */

abstract class BaseElectric extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'appform_electric';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'Electric|Electrics', $n);
	}

	public static function representingColumn() {
		return 'project_name';
	}

	public function rules() {
		return array(
			array('application_form_id, project_name, company_name', 'required'),
			array('application_form_id, province_id, district_id, village_id', 'numerical', 'integerOnly'=>true),
			array('project_name, company_name, address', 'length', 'max'=>255),
			array('mou, develop_contract, consession_contract', 'length', 'max'=>1),
			array('mou, develop_contract, consession_contract, address', 'default', 'setOnEmpty' => true, 'value' => null),
			array('application_form_id, project_name, company_name, mou, develop_contract, consession_contract, province_id, district_id, village_id, address', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
			'province' => array(self::BELONGS_TO, 'Province', 'province_id'),
			'district' => array(self::BELONGS_TO, 'District', 'district_id'),
			'village' => array(self::BELONGS_TO, 'Village', 'village_id'),
			'applicationForm' => array(self::BELONGS_TO, 'ApplicationForm', 'application_form_id'),
			'electricProjectSites' => array(self::HAS_MANY, 'ElectricProjectSite', 'electric_application_form_id'),
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'application_form_id' => null,
			'project_name' => Yii::t('app', 'Project Name'),
			'company_name' => Yii::t('app', 'Company Name'),
			'mou' => Yii::t('app', 'Mou'),
			'develop_contract' => Yii::t('app', 'Develop Contract'),
			'consession_contract' => Yii::t('app', 'Consession Contract'),
			'applicationForm' => null,
			'electricProjectSites' => null,
			'province_id' => null,
			'district_id' => null,
			'village_id' => null,
			'address' => Yii::t('app', 'Address'),
			'province' => null,
			'district' => null,
			'village' => null,
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('application_form_id', $this->application_form_id);
		$criteria->compare('project_name', $this->project_name, true);
		$criteria->compare('company_name', $this->company_name, true);
		$criteria->compare('mou', $this->mou, true);
		$criteria->compare('develop_contract', $this->develop_contract, true);
		$criteria->compare('consession_contract', $this->consession_contract, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}