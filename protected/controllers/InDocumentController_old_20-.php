<?php

class InDocumentController extends GxController {


	public function actionView($id) {
		
		if(Yii::app()->user->checkAccess("DG"))
		{
			if(isset($_POST['Comment']))
			{
				$comment = new Comment;
			
				$comment->attributes = $_POST['Comment'];
				$comment->document_id = $id;
				$comment->user_id = Yii::app()->user->id;
				$comment->comment_time = date('Y-m-d H:i:s');
				if(isset($_POST['toUsers']))
				{
					if($comment->save())
					{
						foreach($_POST['toUsers'] as $user_id)
						{
							$comment_2_users = new CommentToUser;
							$comment_2_users->comment_id = $comment->id;
							$comment_2_users->user_id = $user_id; 
							$comment_2_users->save();
						}
					}
				}
			}
		}else{
			$comment=Comment::model()->findAllByAttributes(array('document_id'=>$id));
			foreach ($comment as $comments)
			{
				$commentToUser=CommentToUser::model()->findAllByAttributes(array('comment_id'=>$comments->id,'user_id'=>Yii::app()->user->id));
				if(!is_object($commentToUser))
				{
					foreach ($commentToUser as $commentToUsers)
					{
						$updatestatus=CommentToUser::model()->findByPK($commentToUsers->id);
						$updatestatus->status="Read";
						$updatestatus->save();
						
					}
				}
			}
			
		}
		$this->render('view', array(
			'model' => $this->loadModel($id, 'IncDocument'),
		));
	}

	public function actionCreate() {
		$model = new IncDocument;
		$model->is_application="";
		$model->document = new Document;
		$comment = new Comment;
		$caisse=new Caisse;
		$connection = Yii::app()->db;
		$transaction = null;
		
		if (isset($_POST['IncDocument']) && isset($_POST['Document']) && isset($_POST['Comment'])) {
			$model->setAttributes($_POST['IncDocument']);
			$model->document->setAttributes($_POST['Document']);
			$comment->setAttributes($_POST['Comment']);
			
			
			$user = Yii::app()->session->get('user');
			$organization=$user->userProfile->organization;
			
			
			//Set default values
			$model->status_date = date('d-m-Y');
			$model->to_organization_id = $organization->id;
			
			//$model->document->document_date = date('d-m-Y');
			$model->document->created = date('Y-m-d H:i:s');
			$model->document->created_by = $user->id;
			$model->document->last_modified = $model->document->created;
			$model->document->last_modified_id = $user->id;
			$model->document->in_or_out = 'INC';
					
			
			$transaction = $connection->beginTransaction();
			try {
			    
			    if (!$model->document->save())
			    throw new Exception('Cannot save Document');
			    
			    $model->document_id=$model->document->id;
			    
			    if (!$model->save())
			    throw new Exception('Cannot save Incoming Document');
			    
			    if(!empty( $comment->comment_detail))
			    {
			    	$comment->document_id=$model->document->id;
			    	$comment->user_id=$user->id;
					$comment->comment_time=date('Y-m-d H:i:s');
			   		if(!$comment->save())
			    	throw new Exception('Cannot save comments');
			    }
			    
			    if(!empty($model->fee_id))
			    {
			    	$fee=Fee::model()->findByPK($model->fee_id);
			    	$caisse->inc_document_id=$model->document_id;
			    	$caisse->amount_to_budget=$fee->amount_to_budget;
			    	$caisse->amount_to_department=$fee->amount_to_department;
			    	$caisse->create_date=date('Y-m-d H:i:s');
			    	$caisse->user_id=Yii::app()->user->id;
			    	$caisse->save();
			    }
			    
			    $transaction->commit();
			    Yii::app()->user->setFlash('success', 'New document no. <strong>'.$model->document_no.'</strong> has been created successfully.');
			    //$this->redirect(array('view','id'=>$model->document_id));
			    if($model->document->document_type_id==Yii::app()->params->IsAppMining)
			    {
			    	$this->redirect(array('appform/applicationForm/createMining','docid'=>$model->document_id));
			    }elseif($model->document->document_type_id==Yii::app()->params->IsAppElectricity){
			    	$this->redirect(array('appform/applicationForm/createElectric','docid'=>$model->document_id));
			    }elseif($model->document->document_type_id==Yii::app()->params->IsAppGeneral || 
			    		$model->document->document_type_id==Yii::app()->params->IsAppGeneral1 ||
			    		$model->document->document_type_id==Yii::app()->params->IsAppGeneral2 ||
			    		$model->document->document_type_id==Yii::app()->params->IsAppGeneral3 ||
			    		$model->document->document_type_id==Yii::app()->params->IsAppGeneral4 ||
			    		$model->document->document_type_id==Yii::app()->params->IsAppGeneral5
			    ){
			    	$this->redirect(array('appform/applicationForm/createGeneral','docid'=>$model->document_id));
			    }elseif($model->document->document_type_id==Yii::app()->params->IsAppReOffice){
			    	$this->redirect(array('appform/applicationForm/createRepOffice','docid'=>$model->document_id));
			    }else{
			    	$this->redirect(array('view','id'=>$model->document_id));
			    }
			} catch (Exception $e) {
			    $transaction->rollback();
			    Yii::app()->user->setFlash('error', '<strong>Error!</strong> Fix things up and submit again.');
			}
		}

		$this->render('create', array( 
				'model' => $model,
				'comment' => $comment,
		));
	}

