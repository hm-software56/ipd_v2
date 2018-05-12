<?php

class FeeController extends GxController {


	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id, 'Fee'),
		));
	}

	public function actionCreate() {
		$model = new Fee;


		if (isset($_POST['Fee'])) {
			$model->setAttributes($_POST['Fee']);

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
		$model = $this->loadModel($id, 'Fee');


		if (isset($_POST['Fee'])) {
			$model->setAttributes($_POST['Fee']);

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
			$this->loadModel($id, 'Fee')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$this->layout='column1';
		$model = new Fee('search');
		$model->unsetAttributes();

		if (isset($_GET['Fee']))
			$model->setAttributes($_GET['Fee']);

		$this->render('admin', array(
			'model' => $model,
		));
	}

	public function actionAdmin() {
		$model = new Fee('search');
		$model->unsetAttributes();

		if (isset($_GET['Fee']))
			$model->setAttributes($_GET['Fee']);

		$this->render('admin', array(
			'model' => $model,
		));
	}

}