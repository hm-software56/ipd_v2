<?php

class DocumentTypeController extends GxController {


	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id, 'DocumentType'),
		));
	}

	public function actionCreate() {
		$model = new DocumentType;


		if (isset($_POST['DocumentType'])) {
			$model->setAttributes($_POST['DocumentType']);

			if ($model->save()) {
				if (Yii::app()->getRequest()->getIsAjaxRequest())
					Yii::app()->end();
				else
					$this->redirect(array('index'));
			}
		}

		$this->render('create', array( 'model' => $model));
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id, 'DocumentType');


		if (isset($_POST['DocumentType'])) {
			$model->setAttributes($_POST['DocumentType']);

			if ($model->save()) {
				$this->redirect(array('index'));
			}
		}

		$this->render('update', array(
				'model' => $model,
				));
	}

	public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$this->loadModel($id, 'DocumentType')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$model = new DocumentType('search');
		$model->unsetAttributes();

		if (isset($_GET['DocumentType']))
			$model->setAttributes($_GET['DocumentType']);

		$this->render('index', array(
			'model' => $model,
		));
	}

	public function actionAdmin() {
		$model = new DocumentType('search');
		$model->unsetAttributes();

		if (isset($_GET['DocumentType']))
			$model->setAttributes($_GET['DocumentType']);

		$this->render('admin', array(
			'model' => $model,
		));
	}

}