<?php
$this->layout="column1";
/*$this->breadcrumbs=array(
	'Inc Documents'=>array('index'),
	$model->document_id=>array('view','id'=>$model->document_id),
	'Update',
);*/

$this->menu=array(
	array('label'=>'List IncDocument','url'=>array('index')),
	array('label'=>'Create IncDocument','url'=>array('create')),
	array('label'=>'View IncDocument','url'=>array('view','id'=>$model->document_id)),
	array('label'=>'Manage IncDocument','url'=>array('admin')),
);
?>
<?php $this->beginWidget('bootstrap.widgets.TbBox', array(
    'title' => Yii::t('app','Update Incomming Document'),
    'headerIcon' => 'icon-edit',
    ));
?>
	<?php echo $this->renderPartial('_form',array('model'=>$model, 'comment'=>$comment)); ?>
<?php $this->endWidget(); ?>