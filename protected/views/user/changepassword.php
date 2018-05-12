<?php
$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'user-form',
	'action'=>Yii::app()->createUrl('/user/changepassword/'),
	'enableAjaxValidation'=>true,
)); ?>
<div class="row">
	<?php echo '<strong>'.Yii::t('app','password old').': </strong>'?>
	<?php echo $form->passwordField($model, 'password_old', array('maxlength' => 60)); ?>
	<?php echo $form->error($model,'password_old'); ?>
	<?php echo '<span style="color:red" >'.Yii::app()->user->getFlash('error').'</span>'; ?>
</div>

<div class="row">
	<?php echo '<strong>'.Yii::t('app','password new').': </strong>'?>
	<?php echo $form->passwordField($model, 'password_new', array('maxlength' => 60)); ?>
	<?php echo $form->error($model,'password_new'); ?>
	<?php echo '<span style="color:red" >'.Yii::app()->user->getFlash('empty').'</span>'; ?>
</div>
<?php echo $form->hiddenField($model, 'password', array('maxlength' => 60)); ?>
<div class="form-actions">
	<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
	)); ?>
</div>
</div>
<?php $this->endWidget(); ?>
