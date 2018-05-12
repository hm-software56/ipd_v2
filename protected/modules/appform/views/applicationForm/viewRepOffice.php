<?php

$this->breadcrumbs = array(
	$model->label(2) => array('index'),
	Yii::t('app', 'View'),
);
?>

<fieldset>
	<legend>View Representative Application</legend>
	
<?php
    $type = ApplicationType::model()->findByPk($model->application_type_id);
    $doc = Yii::app()->controller->module->documentClass;
    $docNo = Yii::app()->controller->module->documentNo;
    $document=$doc::model()->findByPk($model->inc_document_id);
    $document_no = $document->$docNo;
?>

<div class="form">
<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'repoffice-form',
    'enableAjaxValidation'=>false,
));?>

<div class="row-fluid">
<div class="span3" style="margin-top:20px">
<?php echo $form->labelEx($model,'application_type_id');?>
<span><code><?php echo $type->description;?></code></span>
</div>
<div class="span3" style="margin-top:20px">
<?php echo $form->labelEx($model,'inc_document_id');?>
<span><code><?php echo $document_no;?></code></span>
</div>
<div class="span3" style="margin-top:20px">
<?php echo $form->labelEx($model,'investor_region_id');?>
<span><code><?php echo $model->investorRegion;?></code></span>
</div>
<div class="span3" style="margin-top:20px">
<?php echo $form->labelEx($model,'contact_email');?>
<span><code><?php echo $model->contact_email;?></code></span>
</div>
</div>

<div class="row-fluid">
<div class="span3" style="margin-top:20px">
<?php echo $form->labelEx($repoffice,'first_name');?>
<span><code><?php echo $repoffice->first_name;?></code></span>
</div>
<div class="span3" style="margin-top:20px">
<?php echo $form->labelEx($repoffice,'last_name');?>
<span><code><?php echo $repoffice->last_name;?></code></span>
</div>
<div class="span3" style="margin-top:20px">
<?php echo $form->labelEx($repoffice,'birth_date');?>
<span><code><?php echo $repoffice->birth_date;?></code></span>
</div>
<div class="span3" style="margin-top:20px">
<?php echo $form->labelEx($repoffice,'nationality_id');?>
<span><code><?php echo $repoffice->nationality;?></code></span>
</div>
</div>

<div class="row-fluid">
<div class="span6" style="margin-top:20px">
<?php echo $form->labelEx($repoffice,'parent_company');?>
<span><code><?php echo $repoffice->parent_company;?></code></span>
</div>
<div class="span6" style="margin-top:20px">
<?php echo $form->labelEx($repoffice,'register_place');?>
<span><code><?php echo $repoffice->register_place;?></code></span>
</div>
</div>

<div class="row-fluid">
<div class="span12" style="margin-top:20px">
<?php echo $form->labelEx($repoffice,'business');?>
<span><code><?php echo $repoffice->business;?></code></span>
</div>
</div>

<div class="row-fluid">
<div class="span12" style="margin-top:20px">
<?php echo $form->labelEx($repoffice,'objective');?>
<span><code><?php echo $repoffice->objective;?></code></span>
</div>
</div>

<div class="row-fluid">
<div class="span3" style="margin-top:20px">
<?php echo $form->labelEx($repoffice,'province_id');?>
<span><code><?php echo $repoffice->province;?></code></span>
</div>
<div class="span3" style="margin-top:20px">
<?php echo $form->labelEx($repoffice,'district_id');?>
<span><code><?php echo $repoffice->district;?></code></span>
</div>
<div class="span3" style="margin-top:20px">
<?php echo $form->labelEx($repoffice,'village_id');?>
<span><code><?php echo $repoffice->village;?></code></span>
</div>
<div class="span3" style="margin-top:20px">
<?php echo $form->labelEx($repoffice,'house_no');?>
<span><code><?php echo $repoffice->house_no;?></code></span>
</div>
</div>

<div class="row-fluid">
<div class="span3" style="margin-top:20px">
<?php echo $form->labelEx($repoffice,'capital');?>
<span><code><?php echo $repoffice->capital;?></code></span>
</div>
<div class="span3" style="margin-top:20px">
<?php echo $form->labelEx($repoffice,'fixed_asset');?>
<span><code><?php echo $repoffice->fixed_asset;?></code></span>
</div>
<div class="span3" style="margin-top:20px">
<?php echo $form->labelEx($repoffice,'cash');?>
<span><code><?php echo $repoffice->cash;?></code></span>
</div>
</div>
<?php $this->endWidget();?>
</div><!-- form -->
</fieldset>
