<?php
$this->layout='column1';
?>
<div class="row">
	<div class="span5">
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
	      <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
		    'model'=>$modelIndoc,
	       'attribute'=>'start_date',
		    'options'=>array(
		        'dateFormat'=>'yy',
		        'yearRange'=>'-70:+0',
		      	'changeYear'=>'true',
		    ),
		)); ?>
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
	<?php
	foreach ($year as $years)
	{
	?>
	<th><?php echo $years ?></th>
	<?php 
	}
	?>	
</tr>
<?php 
$sector=Yii::app()->db->createCommand("SELECT DISTINCT sector_name FROM received_app_with_sector where province_owner_id='".$regionID->organization->region_id."'")->queryAll();
foreach ($sector as $sectors)
{
?>
<tr>
	<td><?php echo $sectors['sector_name']?></td>
	<?php 
	foreach ($year as $years)
	{
	?>
	<td>
	<?php 
	 $count=Yii::app()->db->createCommand("SELECT count(*)FROM received_app_with_sector where sector_name='".$sectors['sector_name']."'AND year=$years AND province_owner_id='".$regionID->organization->region_id."'")->queryScalar();
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