	public function actionUpdate($id) {
		$model = $this->loadModel($id, 'IncDocument');
		$model->document = $this->loadModel($id, 'Document');
		$comment = new Comment;
		$fee_id=$model->fee_id;

		if (isset($_POST['IncDocument'])) {
			$model->setAttributes($_POST['IncDocument']);
			$model->document->setAttributes($_POST['Document']);
			$comment->setAttributes($_POST['Comment']);
			
			if ($model->document->save()) {
				if ($model->save()) {
					if(!empty($comment->comment_detail))
					{ 
						$comment->user_id=Yii::app()->user->id;
						$comment->comment_time=date('Y-m-d H:i:s');
						$comment->document_id=$model->document->id;
						$comment->save();
					}
					if($model->fee_id!==$fee_id && !empty($model->fee_id))
					{
						$fee=Fee::model()->findByPK($model->fee_id);
						if(!empty($fee_id))
						{
							$caisse=Caisse::model()->findByAttributes(array('inc_document_id'=>$model->document_id));	
						}else{
							$caisse=new Caisse;
						}
						$caisse->inc_document_id=$model->document_id;
				    	$caisse->amount_to_budget=$fee->amount_to_budget;
				    	$caisse->amount_to_department=$fee->amount_to_department;
				    	$caisse->create_date=date('Y-m-d H:i:s');
				    	$caisse->user_id=Yii::app()->user->id;
				    	$caisse->save();
					}elseif(empty($model->fee_id)){
						Caisse::model()->deleteAllByAttributes(array('inc_document_id'=>$model->document_id));
					}
						$this->redirect(array('view', 'id' => $model->document_id));
						/*if($model->document->document_type_id==Yii::app()->params->IsAppMining)
					    {
					    	$this->redirect(array('appform/applicationForm/createMining','docid'=>$model->document_id));
					    }elseif($model->document->document_type_id==Yii::app()->params->IsAppElectricity){
					    	$this->redirect(array('appform/applicationForm/createElectric','docid'=>$model->document_id));
					    }elseif($model->document->document_type_id==Yii::app()->params->IsAppGeneral){
					    	$this->redirect(array('appform/applicationForm/createGeneral','docid'=>$model->document_id));
					    }elseif($model->document->document_type_id==Yii::app()->params->IsAppReOffice){
					    	$this->redirect(array('appform/applicationForm/createRepOffice','docid'=>$model->document_id));
					    }else{
					    	$this->redirect(array('view','id'=>$model->document_id));
					    }*/
					
				}
			}
		}

		$this->render('update', array(
				'model' => $model,
				'comment'=>$comment,
				));
	}

	public function actionDelete($id) {
		if (Yii::app()->getRequest()->getIsPostRequest()) {
			$this->loadModel($id, 'IncDocument')->delete();

			if (!Yii::app()->getRequest()->getIsAjaxRequest())
				$this->redirect(array('admin'));
		} else
			throw new CHttpException(400, Yii::t('app', 'Your request is invalid.'));
	}
	
