<?php
class AdvancedSearchWidget extends CWidget
{
	public $type_form;
	
	public function run(){
		$this->renderContent();
	}
	
	protected function renderContent()
	{
		$model=new AdvancedSearch;
		$document = new Document('search');
		$document->unsetAttributes();
		$provider = NULL;
		$myCriteria = new CDbCriteria;
		
		
		
	    // uncomment the following code to enable ajax-based validation
	    /*
	    if(isset($_POST['ajax']) && $_POST['ajax']==='advanced-search-advancedsearch-form')
	    {
	        echo CActiveForm::validate($model);
	        Yii::app()->end();
	    }
	    */
	
	    if(isset($_POST['AdvancedSearch']))
	    {
	        $model->attributes=$_POST['AdvancedSearch'];
	        
	        if($model->validate())
	        {
	        	if($model->document_title!="")
	        	{
	        		$myCriteria->addCondition("document_title LIKE '%$model->document_title%'",true);
	        	}
	        	if($model->in_or_out=="INC")
	        	{
	        		$myCriteria->with=array('incDocument.documentStatus');
	        		
	        		$myCriteria->addCondition("in_or_out='$model->in_or_out'");
	        		
	        		// from the sender of inc_document
	        		if($model->from_organization_id!="")
	        			$myCriteria->addCondition("from_organization_id=$model->from_organization_id");
	        		// to of inc_document
	        		if($model->to_organization_id!="")
	        			$myCriteria->addCondition("to_organization_id=$model->to_organization_id");
	        			
	        	}elseif($model->in_or_out=="OUT"){
	        		//$myCriteria->with=array('createdBy.userProfile','outDocument.documentReceivers'=>array('alias'=>'documentReceivers'));
	        		$myCriteria->with=array('createdBy.userProfile');

	        		$myCriteria->join="Left outer join document_receiver documentReceivers on documentReceivers.out_document_id=t.id";
	        		
	        		$myCriteria->addCondition("in_or_out='$model->in_or_out'");
	        		
	        		// the creator
	        		if($model->from_organization_id!="")
	        			$myCriteria->addCondition("organization_id=$model->from_organization_id");
	        		// the receiver org
	        		if($model->to_organization_id!="")
	        			$myCriteria->addCondition("documentReceivers.to_organization_id=$model->to_organization_id");
	        	}else{
	        		$myCriteria->with=array(
	        				'incDocument.documentStatus',
	        				'outDocument.documentReceivers.documentStatus'=>array('alias'=>'documentStatusReceiver'));
	        	}
	        	if($model->from_date!="" && $model->to_date!="")
	        	{
	        		$f = date('Y-m-d',strtotime($model->from_date));
	        		$t = date('Y-m-d',strtotime($model->to_date));
	        		$myCriteria->addBetweenCondition("document_date",$f,$t);
	        	}else{
	        		if($model->from_date!=""){
	        			$f = date('Y-m-d',strtotime($model->from_date));
	        			$myCriteria->addCondition("document_date>='$f'");
	        		}	
		        	if($model->to_date!=""){
		        		$t = date('Y-m-d',strtotime($model->to_date));
		        		$myCriteria->addCondition("document_date<='$t'");
		        	}
	        	}
	        	
		        if($model->document_type_id!=""){
		        	$myCriteria->addCondition("document_type_id=$model->document_type_id");
		        }
		        if($model->document_status_id!=""){
		        	if($model->in_or_out=="INC"){
		        		$myCriteria->addCondition("incDocument.document_status_id=$model->document_status_id");
		        	}elseif($model->in_or_out=="OUT"){
		        		$myCriteria->addCondition("documentReceivers.document_status_id=$model->document_status_id");
		        	}else{
		        		$myCriteria->addCondition("incDocument.document_status_id=$model->document_status_id","OR");
		        		$myCriteria->addCondition("documentStatusReceiver.document_status_id=$model->document_status_id","OR");
		        		//$myCriteria->addCondition("documentStatusReceiver.document_status_id=$model->document_status_id","OR");
		        	}
		        }
		        	
//	        	$provider= $document->search($myCriteria);
				if($model->in_or_out=="")
				{
					//$myCriteria->mergeWith(Document::model()->doc_of_my_organization()->getDbCriteria());
					$myCriteria->scopes='doc_of_my_organization';
				}elseif ($model->in_or_out=="INC"){
					//$myCriteria->mergeWith(Document::model()->indoc_of_me()->getDbCriteria());
					$myCriteria->scopes='indoc_of_me';
				}else{
					//$myCriteria->mergeWith(Document::model()->outdoc_of_me()->getDbCriteria());
					$myCriteria->scopes='outdoc_of_me';
				}
	        	
			//	print_r($myCriteria);exit;
				
				Yii::app()->session->add('searchDoc',$myCriteria);
				
				$provider =	new CActiveDataProvider($document, array(
					'criteria' => $myCriteria,
					'sort'=>array(
				        'attributes'=>array(
				            'document_title'=>array(
				                'asc'=>'document_title',
				                'desc'=>'document_title DESC',
				            ),
				            'document_date'=>array(
				                'asc'=>'document_date',
				                'desc'=>'document_date DESC',
				            ),
				            'document_type'=>array(
				                'asc'=>'documentType.description',
				                'desc'=>'documentType.description DESC',
				            ),
				            '*',
				        ),
				        'defaultOrder'=>'t.id DESC',
				    ),
				    'pagination'=>array(
				        'pageSize'=>10,
				    )
				   // 'pagination' => $pagination
				));
				
	        }
	    }
	    
		if(Yii::app()->request->isAjaxRequest)
	    {
	    	if(Yii::app()->session->get('searchDoc')!=NULL)
	    		$myCriteria = Yii::app()->session->get('searchDoc');
	    	
	    	$provider =	new CActiveDataProvider($document, array(
					'criteria' => $myCriteria,
					'sort'=>array(
				        'attributes'=>array(
				            'document_title'=>array(
				                'asc'=>'document_title',
				                'desc'=>'document_title DESC',
				            ),
				            'document_date'=>array(
				                'asc'=>'document_date',
				                'desc'=>'document_date DESC',
				            ),
				            'document_type'=>array(
				                'asc'=>'documentType.description',
				                'desc'=>'documentType.description DESC',
				            ),
				            '*',
				        ),
				        'defaultOrder'=>'t.id DESC',
				    ),
				    'pagination'=>array(
				        'pageSize'=>10,
				    )
				   // 'pagination' => $pagination
				));
	    		
	    }
	    
	    
	    switch($this->type_form)
	    {
	    	case 'INC':
	    		$this->render('advancedsearch_inc',
	    			array(
	    				'model'=>$model,
	    				'type_form'=>$this->type_form,
	    				'provider'=>$provider
	    			));
	    		break;
	    	default:$this->render('advancedsearch_out',array('model'=>$model,'type_form'=>$this->type_form));	
	    }
	    
	} 
}