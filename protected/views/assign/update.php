<?php
$this->breadcrumbs=array(
	'Assigns'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Assign','url'=>array('index')),
	array('label'=>'Create Assign','url'=>array('create')),
	array('label'=>'View Assign','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage Assign','url'=>array('admin')),
);
?>

<h1>Update Assign <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>