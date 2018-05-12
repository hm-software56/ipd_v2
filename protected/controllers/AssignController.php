<?php

class AssignController extends GxController {


	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id, 'Assign'),
		));
	}

	public function actionCreate() {
		$model = new Assign;
		
		$preSelectedItems = array();
		$userProfile=UserProfile::model()->findByPK(Yii::app()->user->id);
		$myuserorganization=CHtml::listData(UserProfile::model()->findAll(array("condition"=>"organization_id =$userProfile->organization_id")), 'user_id', 'first_name');
		
		if (isset($_POST['Assign'])) {
			$preSelectedItems = array();
			
			$model->setAttributes($_POST['Assign']);
			$docid=$model->inc_document_document_id;
			Assign::model()->deleteAllByAttributes(array('inc_document_document_id'=>$docid));
			if(isset($_POST['user_id']))
			foreach($_POST['user_id'] as $userid)
			{
				 $model=new Assign;
			     $model->user_id=$userid;
			     $model->inc_document_document_id=$docid;
			     $model->save();
            }
				//$this->redirect(array('inDocument/index'));
				$this->redirect(Yii::app()->request->urlReferrer);
		}
		
		$assign=Assign::model()->findAllByAttributes(array('inc_document_document_id'=>(int)$_GET['docid']));
		foreach ($assign as $assigns)
		{
			$preSelectedItems[]=$assigns->user_id;
		}
		$this->renderPartial('create', array( 
				'model' => $model, 
				'myuserorganization'=>$myuserorganization,
				'select'=>$preSelectedItems,
				'docid'=>(int)$_GET['docid'])
		);
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id, 'Assign');


		if (isset($_POST['Assign'])) {
			$model->setAttributes($_POST['Assign']);

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
			$this->loadModel($id, 'Assign')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$dataProvider = new CActiveDataProvider('Assign');
		$this->render('index', array(
			'dataProvider' => $dataProvider,
		));
	}

	public function actionAdmin() {
		$model = new Assign('search');
		$model->unsetAttributes();

		if (isset($_GET['Assign']))
			$model->setAttributes($_GET['Assign']);

		$this->render('admin', array(
			'model' => $model,
		));
	}

}