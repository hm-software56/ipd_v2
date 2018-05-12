<?php
$this->layout="column1";
/*$this->breadcrumbs=array(
	'Inc Documents'=>array('index'),
	'Create',
);*/

$this->menu=array(
	array('label'=>'List IncDocument','url'=>array('index')),
	array('label'=>'Manage IncDocument','url'=>array('admin')),
);

Yii::app()->clientScript->registerScript(
   'myHideEffect',
   '$(".info").animate({opacity: 1.0}, 3000).fadeOut("slow");',
   CClientScript::POS_READY
);
?>
<?php $this->beginWidget('bootstrap.widgets.TbBox', array(
    'title' => Yii::t('app','New Incomming Document'),
    'headerIcon' => 'icon-edit',
    ));
?>
	<?php if(Yii::app()->user->hasFlash('error')):?>
	    <div class="info">
	        <?php echo Yii::app()->user->getFlash('error'); ?>
	    </div>
	<?php endif; ?>
	
	<?php $this->widget('bootstrap.widgets.TbAlert', array(
	        'block'=>true, // display a larger alert block?
	        'fade'=>true, // use transitions?
	        'closeText'=>'x', // close link text - if set to false, no close link is displayed
	        'alerts'=>array( // configurations per alert type
	            'error'=>array('block'=>true, 'fade'=>true, 'closeText'=>'x'), // success, info, warning, error or danger
	        ),
	    )); ?>
	    
	<?php echo $this->renderPartial('_form', array('model'=>$model,'comment' => $comment)); ?>
<?php $this->endWidget(); ?>