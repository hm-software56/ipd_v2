<?php

$this->breadcrumbs = array(
	$model->label(2) => array('index'),
	Yii::t('app', 'View'),
);
?>

<fieldset>
	<legend>View Mining Application</legend>
	
<?php
    $type = ApplicationType::model()->findByPk($model->application_type_id);
    $doc = Yii::app()->controller->module->documentClass;
    $docNo = Yii::app()->controller->module->documentNo;
    $document=$doc::model()->findByPk($model->inc_document_id);
    $document_no = $document->$docNo;
?>

<div class="form">
<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'mining-form',
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
<div class="span9" style="margin-top:20px">
<?php echo $form->labelEx($mining,'company_name');?>
<span><code><?php echo $mining->company_name;?></code></span>
</div>
</div>
<div class="row-fluid">
<div class="span9" style="margin-top:20px">
<?php echo $form->labelEx($mining,'objective');?>
<span><code><?php echo $mining->objective;?></code></span>
</div>
</div>

<div class="row-fluid">
<div class="span3" style="margin-top:20px">
<?php echo $form->labelEx($mining,'total_capital');?>
<span><code><?php echo $mining->total_capital;?></code></span>
</div>
<div class="span3" style="margin-top:20px">
<?php echo $form->labelEx($mining,'capital');?>
<span><code><?php echo $mining->capital;?></code></span>
</div>
<div class="span3" style="margin-top:20px">
<?php echo $form->labelEx($mining,'fixed_asset');?>
<span><code><?php echo $mining->fixed_asset;?></code></span>
</div>
<div class="span3" style="margin-top:20px">
<?php echo $form->labelEx($mining,'current_asset');?>
<span><code><?php echo $mining->current_asset;?></code></span>
</div>
</div>

<fieldset>
<legend><b><?php echo Yii::t('app','Head office')?></b></legend>
<div class="row-fluid">
<div class="span3" style="margin-top:20px">
<?php echo $form->labelEx($mining,'province_id');?>
<span><code><?php echo $mining->province;?></code></span>
</div>
<div class="span3" style="margin-top:20px">
<?php echo $form->labelEx($mining,'district_id');?>
<span><code><?php echo $mining->district;?></code></span>
</div>
<div class="span3" style="margin-top:20px">
<?php echo $form->labelEx($mining,'village_id');?>
<span><code><?php echo $mining->village;?></code></span>
</div>
<div class="span3" style="margin-top:20px">
<?php echo $form->labelEx($mining,'address');?>
<span><code><?php echo $mining->address;?></code></span>
</div>
</div>
</fieldset>

<fieldset>
<legend><b><?php echo Yii::t('app','Project Site')?></b></legend>

<div class="row-fluid">
	<?php echo $this->renderPartial('_miningsite',array('model'=>$model,'mining'=>$mining));?>
</div>

</fieldset>

<fieldset>
	<legend><b><?php echo Yii::t('app','Invest Company')?></b></legend>
	
    <div class="row-fluid">
        <?php echo $this->renderPartial('_invest',array('model'=>$model));?>
    </div>	
</fieldset>

<?php $this->endWidget();?>
</div><!-- form -->
</fieldset>
