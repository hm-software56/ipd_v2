<?php
$this->breadcrumbs=array(
	'Document Statuses'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List DocumentStatus','url'=>array('index')),
	array('label'=>'Create DocumentStatus','url'=>array('create')),
	array('label'=>'Update DocumentStatus','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete DocumentStatus','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage DocumentStatus','url'=>array('admin')),
);
?>

<h1>View DocumentStatus #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'status_description',
		'status_type',
	),
)); ?>
