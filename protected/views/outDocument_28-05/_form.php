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

<?php 
	$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'out-document-form',
	'enableAjaxValidation'=>false,
)); ?>
	
	<p class="help-block">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model->document,'document_title'); ?>
	
<?php 	echo CHtml::activeHiddenField($model->document,'related_document_id');?>
<?php // 	echo $form->uneditableRow($model->document,'related_document_no');

/*		$this->widget('bootstrap.widgets.TbButton', array(
		    'label'=>'Choose a Related document',
		    'type'=>'primary',
			'buttonType'=>'ajaxButton',
			'url'=>Yii::app()->createURL('outDocument/listdocuments'),
			'ajaxOptions'=>array(
				"data"=>array("docID"=>"js:$(\"#Document_related_document_id\").val()"),
				'success'=>'function(data){
					$(".modal-body").html(data);
					$("#myModal").modal("show");
				}'
			)
		));
*/
?>		
	<div class="btn-toolbar">
	<?php 	echo $form->uneditableRow($model->document,'related_document_no',array('id'=>'Document_related_document_no'));?> 
    <?php $this->widget('bootstrap.widgets.TbButtonGroup', array(
        'type'=>'primary', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
    	'size'=>'large',
        'buttons'=>array(
            array('label'=>'Related Document','style'=>"display:''"),
            array('items'=>array(
                array('label'=>Yii::t('app','Incoming Docs'), 'url'=>'#',
                		'linkOptions'=>array(
                		'ajax'=>array(
							'url'=>Yii::app()->createURL("outDocument/listdocuments",array('docOptions'=>'Incoming')),
                			//"data"=>array("docID"=>"js:$(\"#Document_related_document_id\").val()"),
                			"data"=>array("docID"=>$model->document_id),
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
							'url'=>Yii::app()->createURL("outDocument/listdocuments",array('docOptions'=>'Outgoing')),
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
							'url'=>Yii::app()->createURL("outDocument/listdocuments",array('docOptions'=>'Other')),
                			'type'=>'POST',
							'success'=>'function(data){
								$(".modal-body").html(data);
								$("#myModal").modal("show");
								return false;
							}'
						)) 
                ),
                '---',
                array('label'=>'Unlink Document','url'=>'#',
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
		

	<?php echo $form->dropDownListRow($model->document,'document_type_id',
	    CHtml::listData(DocumentType::getDropDownList(), 'id', 'description'),
	    array(
	        'options'=>array($model->document->document_type_id=>array('selected'=>'selected')),
	        'empty'=>Yii::t('app','--Please select--'),
	    )
	);?>
	
	<?php echo $form->textAreaRow($model->document, 'detail', array('class'=>'span8', 'rows'=>5)); ?>
	
	<div id='receivers'>
		<?php echo $this->renderPartial('_receivers');?>
	</div>
	<?php  echo $this->renderPartial('_formdocreceiver',array('receiver'=>$receiver, 'form'=>$form))?>
	
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>

