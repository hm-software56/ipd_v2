<?php
$this->layout='column1';
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('out-document-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
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
        	'onClick'=>"alert($('#DocumentReceiver_document_status_id option:selected').attr('value'));
        "),
    )); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'label'=>'Close',
        'url'=>'#',
        'htmlOptions'=>array('data-dismiss'=>'modal'),
    )); ?>	
</div>
 
<?php $this->endWidget(); ?>
<div align="right">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
	    'label'=>Yii::t('app','New Outgoing Document'),
	    'type'=>'info',
	    'url'=>array('create'),
	)); ?>
</div>
<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'out-document-grid',
	'dataProvider'=>$model->outdoc_of_me()->search(),
	'filter'=>$model,
	'summaryText' => Yii::t('app','Displaying {start}-{end} of {count} result(s)'),

	'columns'=>array(
		array(
            'name'=>'out_document_no',
            'header'=>Yii::t('app','Document #'),
        ),
        array(
        	'name'=>'document_title',
        	'header'=>Yii::t('app','Document Title'),	
        ),
        array(
            'name'=>'document_date',
            'header'=>Yii::t('app','Document Date'),
        	'filter'=>false
        ),
        array(
            'name'=>'document_type_id',
            'header'=>Yii::t('app','Document Type'),
        	'value'=>'$data->document->documentType->description',
        	'filter'=>CHtml::listData(DocumentType::model()->findAll(), 'id', 'description'),
        ),
        
        array(
            'name'=>'created',
            'header'=>Yii::t('app','Created'),
        	'value'=>'$data->document->created',
        ),
        
        array(
            'class'=>'CLinkColumn',
            //'label'=>'<img alt="" src="/images/clip.png">',
           // 'label'=>CHtml::image('/ipdtracking/images/clip.png'),
            'label'=>'<img alt="" src="'. Yii::app()->baseURL.'/images/clip.png">',
            'header'=>Yii::t('app','Attach file'),
        	'urlExpression'=>'Yii::app()->createUrl("attachFile/create",array("docid"=>$data->document_id))',
        ),
       array(
        	'name'=>'#',
        	'header'=>Yii::t('app','Send to'),
        	'type'=>'raw',
        	'value'=>'Yii::app()->getController()->getReceivers("$data->document_id")',
       		'filter'=>false
        ),
        array(
			'name'=>'#',
        	'header'=>Yii::t('app','DG'),
        	'type'=>'raw',
        	'value'=>'CommentToUser::getReadcomment("$data->document_id")',
		 	'filter'=>false,
		),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template'=>'{view} {update}',
		),
	),
)); ?>
