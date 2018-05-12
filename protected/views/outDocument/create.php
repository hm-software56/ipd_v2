<?php
//Yii::app()->clientScript->scriptMap['jquery.ba-bbq.js'] = true;
//Yii::app()->clientScript->scriptMap['jquery.yiigridview.js'] = true;
$this->layout="column1";
/*$this->breadcrumbs=array(
	'Out Documents'=>array('index'),
	'Create',
);*/

$this->menu=array(
	array('label'=>'List OutDocument','url'=>array('index')),
	array('label'=>'Manage OutDocument','url'=>array('admin')),
);
?>
<?php $this->beginWidget('bootstrap.widgets.TbBox', array(
    'title' => Yii::t('app','New Outgoing Document'),
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
						'receiver'=>$receiver)
				); ?>
			
<?php $this->endWidget(); ?>
