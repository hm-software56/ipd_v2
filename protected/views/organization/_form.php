<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
	'id'=>'organization-form',
	'enableAjaxValidation'=>false,
)); ?>
	<p class="help-block"><?php echo Yii::t('app','Fields with')?> <span class="required">*</span> <?php echo Yii::t('app','are required')?>.</p>

	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->hiddenField($model, 'parent_id',array('value'=>!empty($_GET['parent'])? $_GET['parent']: $model->parent_id , 'readonly'=>true)); ?>
	<?php 
	if($model->parent_id!=NULL)
	{
		echo $form->labelEx($model,'parent_id');
		echo CHtml::textField('Parent',Organization::model()->findByPK($model->parent_id)->organization_name,array('readonly'=>true)); 
	}
	elseif(isset($_GET['parent']))
	{
		echo $form->labelEx($model,'parent_id');
		echo CHtml::textField('Parent',Organization::model()->findByPK((int)$_GET['parent'])->organization_name,array('readonly'=>true)); 
	}
	?>
	<?php echo $form->dropDownListRow($model,'region_id',
	    CHtml::listData(Region::model()->findAll(), 'id', 'region_name'),
	    array(
	        'empty'=>Yii::t('app','--Please select--'),
	        'options'=>array($model->region_id=>array('selected'=>'selected')),
	        'class'=>'span3',
	    )
	); ?>
	<?php echo $form->textFieldRow($model,'organization_name',array('class'=>'span4','maxlength'=>255)); ?>

	<?php echo $form->textFieldRow($model,'organization_code',array('class'=>'span4','maxlength'=>50)); ?>

	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Save',
		)); ?>
	</div>

<?php $this->endWidget(); ?>
