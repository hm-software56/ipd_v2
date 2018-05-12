<?php

class DocumentReceiverController extends GxController {


	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id, 'DocumentReceiver'),
		));
	}

	public function actionCreate() {
		$model = new DocumentReceiver;

		$this->performAjaxValidation($model, 'document-receiver-form');

		if (isset($_POST['DocumentReceiver'])) {
			$model->setAttributes($_POST['DocumentReceiver']);

			if ($model->save()) {
				if (Yii::app()->getRequest()->getIsAjaxRequest())
					Yii::app()->end();
				else
					$this->redirect(array('view', 'id' => $model->out_document_id));
			}
		}

		$this->render('create', array( 'model' => $model));
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id, 'DocumentReceiver');

		$this->performAjaxValidation($model, 'document-receiver-form');

		if (isset($_POST['DocumentReceiver'])) {
			$model->setAttributes($_POST['DocumentReceiver']);

			if ($model->save()) {
				$this->redirect(array('view', 'id' => $model->out_document_id));
			}
		}

		$this->render('update', array(
				'model' => $model,
				));
	}

	public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$this->loadModel($id, 'DocumentReceiver')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$dataProvider = new CActiveDataProvider('DocumentReceiver');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	public function actionAdmin() {
		$model = new DocumentReceiver('search');
		$model->unsetAttributes();

		if (isset($_GET['DocumentReceiver']))
			$model->setAttributes($_GET['DocumentReceiver']);

		$this->render('admin', array(
			'model' => $model,
		));
	}

}