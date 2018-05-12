<?php
$this->breadcrumbs=array(
	'Document Receivers'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List DocumentReceiver','url'=>array('index')),
	array('label'=>'Manage DocumentReceiver','url'=>array('admin')),
);
?>

<h1>Create DocumentReceiver</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>