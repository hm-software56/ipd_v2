<?php 
$this->beginWidget('bootstrap.widgets.TbModal', array('htmlOptions'=>array('id'=>'myModal','style'=>'width:800px'))); ?>
 
<div class="modal-header">
    <a class="close" data-dismiss="modal">&times;</a>
    <h4>Select a related document</h4>
</div>
 
<div class="modal-body">
    <p>One fine body...</p>
</div>
 
<div class="modal-footer">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
        'type'=>'primary',
        'label'=>'Save changes',
        'url'=>'#',
        'htmlOptions'=>array('data-dismiss'=>'modal',
        	'onClick'=>"js:$(\"#Document_related_document_no\").html($(\"#docno\").html());
        				$(\"#Document_related_document_id\").val($(\"#docid\").html());
        "),
    )); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'label'=>'Close',
        'url'=>'#',
        'htmlOptions'=>array('data-dismiss'=>'modal'),
    )); ?>	
</div>
 
<?php $this->endWidget(); ?>


<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'inc-document-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block"><?php echo Yii::t('app','Fields with')?> <span class="required">*</span> <?php echo Yii::t('app','are required')?>.</p>

	<?php echo $form->errorSummary($model); ?>
	
    <?php
	if(Yii::app()->user->checkAccess('SingleWindow'))
	{
	    echo $form->dropDownListRow($model,'is_application',
	            Utils::enumItem($model, 'is_application'),
	            array(
	                  'prompt' => '--Please Select --',
	                  'ajax'  => array(
	                  'type'  => 'POST',
	                  'url' => CController::createUrl('inDocument/Dropdowndocumenttype'),
	                  'update' => '#Document_document_type_id',   //selector to update value 
	                  'data' => array('document_type_id'=>'js:this.value'),
	                  ),
	                  'class'=>'span5'
	                  )
	        );
	     echo $form->dropDownListRow($model->document,'document_type_id', array(''.$model->document->document_type_id.''=>empty($model->is_application)?"":($model->document->documentType)?$model->document->documentType->description:""),array('class'=>'span5'));   
	}
	elseif(Yii::app()->user->checkAccess('Staff')&& !isset($_GET['out_document_id']))
	{
	    echo $form->dropDownListRow($model,'is_application',
	            //Utils::enumItem($model, 'is_application'),
	            array('No'=>'No'),
	            array(
	                  'prompt' => '--Please Select --',
	                  'ajax'  => array(
	                  'type'  => 'POST',
	                  'url' => CController::createUrl('inDocument/Dropdowndocumenttype'),
	                  'update' => '#Document_document_type_id',   //selector to update value 
	                  'data' => array('document_type_id'=>'js:this.value'),
	                  ),
	                  'class'=>'span5'
	                  )
	        );
	     echo $form->dropDownListRow($model->document,'document_type_id', array(''.$model->document->document_type_id.''=>empty($model->is_application)?"":($model->document->documentType)?$model->document->documentType->description:""),array('class'=>'span5'));   
	}
	else {
			 echo $form->dropDownListRow($model,'is_application',
			 	array('No'=>'No'),
	            array('class'=>'span5')
	            );
	        echo $form->dropDownListRow($model->document,'document_type_id',
	        			CHtml::listData(DocumentType::model()->findAll('id='.(int)$model->document->document_type_id.''), 'id', 'description'),
	        			array('class'=>'span5')
	        ); 
	}
	?>
	<?php 
	if(Yii::app()->user->checkAccess('SingleWindow'))
	{
		if(!empty($model->document_id) && !empty($model->fee_id))
		{
			$caisse=Caisse::model()->findByAttributes(array('inc_document_id'=>$model->document_id));
			if(!empty($caisse))
			{
				if($caisse->payment_status==1)
				{
					$fee=Fee::model()->findByPK($model->fee_id);
					echo '<div class="controls">'.Yii::t('app','Fee|Fees').'<br/>
	    					<div class="input-prepend ">
		      					<span class="add-on btn-primary"><i class="icon-ok icon-white "></i></span>
		      					<input type="text" value='.$fee->fee_description.' class="span5" disabled>
	    					</div>
	  					</div>';
						
				}else{
					echo $form->dropDownListRow($model,'fee_id',
						CHtml::listData(Fee::model()->findAll(), 'id','fee_description'),
						array('empty'=>Yii::t('app','--------------== No Fee ==---------------'), 'class'=>'span5')
		        );
				}
			}
		}else{
			echo $form->dropDownListRow($model,'fee_id',
					CHtml::listData(Fee::model()->findAll(), 'id','fee_description'),
					array('empty'=>Yii::t('app','--------------== No Fee ==---------------'), 'class'=>'span5')
	        );
		}
	}
    ?>
        
    <?php echo $form->textFieldRow($model,'sender',array('class'=>'span5')); ?>
    
	<?php echo $form->textFieldRow($model,'sender_contact',array('class'=>'span5')); ?>
	
	<?php echo $form->textFieldRow($model,'sender_ref',array('maxlength'=>30,'class'=>'span5')); ?>
	<?php echo $form->datepickerRow($model->document, 'document_date',array('class'=>'span5'));?>
	
	<?php echo $form->textFieldRow($model,'office_no',array('class'=>'span5')); ?>
	
	<?php echo $form->dropDownListRow($model,'document_status_id',
	    CHtml::listData(DocumentStatus::model()->findAll('status_type="INC"'), 
	    'id', 'status_description'),
	    array(
	        'class'=>'span5',
	        'options'=>array($model->document_status_id=>array('selected'=>'selected')),
	        'empty'=>Yii::t('app','--Please select--'),
	    )); ?>


	<?php echo $form->dropDownListRow($model,'from_organization_id',
	CHtml::listData(Organization::getList(), 'id', 'organization_name'),
	array(
	    'options'=>array($model->from_organization_id=>array('selected'=>'selected')),
	    'empty'=>Yii::t('app','--Please select--'),
		'class'=>'span5'
	)); ?>
	
	<?php echo $form->textFieldRow($model->document,'document_title',array('class'=>'span5')); ?>
	<?php echo $form->textAreaRow($model->document,'detail',array( 'rows'=>'5','class'=>'span5'));?>
	<?php 	echo CHtml::activeHiddenField($model->document,'related_document_id');?>
	
	<div class="btn-toolbar">
    <?php  echo $form->uneditableRow($model->document,'related_document_no',array('labelOptions'=>array('label'=>Yii::t('app','Related Document No')),'id'=>'Document_related_document_no'));?>
	<?php  //echo $form->uneditableRow(($model->document->relDocument)?$model->document->relDocument:$model->document,'related_document_no',array('id'=>'Document_related_document_no'));?>
	<?php $this->widget('bootstrap.widgets.TbButtonGroup', array(
        'type'=>'primary', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
    	'size'=>'medium',
        'buttons'=>array(
            array('label'=>Yii::t('app','Related Document'),'style'=>"display:''"),
            array('items'=>array(
                array('label'=>Yii::t('app','Incoming Docs'), 'url'=>'#',
                		'linkOptions'=>array(
                		'ajax'=>array(
							'url'=>Yii::app()->createURL("inDocument/listdocuments",array('docOptions'=>'Incoming')),
                			//"data"=>array("docID"=>"js:$(\"#Document_related_document_id\").val()"),
                			"data"=>array("docID"=>$model->document_id),
                			//'type'=>'POST',
                			'type'=>'GET',
							'success'=>'function(data){
								$(".modal-body").html(data);
								$("#myModal").modal("show");
								//return false;
							}'
						))
                	),
                array('label'=>Yii::t('app','Outgoing Docs'),'url'=>'#',
                		'linkOptions'=>array(
                		'ajax'=>array(
							'url'=>Yii::app()->createURL("inDocument/listdocuments",array('docOptions'=>'Outgoing')),
                			"data"=>array("docID"=>$model->document_id),
                			'type'=>'POST',
							'success'=>'function(data){
								$(".modal-body").html(data);
								$("#myModal").modal("show");
								return false;
							}'
						)) 
                ),
                array('label'=>Yii::t('app','Docs from Others'),'url'=>'#',
                		'linkOptions'=>array(
                		'ajax'=>array(
							'url'=>Yii::app()->createURL("inDocument/listdocuments",array('docOptions'=>'Other')),
                			"data"=>array("docID"=>$model->document_id),
                			'type'=>'POST',
							'success'=>'function(data){
								$(".modal-body").html(data);
								$("#myModal").modal("show");
								return false;
							}'
						)) 
                ),
                '---',
                array('label'=>Yii::t('app','Unlink Document'),'url'=>'#',
                		'linkOptions'=>array(
                		'ajax'=>array(
							'url'=>"#",
							'beforeSend'=>'function(data){
								$(".uneditable-input").html("");
                				$("#Document_related_document_id").val("");
                				//return false;
							}',
						)) 
                ),
            )),
        ),
    )); ?>
</div>
	<?php echo $form->textAreaRow($comment,'comment_detail',array( 'rows'=>'5','class'=>'span5'));?>
	<hr/>
	<?php 
	//echo $model->isNewRecord;
		if(empty($model->isNewRecord))
		Comment::model()->Listcomment($model->document->id)
	?>
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
