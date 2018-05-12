<?php
$this->layout="column1";
$this->breadcrumbs=array(
	'Fees'=>array('index'),
	$model->id=>array('view','id'=>$model->id),
	'Update',
);

	$this->menu=array(
	array('label'=>'List Fee','url'=>array('index')),
	array('label'=>'Create Fee','url'=>array('create')),
	array('label'=>'View Fee','url'=>array('view','id'=>$model->id)),
	array('label'=>'Manage Fee','url'=>array('admin')),
	);
	?>
<?php $this->beginWidget('bootstrap.widgets.TbBox', array(
    'title' => Yii::t('app','Fees'),
    'headerIcon' => 'icon-edit',
    ));
?>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>
<?php $this->endWidget(); ?>