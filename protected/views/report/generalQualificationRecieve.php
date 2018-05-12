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
	<th rowspan="2"><div align="center"><?php echo Yii::t('app','Year')?></div></th>
	<th colspan="12"><div align="center"><?php echo Yii::t('app','Month')?></div></th>
</tr>
<tr>
	<?php 
	foreach ($month as $months)
	{
	?>
	<th><?php echo $months?></th>
	<?php 
	}
	?>
</tr>
<?php
foreach ($year as $years)
{
?>
<tr>
	<td><?php echo $years ?></td>
	<?php 
	foreach ($month as $months)
	{
	?>
		<td>
			<?php 
			$IdDoc_type=Yii::app()->params->typeDoc_id_qualification;
			if(!empty($modelIndoc->start_date) || !empty($modelIndoc->end_date))
			{
				$count=Yii::app()->db->createCommand("SELECT count(*)FROM document where document_type_id in ('".$IdDoc_type."') AND Date(created) BETWEEN '".date('Y-m-d',strtotime($modelIndoc->start_date))."' and '".date('Y-m-d',strtotime($modelIndoc->end_date))."' AND MONTH(created)=$months ")->queryScalar();
			}
			else{
				$count=Yii::app()->db->createCommand("SELECT count(*)FROM document where document_type_id in ($IdDoc_type) AND YEAR(created)=$years AND MONTH(created)=$months")->queryScalar();
			}
			if(!empty($count))
			{
				echo $count; 
			}
			?>
		</td>
	<?php 
	}
	?>
</tr>
<?php 
}
?>
</table>
