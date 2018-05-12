<?php
$this->layout="column1";
/*$this->breadcrumbs=array(
	'Out Documents'=>array('index'),
	$model->document_id=>array('view','id'=>$model->document_id),
	'Update',
);*/

$this->menu=array(
	array('label'=>'List OutDocument','url'=>array('index')),
	array('label'=>'Create OutDocument','url'=>array('create')),
	array('label'=>'View OutDocument','url'=>array('view','id'=>$model->document_id)),
	array('label'=>'Manage OutDocument','url'=>array('admin')),
);
?>
<?php $this->beginWidget('bootstrap.widgets.TbBox', array(
    'title' => Yii::t('app','Update Outgoing Document'),
    'headerIcon' => 'icon-edit',
    ));
?>
	<?php if(Yii::app()->user->hasFlash('error')):?>
	    <div class="info">
	        <?php echo Yii::app()->user->getFlash('error'); ?>
	    </div>
	<?php endif; ?>
	
	<?php echo $this->renderPartial('_form',array(
					'model'=>$model,
					'comment'=>$comment,
					'receiver' => $receiver
				)); ?>
<?php $this->endWidget(); ?>