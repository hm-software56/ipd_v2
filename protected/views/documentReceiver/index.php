<?php
$this->breadcrumbs=array(
	'Document Receivers',
);

$this->menu=array(
	array('label'=>'Create DocumentReceiver','url'=>array('create')),
	array('label'=>'Manage DocumentReceiver','url'=>array('admin')),
);
?>

<h1>Document Receivers</h1>

<?php $this->widget('bootstrap.widgets.TbListView',array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
)); ?>
