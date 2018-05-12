<?php
$this->breadcrumbs=array(
	'Document Receivers'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List DocumentReceiver','url'=>array('index')),
	array('label'=>'Create DocumentReceiver','url'=>array('create')),
	array('label'=>'Update DocumentReceiver','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete DocumentReceiver','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage DocumentReceiver','url'=>array('admin')),
);
?>

<h1>View DocumentReceiver #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'out_document_id',
		'to_organization_id',
		'document_status_id',
		'status_date',
		'receiver_name',
	),
)); ?>
