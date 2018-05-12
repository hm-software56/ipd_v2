<?php
/* @var $this AdvancedSearchController */
/* @var $model AdvancedSearch */
/* @var $form CActiveForm */
?>

<div class="form">

<?php 
$form=$this->beginWidget('bootstrap.widgets.TbActiveForm',array(
//$form=$this->beginWidget('CActiveForm', array(
	'id'=>'advanced-search-advancedsearch-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php echo $form->errorSummary($model); ?>

<div class="row-fluide">
	<div class="span12">
		<div class="span3">	
		<?php echo $form->textFieldRow($model,'title'); ?>
		</div>
		<div class="span3">
		<?php echo $form->hiddenField($model,'in_or_out',array('value'=>'OUT'));
			  echo $form->hiddenField($model,'is_application',array('value'=>'No'));
		?>
		</div>
	</div>
	<div class="span12">
		<div class="span3">
		<?php echo $form->dropDownListRow($model,'document_type_id',
		  		CHtml::listData(DocumentType::model()->findAll('type_level_id=2'), 'id', 'description'),
		  		array('prompt'=>Yii::t('app','-- Please Select --'))
		  );?>
		</div>
		<div class="span3">
		<?php echo $form->dropDownListRow($model,'document_status_id',
					CHtml::listData(DocumentStatus::model()->findAll('status_type="OUT"'), 'id', 'status_description'),
			  		array('prompt'=>Yii::t('app','-- Please Select --'))
		); ?>
		</div>
	</div>
	<div class="span12">
		<div class="span3">
		<?php echo $form->dropDownListRow($model,'from_organization_id',
					CHtml::listData(Organization::getList(), 'id', 'organization_name'),
			  		array('prompt'=>Yii::t('app','-- Please Select --'))
		); ?>
		<?php echo $form->textFieldRow($model,'from_organization_id'); ?>
		</div>
		<div class="span3">
		<?php echo $form->textFieldRow($model,'to_organization_id'); ?>
		</div>
	</div>
	<div class="span12">
		<div class="span3">
		<?php echo $form->datepickerRow($model, 'from_date');?>
		</div>
		<div class="span3">
		<?php echo $form->datepickerRow($model, 'to_date',
		array(	//'hint'=>'Policy start date' , 
				//'prepend'=>'<i class="icon-calendar"></i>', 
				'options'=>array('format' => 'dd/mm/yyyy' , 'weekStart'=> 1)
        ));?>
		</div>
		<div class="span2"><?php echo CHtml::submitButton('Submit'); ?></div>
	</div>
</div>
	
	
	
		
	
	

	<div class="row buttons">
		
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->