	/*public function actionDeletecomment($id,$document_id) {
			$delcontent=Comment::model()->findByPK($id)->delete(false);
			 //Comment::model()->Listcomment($document_id);
			//echo $this->renderPartial('listcomments',array('document_id'=>$document_id),true);
			 $this->renderPartial('listcomments', array('document_id'=>$document_id,false,false));
			
	}*/

	public function actionIndex() {
		
		// clean session AppForm
		Yii::app()->session->add('eappform', NULL);
	    Yii::app()->session->add('electric', NULL);
	    Yii::app()->session->add('mining', NULL);
	    Yii::app()->session->add('general', NULL);
	    Yii::app()->session->add('repoffice', NULL);
	    
	    $model = new IncDocument('search');
	    $model->unsetAttributes();
	    
	    if (isset($_GET['IncDocument'])) 
	        $model->setAttributes($_GET['IncDocument']);
	    
	    $this->render('index', array(
	        'model'=>$model,
	    ));
	}

	public function actionAdmin() {
		$model = new IncDocument('search');
		$model->unsetAttributes();

		if (isset($_GET['IncDocument']))
			$model->setAttributes($_GET['IncDocument']);

		$this->render('admin', array(
			'model' => $model,
		));
	}
	
	public function actionLoadType()
	{
	    $result = CHtml::tag('option',array('value'=>''),CHtml::encode(Yii::t('app', '--Please select--')),true);
	    $roots=DocumentType::model()->findAll(
			'type_level_id='
            .(int)$_POST['TypeLevel']['id']
        );
        
	    foreach ($roots as $root)
	    {
	        $result .= CHtml::tag('option',
	            array('value'=>$root->id),
                CHtml::encode($root->description),
	            true
	        );
	    }
	    echo $result;
	}
	
	/**
	 * 
	 * List all Document to select related document
	 */
	public function actionListdocuments(){
		$documents = new Document('search');
		$documents->unsetAttributes();
		
		$myCriteria = new CDbCriteria;
		
		$options = Yii::app()->request->getParam('docOptions');
		switch($options)
		{
			case 'Incoming':
					$myCriteria->join="INNER JOIN user on user.id=t.created_by INNER JOIN user_profile on user_profile.user_id=user.id";
					$myCriteria->addCondition("
						organization_id=".UserProfile::model()->findByPk(Yii::app()->user->id)->organization_id.
						" and in_or_out='INC'"
					);break;
			case 'Outgoing':
					$myCriteria->join="INNER JOIN user on user.id=t.created_by INNER JOIN user_profile on user_profile.user_id=user.id";
					$myCriteria->addCondition("
						organization_id=".UserProfile::model()->findByPk(Yii::app()->user->id)->organization_id.
						" and in_or_out='Out'"
					);break;
					
			case 'Other': // get document not yet related
					$myCriteria->join="INNER JOIN document_receiver on document_receiver.out_document_id=t.id and to_organization_id='".UserProfile::model()->findByPk(Yii::app()->user->id)->organization_id."'";
					$myCriteria->addCondition("t.id not in (select document_id from related_doc_organization where to_organization_id='".UserProfile::model()->findByPk(Yii::app()->user->id)->organization_id."')");
					break;
					
					
			/*case 'Other':
					$myCriteria = new CDbCriteria;
					$myCriteria->join="INNER JOIN document_receiver docreceiver on docreceiver.out_document_id=t.id";
					$myCriteria->addCondition("
						docreceiver.to_organization_id=".UserProfile::model()->findByPk(Yii::app()->user->id)->organization_id);
					break;*/
		}			
		
		
		if(Yii::app()->request->isAjaxRequest)
		{
			//$docID='';
			//$docID = Yii::app()->request->getParam('docID');
			if(Yii::app()->request->getParam('docID')!="")
			{
				$docID = Yii::app()->request->getParam('docID');
			}else{
				$docID='Null';
			}
		//	if(!$docID)
			if(isset($_GET['Document']))
				$documents->setAttributes($_GET['Document']);
				
			$providers =$documents->search($myCriteria);
			
			if($documents->document_date){
				if ($documents->document_date != '' && $documents->document_date != '0000-00-00')
			    {
			        $documents->document_date = date('d-m-Y',strtotime($documents->document_date));
			    }
			}
			
			$this->renderPartialWithHisOwnClientScript('_listdocuments',
				array('docID'=>$docID,
					'documents'=>$documents,
					'providers'=>$providers)
			); // good
		}
		return true;
	}
	
