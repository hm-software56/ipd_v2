<?php

class CaisseController extends GxController {


	public function actionView($id) {
			$this->renderPartial('view', array(
				'model' => $this->loadModel($id, 'Caisse'),
			));
	}
	
	public function actionPrint($id) {
			$this->render('print', array(
				'model' => $this->loadModel($id, 'Caisse'),
			));
	}

	public function actionCreate() {
		$model = new Caisse;


		if (isset($_POST['Caisse'])) {
			$model->setAttributes($_POST['Caisse']);

			if ($model->save()) {
				if (Yii::app()->getRequest()->getIsAjaxRequest())
					Yii::app()->end();
				else
					$this->redirect(array('view', 'id' => $model->id));
			}
		}

		$this->render('create', array( 'model' => $model));
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id, 'Caisse');


		if (isset($_POST['Caisse'])) {
			$model->setAttributes($_POST['Caisse']);

			if ($model->save()) {
				$this->redirect(array('view', 'id' => $model->id));
			}
		}

		$this->render('update', array(
				'model' => $model,
				));
	}

	public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$this->loadModel($id, 'Caisse')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$model = new Caisse('search');
		$model->unsetAttributes();

		if (isset($_GET['Caisse']))
			$model->setAttributes($_GET['Caisse']);

		$this->render('index', array(
			'model' => $model,
		));
	}

	public function actionAdmin() {
		$model = new Caisse('search');
		$model->unsetAttributes();

		if (isset($_GET['Caisse']))
			$model->setAttributes($_GET['Caisse']);

		$this->render('admin', array(
			'model' => $model,
		));
	}
	
	/**
	 * 
	 * Enter description here ...
	 */
	public function actionPayment()
	{
		Caisse::model()->updateByPk((int)$_POST['id'],array('payment_date'=>date('Y-m-d H:i:s'),'payment_status'=>(int)$_POST['status']));
		$this->redirect(Yii::app()->request->urlReferrer);
	}

}