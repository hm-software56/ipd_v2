<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'document-status-form',
	//'id'=>'horizontalForm',
	// 'type'=>'horizontal',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="help-block"><?php echo Yii::t('app','Fields with')?> <span class="required">*</span> <?php echo Yii::t('app','are required')?>.</p>

	<?php echo $form->errorSummary($model); ?>
	<div class="control-label">
		<?php echo $form->dropDownListRow($model,'status_type',
				Utils::enumItem($model, 'status_type'),
				array('maxlength'=>3)); 
		?>
	</div>
	<div class="control-label">
	<?php echo $form->textFieldRow($model,'status_description',array('maxlength'=>255)); ?>
	</div>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
