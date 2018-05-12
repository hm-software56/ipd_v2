<?php
//Yii::app()->clientScript->scriptMap['jquery.ba-bbq.js'] = true;
//Yii::app()->clientScript->scriptMap['jquery.yiigridview.js'] = true;
$this->breadcrumbs=array(
	'Out Documents'=>array('index'),
	'Create',
);

$this->menu=array(
	array('label'=>'List OutDocument','url'=>array('index')),
	array('label'=>'Manage OutDocument','url'=>array('admin')),
);
?>

<h1>Create OutDocument</h1>

<?php if(Yii::app()->user->hasFlash('error')):?>
    <div class="info">
        <?php echo Yii::app()->user->getFlash('error'); ?>
    </div>
<?php endif; ?>

<?php echo $this->renderPartial('_form', array('model'=>$model,'receiver'=>$receiver)); ?>
