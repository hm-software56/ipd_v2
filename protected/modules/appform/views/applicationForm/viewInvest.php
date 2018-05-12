<?php $form = $this->beginWidget('bootstrap.widgets.TbActiveForm',array(
    'id'=>'invest-company-modal-form',
));?>
<fieldset>
<div class="row-fluid">
<div class="span6" style="margin-top: 20px">
	<?php echo $form->labelEx($model,'company_name');?>
	<code><?php echo $model->company_name?></code>
</div>
<div class="span6" style="margin-top: 20px">
	<?php echo $form->labelEx($model,'register_place');?>
	<code><?php echo $model->register_place?></code>
</div>
</div>

<div class="row-fluid">
<div class="span6" style="margin-top: 20px">
	<?php echo $form->labelEx($model,'register_date');?>
	<code><?php echo $model->register_date?></code>
</div>
<div class="span6" style="margin-top: 20px">
	<?php echo $form->labelEx($model,'total_capital');?>
	<code><?php echo $model->total_capital?></code>
</div>
</div>

<div class="row-fluid">
<div class="span6" style="margin-top: 20px">
	<?php echo $form->labelEx($model,'capital');?>
	<code><?php echo $model->capital?></code>
</div>
<div class="span6" style="margin-top: 20px">
	<?php echo $form->labelEx($model,'president_first_name');?>
	<code><?php echo $model->president_first_name?></code>
</div>
</div>

<div class="row-fluid">
<div class="span6" style="margin-top: 20px">
	<?php echo $form->labelEx($model,'president_last_name');?>
	<code><?php echo $model->president_last_name?></code>
</div>
<div class="span6" style="margin-top: 20px">
	<?php echo $form->labelEx($model,'president_nationality');?>
	<code><?php echo $model->president_nationality?></code>
</div>
</div>

<div class="row-fluid">
<div class="span6" style="margin-top: 20px">
	<?php echo $form->labelEx($model,'president_position');?>
	<code><?php echo $model->president_position?></code>
</div>
<div class="span6" style="margin-top: 20px">
	<?php echo $form->labelEx($model,'headquarter_address');?>
	<code><?php echo $model->headquarter_address?></code>
</div>
</div>

<div class="row-fluid">
<div class="span6" style="margin-top: 20px">
	<?php echo $form->labelEx($model,'business_sector_id');?>
	<code><?php echo $model->businessSector?></code>
</div>
</div>


</fieldset>

<?php $this->endWidget();?>