<?php

class ApplicationStepController extends GxController 
{
    public $layout = '//layouts/column1';
        
	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id, 'ApplicationStep'),
		));
	}

	public function actionCreate() {
		$model = new ApplicationStep;


		if (isset($_POST['ApplicationStep'])) {
			$model->setAttributes($_POST['ApplicationStep']);

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
		$model = $this->loadModel($id, 'ApplicationStep');


		if (isset($_POST['ApplicationStep'])) {
			$model->setAttributes($_POST['ApplicationStep']);

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
			$this->loadModel($id, 'ApplicationStep')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('index'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$model = new ApplicationStep('search');
		$model->unsetAttributes();

		if (isset($_GET['ApplicationStep']))
			$model->setAttributes($_GET['ApplicationStep']);

		$this->render('index', array(
			'model' => $model,
		));	    
	}
	
	public function actionEditableSaver()
	{
	    $es = new TbEditableSaver('ApplicationStep');
	    $es->update();
	}
}