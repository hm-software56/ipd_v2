<?php
$this->breadcrumbs=array(
	'Attach Files'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List AttachFile','url'=>array('index')),
	array('label'=>'Create AttachFile','url'=>array('create')),
	array('label'=>'Update AttachFile','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete AttachFile','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage AttachFile','url'=>array('admin')),
);
?>

<h1>View AttachFile #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'document_id',
		'file_name',
	),
)); ?>
