<?php $this->layout='NULL';?>
<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'user-form',
	'enableAjaxValidation'=>true,
)); ?>

	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>

	<?php echo $form->errorSummary(array($model)); ?>

		<div class="row">
			<div class="span2">
				<?php echo $form->labelEx($model,'username'); ?>
			</div>
			<div class="span3">
				<?php echo $form->textField($model, 'username', array('maxlength' => 45)); ?>
			</div>
			<div class="span2">
				<?php echo $form->error($model,'username'); ?>
			</div>
		</div><!-- row -->
		
		<div class="row">
			<div class="span2">
				<?php echo $form->labelEx($model,'password'); ?>
			</div>
			<div class="span3">
				<?php echo $form->passwordField($model, 'password', array('maxlength' => 60)); ?>
			</div>
			<div class="span2">
				<?php echo $form->error($model,'password'); ?>
			</div>
		</div><!-- row -->
		
		
	<div class="span4">
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>
	</div>
<?php $this->endWidget(); ?>
