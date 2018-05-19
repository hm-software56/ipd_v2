<?php

/**
 * This is the model base class for the table "fulltext_document".
 * DO NOT MODIFY THIS FILE! It is automatically generated by giix.
 * If any changes are necessary, you must set or override the required
 * property or method in class "FulltextDocument".
 *
 * Columns in table "fulltext_document" available as properties of the model,
 * and there are no model relations.
 *
 * @property integer $id
 * @property string $document_title
 *
 */
abstract class BaseFulltextDocument extends GxActiveRecord {

	public static function model($className=__CLASS__) {
		return parent::model($className);
	}

	public function tableName() {
		return 'fulltext_document';
	}

	public static function label($n = 1) {
		return Yii::t('app', 'FulltextDocument|FulltextDocuments', $n);
	}

	public static function representingColumn() {
		return 'document_title';
	}

	public function rules() {
		return array(
			array('id, document_title', 'required'),
			array('id', 'numerical', 'integerOnly'=>true),
			array('id, document_title', 'safe', 'on'=>'search'),
		);
	}

	public function relations() {
		return array(
		);
	}

	public function pivotModels() {
		return array(
		);
	}

	public function attributeLabels() {
		return array(
			'id' => Yii::t('app', 'ID'),
			'document_title' => Yii::t('app', 'Document Title'),
		);
	}

	public function search() {
		$criteria = new CDbCriteria;

		$criteria->compare('id', $this->id);
		$criteria->compare('document_title', $this->document_title, true);

		return new CActiveDataProvider($this, array(
			'criteria' => $criteria,
		));
	}
}