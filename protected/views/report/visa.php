<?php
$this->layout='column1';
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
	     <?php echo $form->datepickerRow($modelIndoc, 'start_date',array('class'=>'span2'));?>
	     <?php echo Yii::t('app','To')?>
	     <?php echo $form->datepickerRow($modelIndoc, 'end_date',array('class'=>'span2'));?>
	    </div>
	    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'label'=>'Go')); ?>
	
	  </div>
	</div>
	<?php $this->endWidget(); ?>
	</div>
</div>
<table class="table table-bordered" >
<tr>
	<th><?php echo Yii::t('app','Year')?></th>
	<th><?php echo Yii::t('app','Visa at border')?></th>
	<th><?php echo Yii::t('app','Visa Business 3,6,12 Month')?></th>
</tr>
<?php
foreach ($year as $years)
{
?>
<tr>
	<td><?php echo $years ?></td>
	<td>
	<?php 
	$IdDoc_type_border=Yii::app()->params->IDVisa_border;
	if(!empty($modelIndoc->start_date) || !empty($modelIndoc->end_date))
	{
		$count=Yii::app()->db->createCommand("SELECT count(*)FROM document where document_type_id=$IdDoc_type_border AND Date(created) BETWEEN '".date('Y-m-d',strtotime($modelIndoc->start_date))."' and '".date('Y-m-d',strtotime($modelIndoc->end_date))."'")->queryScalar();
	}
	else{
		$count=Yii::app()->db->createCommand("SELECT count(*)FROM document where document_type_id=$IdDoc_type_border AND YEAR(created)=$years")->queryScalar();
	}
	if(!empty($count))
	{
		echo $count;
	}
	?>
	</td>
	<td>
	<?php 
	$IdDoc_type=Yii::app()->params->IDVisa_3_6_12;
	if(!empty($modelIndoc->start_date) || !empty($modelIndoc->end_date))
	{
		$count=Yii::app()->db->createCommand("SELECT count(*)FROM document where document_type_id in ('".$IdDoc_type."') AND Date(created) BETWEEN '".date('Y-m-d',strtotime($modelIndoc->start_date))."' and '".date('Y-m-d',strtotime($modelIndoc->end_date))."'")->queryScalar();
	}
	else{
		$count=Yii::app()->db->createCommand("SELECT count(*)FROM document where document_type_id in ('".$IdDoc_type."') AND YEAR(created)=$years")->queryScalar();
	}
	if(!empty($count))
	{
		echo $count;
	}
	?>
	</td>
</tr>
<?php 
}
?>
</table>
