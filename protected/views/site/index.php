<?php 
$this->beginWidget('bootstrap.widgets.TbModal', array('htmlOptions'=>array('id'=>'myModal0','style'=>'width:800px'))); ?>
 
<div class="modal-header">
    <a class="close" data-dismiss="modal">&times;</a>
    <h4>Document Assign to User</h4>
</div>
 
<div class="modal-body0">
    <p>One fine body...</p>
</div>
<?php $this->endWidget(); ?>

<?php 
$this->beginWidget('bootstrap.widgets.TbModal', array('htmlOptions'=>array('id'=>'myModal','style'=>'width:800px'))); ?>
<div class="modal-header">
    <a class="close" data-dismiss="modal">&times;</a>
    <h4><?php echo Yii::t('app','Update Receiver Document')?></h4>
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
        	'onClick'=>"$.ajax({
        		type:'POST',
        		dataType: 'json',
        		update : 'out-document-grid',
        		url: '".Yii::app()->createUrl('/outDocument/updateStatus')."',
        		data: 'receiverid='+$(\"#DocumentReceiver_id\").val()+
        			  '&document_status_id='+$(\"#DocumentReceiver_document_status_id\").val()+
        			  '&docNo=".$docNo."'
        		,
        		success:function(data){
        			if(data.result == 'success')
        				$.fn.yiiGridView.update('out-document-grid');
        		}		
        	});
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
	if(Yii::app()->user->checkAccess("DG")){ 
		$this->renderPartial('_dg_grid_indoc',array('model'=>$model));
		$this->renderPartial('_dg_grid_outdoc',array('modelout'=>$modelout));
	//	$this->renderPartial('_dg_grid_doc_to_me',array('model_out_to_me'=>$model_out_to_me));
	}else{
		$this->renderPartial('_grid_indoc',array('model'=>$model));
		$this->renderPartial('_grid_outdoc',array('modelout'=>$modelout));
		$this->renderPartial('_grid_doc_to_me',array('model_out_to_me'=>$model_out_to_me));
	}
?>