	public function actionselectDoc(){
		$docID = Yii::app()->request->getParam('id');
		$doc = Document::model()->findByPk($docID);
		if($doc){
			echo $doc->document_title;
			echo "<span id='docid' style='display:none'>";
			echo $doc->id;
			echo "</span>";
			echo "<span id='docno' style='display:none'>";
			echo ($doc->in_or_out=="INC")? $doc->incDocument->inc_document_no:$doc->outDocument->out_document_no;
			echo "</span>";
		}
	}
	public function actionDialog(){
	    $this->renderPartial('view');
	}
	
	public function actionViewDocument()
	{
		$docID = Yii::app()->request->getParam('id');
		$type = Yii::app()->request->getParam('inout');
		switch($type)
		{
			case 'INC':
				$this->redirect(Yii::app()->createUrl('inDocument/view',array('id'=>$docID)));
			case 'OUT':
				$this->redirect(Yii::app()->controller->createUrl('outDocument/view',array('id'=>$docID)));
		}
	}
	
	public function actionCloneDocument()
	{
		$docID = Yii::app()->request->getParam('out_document_id');
		$newInc = new IncDocument();
		$comment  = new Comment;
		
		if(isset($_POST['IncDocument']))
		{
			$connection = Yii::app()->db;
			$transaction = null;
			
			
			$newInc->attributes = $_POST['IncDocument'];
			$newInc->document->attributes = $_POST['Document'];
			$comment->attributes = $_POST['Comment'];
			$user = Yii::app()->session->get('user');
			$organization=$user->userProfile->organization;
			
			$newInc->status_date = date('d-m-Y');
			$newInc->to_organization_id = $organization->id;
			
			$newInc->document->document_date = date('d-m-Y');
			$newInc->document->created = date('Y-m-d H:i:s');
			$newInc->document->created_by = $user->id;
			$newInc->document->last_modified = $newInc->document->created;
			$newInc->document->last_modified_id = $user->id;
			$newInc->document->in_or_out = 'INC';
			 
//			$newInc->document->related_document_no = $_POST['Document']['related_document_no'];
			
			$transaction = $connection->beginTransaction();
				try {
				    
				    if (!$newInc->document->save())
				    throw new Exception('Cannot save Document');
				    
				    $newInc->document_id=$newInc->document->id;
				    
				    if (!$newInc->save())
				    throw new Exception('Cannot save Incoming Document');
				    
				    if(!empty( $comment->comment_detail))
				    {
				    	$comment->document_id=$newInc->document->id;
				    	$comment->user_id=$user->id;
						$comment->comment_time=date('Y-m-d H:i:s');
				   		if(!$comment->save())
				    	throw new Exception('Cannot save comments');
				    }
				    
				    $transaction->commit();
				    Yii::app()->user->setFlash('success', 'New document no. <strong>'.$newInc->document_no.'</strong> has been created successfully.');
				    $this->redirect(array('view','id'=>$newInc->document_id));
				} catch (Exception $e) {
				    $transaction->rollback();
				    Yii::app()->user->setFlash('error', '<strong>Error!</strong> Fix things up and submit again.');
				}
		}else{
			// Criteria to clone only document from others to our organization and not yet related
			$myCriteria = new CDbCriteria;
			$myCriteria->with =array("document.createdBy.userProfile");
			$myCriteria->addCondition("userProfile.organization_id !='".UserProfile::model()->findByPk(Yii::app()->user->id)->organization_id."'");
			$myCriteria->addCondition("document_id not in (select document_id from related_doc_organization where to_organization_id='".UserProfile::model()->findByPk(Yii::app()->user->id)->organization_id."')");
			$myCriteria->addCondition("document_id=$docID");
			 
			$outDoc = OutDocument::model()->find($myCriteria);
			if($outDoc)
			{    
				if($outDoc){
					$newInc = new IncDocument();
					
					$newInc->sender = $outDoc->document->createdBy->userProfile->first_name;
					$newInc->sender_ref = $outDoc->out_document_no;
					$newInc->from_organization_id = $outDoc->document->createdBy->userProfile->organization_id;
					$newInc->to_organization_id = UserProfile::model()->findByPk(Yii::app()->user->id)->organization_id;
					$newInc->document->attributes = $outDoc->document->attributes;
					$newInc->document->related_document_id = $outDoc->document->id; 
					$newInc->document->related_document_no = $outDoc->out_document_no;
				}
				
			}else{
				if(Yii::app()->request->urlReferrer!="")
					$this->redirect(Yii::app()->request->urlReferrer);
				else
					$this->redirect(Yii::app()->createUrl("/site/index"));
			}
		}
		
		$this->render('create', array( 
					'model' => $newInc,
					'comment' => $comment
			));
		
	}
	
