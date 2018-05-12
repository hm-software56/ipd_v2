<?php
$this->layout="column1";
?>
<div class="row">
	<div class="span6">
	<?php /** @var BootActiveForm $form */
	$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	    'id'=>'searchForm',
	    'type'=>'search',
	    'htmlOptions'=>array('class'=>'well'),
	)); ?>
	 
	 <div class="control-group">
	  <div class="controls">
	    <div class="input-prepend">
	      <span class="add-on"><i class="icon-search"></i></span>
	     <?php echo $form->datepickerRow($model, 'start_date',array('class'=>'span2'));?>
	     <?php echo Yii::t('app','To')?>
	     <?php echo $form->datepickerRow($model, 'end_date',array('class'=>'span2'));?>
	    </div>
	    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'label'=>'Go')); ?>
	
	  </div>
	</div>
	<?php $this->endWidget(); ?>
	</div>
</div>

<table class="table table-bordered" >
<tr>
<th>
<?php echo Yii::t('app','Inc Document No')?>
</th>
<th>
<?php echo Yii::t('app','Name')?>
</th>
<th>
<?php echo Yii::t('app','Amount To Budget')?>
</th>
<th>
<?php echo Yii::t('app','Amount To Department')?>
</th>
</tr>
<?
$sumBudget=NULL;
$sumDep=NULL;
$sumBudget1=NULL;
$sumDep1=NULL;
foreach($paid as $paids)
{
	if($paids->incDocument->fee->fee_type==Yii::t('app','Kip'))
	{
	$sumBudget+=$paids->amount_to_budget;
	$sumDep+=$paids->amount_to_department;
?>
	<tr>
	<td><?php echo $paids->incDocument->inc_document_no?></td>
	<td><?php echo $paids->incDocument->fee->fee_description?></td>
	<td><?php echo number_format($paids->amount_to_budget,2)." ".Yii::t('app','Kip')?></td>
	<td><?php echo number_format($paids->amount_to_department,2)." ".Yii::t('app','Kip')?></td>
	</tr>
<?php 
}else{
	$sumBudget1+=$paids->amount_to_budget;
	$sumDep1+=$paids->amount_to_department;
?>	
	<tr>
	<td><?php echo $paids->incDocument->inc_document_no?></td>
	<td><?php echo $paids->incDocument->fee->fee_description?></td>
	<td><?php echo number_format($paids->amount_to_budget,2)." ".Yii::t('app','Dollar')?></td>
	<td><?php echo number_format($paids->amount_to_department,2)." ".Yii::t('app','Dollar')?></td>
	</tr>
<?php 
}
}
?>
<?php 
if(!empty($paid))
{
?>
<tr>
<th colspan="2"><div align="right"><?php echo Yii::t('app','Total')?></div></th>
<td><?php echo number_format($sumBudget,2)." ".Yii::t('app','Kip')?></td>
<td><?php echo number_format($sumDep,2)." ".Yii::t('app','Kip')?></td>
</tr>
<tr>
<tr>
<th colspan="3"><div align="right"><?php echo Yii::t('app','Amounts Total')?></div></th>
<td><?php echo number_format($sumBudget+$sumDep,2)." ".Yii::t('app','Kip')?></td>
</tr>

<tr>
<th colspan="2"><div align="right"><?php echo Yii::t('app','Total')?></div></th>
<td><?php echo number_format($sumBudget1,2)." ".Yii::t('app','Dollar')?></td>
<td><?php echo number_format($sumDep1,2)." ".Yii::t('app','Dollar')?></td>
</tr>
<tr>
<th colspan="3"><div align="right"><?php echo Yii::t('app','Amounts Total')?></div></th>
<td><?php echo number_format($sumBudget1+$sumDep1,2)." ".Yii::t('app','Dollar')?></td>
</tr>
<?php 
}
else{
?>
<tr>
<td height="30" colspan="4" ><div align="center"><?php echo Yii::t('app','No results')?></div></td>
</tr>
<?php 
}
?>
</table>