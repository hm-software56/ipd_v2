<?php
$this->breadcrumbs=array(
	'Attach Files'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List AttachFile','url'=>array('index')),
	array('label'=>'Create AttachFile','url'=>array('create')),
	array('label'=>'View AttachFile','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage AttachFile','url'=>array('admin')),
);
?>

<h1>Update AttachFile <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>