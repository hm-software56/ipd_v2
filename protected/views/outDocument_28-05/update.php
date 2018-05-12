<?php
$this->breadcrumbs=array(
	'Out Documents'=>array('index'),
	$model->document_id=>array('view','id'=>$model->document_id),
	'Update',
);

$this->menu=array(
	array('label'=>'List OutDocument','url'=>array('index')),
	array('label'=>'Create OutDocument','url'=>array('create')),
	array('label'=>'View OutDocument','url'=>array('view','id'=>$model->document_id)),
	array('label'=>'Manage OutDocument','url'=>array('admin')),
);
?>

<?php if(Yii::app()->user->hasFlash('error')):?>
    <div class="info">
        <?php echo Yii::app()->user->getFlash('error'); ?>
    </div>
<?php endif; ?>

<h1>Update OutDocument <?php echo $model->document_id; ?></h1>

<?php echo $this->renderPartial('_form',array('model'=>$model,'receiver' => $receiver)); ?>