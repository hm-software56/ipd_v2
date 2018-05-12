<?php
$this->layout="column1";
?>
<div class="row">
	<div class="span4">
	<?php /** @var BootActiveForm $form */
	$form = $this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	    'id'=>'searchForm',
	    'type'=>'search',
	    'htmlOptions'=>array('class'=>'well'),
	)); ?>
	 
	<?php 
		$yearNow = date("Y");
		$yearFrom = $yearNow;
		$yearTo = $yearNow - Yii::app()->params->CountdownYear;
		$arrYears = array();
    	 
		 foreach (range($yearFrom, $yearTo) as $number) {
		 $arrYears[$number] = $number; 
		 }
		 
		$arrYears = array_reverse($arrYears, true);
	?>
	 <div class="control-group">
	  <div class="controls">
	    <div class="input-prepend">
	      <span class="add-on"><i class="icon-search"></i></span>
	     <?php echo CHtml::dropDownList('year',$years,$arrYears);?>
	    </div>
	    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'label'=>'Go')); ?>
	
	  </div>
	</div>
	<?php $this->endWidget(); ?>
	</div>
</div>
<table class="table table-bordered" >
  <tr >
  <th rowspan="2">
  <?php echo Yii::t('app','Ministries')?>
  </th>
  <th colspan="12"><div align="center">
  <?php echo Yii::t('app','Average time(days) each of month(with min and max)')?>
  </div></th>
  </tr>
  <tr>
  <?php 
  if(!empty($years))
  {
  	$year=$years;
  }else{
  	$year=date('Y');
  }
  foreach ($header as $headers)
  {
  ?>
  <td><?php echo $headers?></td>
  <?php 
  }
  ?>
  </tr>
  <?php 
  $respone=Yii::app()->db->createCommand("SELECT DISTINCT from_ministry FROM reponse_time_part2 where Year(response_date)=$year AND owner_province_id='".$regionID->organization->region_id."'")->queryAll();
  foreach ($respone as $respones)
  {
  ?>
  <tr>
  <th><?php echo $respones['from_ministry']?></th>
  <?php 
  foreach ($month as $months)
  {
  ?>
  <td>
  <?php 
  $count=Yii::app()->db->createCommand("SELECT ROUND(AVG(DATEDIFF(response_date,date(ministry_received_date)))) AS DiffDays FROM reponse_time_part2 where Year(response_date)=$year AND owner_province_id='".$regionID->organization->region_id."' AND MONTH(response_date)=$months AND from_ministry='".$respones['from_ministry']."'")->queryScalar();
  $mix=Yii::app()->db->createCommand("SELECT MIN(DATEDIFF(response_date,date(ministry_received_date))) FROM reponse_time_part2 where Year(response_date)=$year AND owner_province_id='".$regionID->organization->region_id."' AND MONTH(response_date)=$months AND from_ministry='".$respones['from_ministry']."'")->queryScalar();
  $max=Yii::app()->db->createCommand("SELECT MAX(DATEDIFF(response_date,date(ministry_received_date))) FROM reponse_time_part2 where Year(response_date)=$year AND owner_province_id='".$regionID->organization->region_id."' AND MONTH(response_date)=$months AND from_ministry='".$respones['from_ministry']."'")->queryScalar();
  echo $count.'<br/>';
  if(!empty($count))
  	echo '('.$mix.'-'.$max.')';
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