<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'assign-form',
	'enableAjaxValidation'=>false,
)); ?>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->hiddenField($model,'inc_document_document_id',array('value'=>$docid)); ?>
	<?php echo CHtml::checkBoxList("user_id", $select, $myuserorganization, array('labelOptions'=>array('style'=>'display:inline;font-weight:normal'))); ?> 
	
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
