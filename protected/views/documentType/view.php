<?php
$this->breadcrumbs=array(
	'Document Types'=>array('index'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List DocumentType','url'=>array('index')),
	array('label'=>'Create DocumentType','url'=>array('create')),
	array('label'=>'Update DocumentType','url'=>array('update','id'=>$model->id)),
	array('label'=>'Delete DocumentType','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage DocumentType','url'=>array('admin')),
);
?>

<h1>View DocumentType #<?php echo $model->id; ?></h1>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'id',
		'description',
		'type_level_id',
		'parent_id',
	),
)); ?>
