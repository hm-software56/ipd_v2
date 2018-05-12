<?php

class TypeLevelController extends GxController {


	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id, 'TypeLevel'),
		));
	}

	public function actionCreate() {
		$model = new TypeLevel;


		if (isset($_POST['TypeLevel'])) {
			$model->setAttributes($_POST['TypeLevel']);

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
		$model = $this->loadModel($id, 'TypeLevel');


		if (isset($_POST['TypeLevel'])) {
			$model->setAttributes($_POST['TypeLevel']);

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
			$this->loadModel($id, 'TypeLevel')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$model = new TypeLevel('search');
		$model->unsetAttributes();

		if (isset($_GET['TypeLevel']))
			$model->setAttributes($_GET['TypeLevel']);

		$this->render('index', array(
			'model' => $model,
		));
	}

	public function actionAdmin() {
		$model = new TypeLevel('search');
		$model->unsetAttributes();

		if (isset($_GET['TypeLevel']))
			$model->setAttributes($_GET['TypeLevel']);

		$this->render('admin', array(
			'model' => $model,
		));
	}

}