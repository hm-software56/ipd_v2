<?php
    $type = ApplicationType::model()->findByPk($model->application_type_id);
    $doc = Yii::app()->controller->module->documentClass;
    $docNo = Yii::app()->controller->module->documentNo;
    $document=$doc::model()->findByPk($model->inc_document_id);
    $document_no = $document->$docNo;
    
    $criteria = new CDbCriteria;
    $criteria->order = 'id';
?>

<div class="form">
	<p class="note">
		<?php echo Yii::t('app', 'Fields with'); ?> <span class="required">*</span> <?php echo Yii::t('app', 'are required'); ?>.
	</p>
	
<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'repoffice-form',
    'enableAjaxValidation'=>false,
));?>

<?php echo $form->errorSummary(array($model,$repoffice));?>

<div class="row-fluid">
<div class="span3">
<?php echo $form->labelEx($model,'application_type_id');?>
<span><?php echo $type->description;?></span>
</div>
<div class="span3">
<?php echo $form->labelEx($model,'inc_document_id');?>
<span><?php echo $document_no;?></span>
</div>
<div class="span3">
<?php echo $form->dropDownListRow($model,'investor_region_id',
    CHtml::listData(InvestorRegion::model()->findAll(), 'id', InvestorRegion::representingColumn())
);?>
</div>
<div class="span3">
<?php echo $form->textFieldRow($model, 'contact_email');?>
</div>
</div>

<div class="row-fluid">
<div class="span3">
<?php echo $form->dropDownListRow($model,'application_step_id',
    CHtml::listData(ApplicationStep::model()->findAll(), 'id', ApplicationStep::representingColumn())
);?>
</div>
</div>

<div class="row-fluid">
<div class="span3">
<?php echo $form->textFieldRow($repoffice, 'first_name');?>
</div>
<div class="span3">
<?php echo $form->textFieldRow($repoffice, 'last_name');?>
</div>
<div class="span3">
<?php echo $form->datePickerRow($repoffice, 'birth_date',array(
    'options'=>array('format'=>'dd-mm-yyyy'),
));?>
</div>
<div class="span3">
<?php echo $form->dropDownListRow($repoffice, 'nationality_id',
    CHtml::listData(Nationality::model()->findAll(), 'id', Nationality::representingColumn())
);?>
</div>
</div>

<div class="row-fluid">
<div class="span6">
<?php echo $form->textFieldRow($repoffice,'parent_company', array('style'=>'width:100%'));?>
</div>
<div class="span6">
<?php echo $form->textFieldRow($repoffice,'register_place', array('style'=>'width:100%'));?>
</div>
</div>

<div class="row-fluid">
<div class="span12">
<?php echo $form->textAreaRow($repoffice,'business',array('rows'=>5,'style'=>'width:100%'));?>
</div>
</div>

<div class="row-fluid">
<div class="span12">
<?php echo $form->textAreaRow($repoffice,'objective',array('rows'=>5,'style'=>'width:100%'));?>
</div>
</div>

<div class="row-fluid">
<div class="span3">
<?php echo $form->dropDownListRow($repoffice,'province_id',
    CHtml::listData(Province::model()->findAll($criteria), 'id', 
    Province::representingColumn()),
    array(
        'prompt'=>'Please select',
        'options'=>array($repoffice->province_id=>array('selected'=>'selected')),
        'ajax'=>array(
            'type'=>'POST',
            'url'=>Yii::app()->controller->createUrl('districtDropDownList4'),
            'success'=>'js:function(data){
                $("#RepOffice_district_id").html(data);
                $("#RepOffice_village_id").html("<option value=\"\">Please Select</option>");
            }',
        )
    )
);?>
</div>
<div class="span3">
<?php echo $form->dropDownListRow($repoffice,'district_id',
    CHtml::listData(District::model()->findAll('province_id=:pid',array(':pid'=>$repoffice->province_id)), 'id', 
    District::representingColumn()),
    array(
        'prompt'=>'Please select',
        'options'=>array($repoffice->district_id=>array('selected'=>'selected')),
        'ajax'=>array(
            'type'=>'POST',
            'url'=>Yii::app()->controller->createUrl('villageDropDownList4'),
            'success'=>'js:function(data){
                $("#RepOffice_village_id").html(data);
            }',
        )
    )
);?>
</div>
<div class="span3">
<?php echo $form->dropDownListRow($repoffice,'village_id',
    CHtml::listData(Village::model()->findAll('district_id=:did',array(':did'=>$repoffice->district_id)), 'id', 
    Village::representingColumn()),
    array(
        'prompt'=>'Please select',
        'options'=>array($repoffice->village_id=>array('selected'=>'selected')),
    )
);?>
</div>
<div class="span3">
<?php echo $form->textFieldRow($repoffice,'house_no');?>
</div>
</div>

<div class="row-fluid">
<div class="span3">
<?php echo $form->textFieldRow($repoffice,'capital');?>
</div>
<div class="span3">
<?php echo $form->textFieldRow($repoffice,'fixed_asset');?>
</div>
<div class="span3">
<?php echo $form->textFieldRow($repoffice,'cash');?>
</div>
</div>

<div class="form-actions">
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'id'=>'appform-button',
        'buttonType'=>'button',
        'type'=>'primary',
        'label'=>$model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Save'),
        'htmlOptions'=>array('onclick'=>'js:$("#repoffice-form").submit()')
    )); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'label'=> Yii::t('app', 'Cancel'),
        'htmlOptions' => array('onclick' => 'javascript:history.go(-1)')
    )); ?>
</div>

<?php $this->endWidget();?>
</div><!-- form -->