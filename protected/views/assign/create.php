<?php
$this->layout='NULL';
$this->breadcrumbs=array(
	'Assigns'=>array('index'),
	'Create',
);
?>
<?php echo $this->renderPartial('_form', array('model'=>$model,'myuserorganization'=>$myuserorganization,'select'=>$select,'docid'=>(int)$_GET['docid'])); ?>