	/**
	 * 
	 * Enter description here ...
	 */
	public function actionDropdowndocumenttype()
		{
			
			if($_POST['document_type_id']=='No')
			{
                /*
				$data=DocumentType::model()->findAll('id='.Yii::app()->params->Isapplication_id.'');
				$data=CHtml::listData($data,'id','description');
                foreach($data as $value=>$name)
                {
                	echo CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);
                }*/
                
				$data=DocumentType::model()->getDropDownListNotApplication(NULL,1,Yii::app()->params->Isapplication_id);
				$data=CHtml::listData($data,'id','description');
                foreach($data as $value=>$name)
                {
                //if($value!=2)
                 echo CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);
                }
			}
			
			if($_POST['document_type_id']=='Yes')
			{	
				$data=DocumentType::model()->getDropDownListApplication(NULL,1,Yii::app()->params->Isapplication_id);
				$data=CHtml::listData($data,'id','description');
                foreach($data as $value=>$name)
                {
                //if($value!=2)
                 echo CHtml::tag('option',array('value'=>$value),CHtml::encode($name),true);
                }
			}
		}
	public function actionStatusChange()
	{
		$model=IncDocument::model()->findByPK(yii::app()->request->getParam('pk'));
		$model->document_status_id=yii::app()->request->getParam('value');

		$model->document=Document::model()->findByPK(yii::app()->request->getParam('pk'));
		if($model->document->save())
		{
			$model->save();
		}
		return true;
	}
	
	public function actionCheckApptype($indocID,$doctypeID)
	{
		$idApp=Yii::app()->db->createCommand("SELECT id FROM appform_application_form where inc_document_id=".(int)$indocID."")->queryScalar();
		if($doctypeID==Yii::app()->params->IsAppMining)
		{
			if(empty($idApp))
				$this->redirect(array('appform/applicationForm/createMining','docid'=>$indocID));
			else 
				$this->redirect(array('appform/applicationForm/update','id'=>$idApp));
		}elseif($doctypeID==Yii::app()->params->IsAppElectricity){
			if(empty($idApp))
				$this->redirect(array('appform/applicationForm/createElectric','docid'=>$indocID));
			else 
				$this->redirect(array('appform/applicationForm/update','id'=>$idApp));
		}elseif($doctypeID==Yii::app()->params->IsAppGeneral ||
				$doctypeID==Yii::app()->params->IsAppGeneral1 ||
			    $doctypeID==Yii::app()->params->IsAppGeneral2 ||
			    $doctypeID==Yii::app()->params->IsAppGeneral3 ||
			    $doctypeID==Yii::app()->params->IsAppGeneral4 ||
			    $doctypeID==Yii::app()->params->IsAppGeneral5
		){
			if(empty($idApp))
				$this->redirect(array('appform/applicationForm/createGeneral','docid'=>$indocID));
			else 
				$this->redirect(array('appform/applicationForm/update','id'=>$idApp));
		}elseif($doctypeID==Yii::app()->params->IsAppReOffice){
			if(empty($idApp))
				$this->redirect(array('appform/applicationForm/createRepOffice','docid'=>$indocID));
			else 
				$this->redirect(array('appform/applicationForm/update','id'=>$idApp));
		}
	}
}