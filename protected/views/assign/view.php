<?php
$this->breadcrumbs=array(
	'Assigns'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List Assign','url'=>array('index')),
	array('label'=>'Create Assign','url'=>array('create')),
	array('label'=>'Update Assign','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete Assign','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Assign','url'=>array('admin')),
);
?>

<h1>View Assign #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'inc_document_document_id',
		'user_id',
	),
)); ?>
