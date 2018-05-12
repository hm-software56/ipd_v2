<?php

class OrganizationController extends GxController {


	public function actionView($id) {
		$this->render('view', array(
			'model' => $this->loadModel($id, 'Organization'),
		));
	}

	public function actionCreate() {
		$model = new Organization;


		if (isset($_POST['Organization'])) {
			$model->setAttributes($_POST['Organization']);

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
		$model = $this->loadModel($id, 'Organization');


		if (isset($_POST['Organization'])) {
			$model->setAttributes($_POST['Organization']);

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
			$this->loadModel($id, 'Organization')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}

	public function actionIndex() {
		$model = new Organization('search');
		$model->unsetAttributes();

		if (isset($_GET['Organization']))
			$model->setAttributes($_GET['Organization']);

		$this->render('index', array(
			'model' => $model,
		));
	}

	public function actionAdmin() {
		$model = new Organization('search');
		$model->unsetAttributes();

		if (isset($_GET['Organization']))
			$model->setAttributes($_GET['Organization']);

		$this->render('admin', array(
			'model' => $model,
		));
	}
	
	/**
	 * 
	 * Enter description here ...organizationsenddoc.php
	 */
	public function actionSenddocToreceiver()
	{
		$fromto=new FromTo;
		
		$preSelectedItems = array();
		$organization=CHtml::listData(Organization::model()->findAll(), 'id', 'organization_name');
		
		if (isset($_POST['FromTo'])) {
			$preSelectedItems = array();
			
			$fromto->setAttributes($_POST['FromTo']);
			$id=$fromto->from_organization_id;
			FromTo::model()->deleteAllByAttributes(array('from_organization_id'=>$id));
			if(isset($_POST['to_organization_id']))
				foreach($_POST['to_organization_id'] as $to_organization_id)
				{
					 $model=new FromTo;
				     $model->to_organization_id=$to_organization_id;
				     $model->from_organization_id=$id;
				     $model->save();
	            }
			$this->redirect(Yii::app()->request->urlReferrer);
		}
		
		$selectfromto=FromTo::model()->findAllByAttributes(array('from_organization_id'=>(int)$_GET['id']));
		foreach ($selectfromto as $selectfromtos)
		{
			$preSelectedItems[]=$selectfromtos->to_organization_id;
		}
		
		$this->render('organizationsenddoc', array( 
				'model' => $fromto, 
				'organization'=>$organization,
				'select'=>$preSelectedItems,
				'id'=>(int)$_GET['id']
			)
		);
	}

}