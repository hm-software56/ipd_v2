<?php
$this->breadcrumbs=array(
	'Document Receivers'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List DocumentReceiver','url'=>array('index')),
	array('label'=>'Create DocumentReceiver','url'=>array('create')),
	array('label'=>'View DocumentReceiver','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage DocumentReceiver','url'=>array('admin')),
);
?>

<h1>Update DocumentReceiver <?php echo $model->id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>