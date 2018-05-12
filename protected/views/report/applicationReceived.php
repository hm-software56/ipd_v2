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
  <tr>
    <th rowspan="2"><?php echo Yii::t('app','Sector')?></th>
    <th colspan="12"><div style="text-align:center"><?php echo Yii::t('app','Month')?></div></th>
  </tr>
  <tr>
  <?php 
  foreach ($month as $months) {
  ?>
    <th><?php echo $months;?></th>
  <?php
   }
  ?>
  </tr>
  <?php 
  if(!empty($years))
  {
  	$year=$years;
  }else{
  	$year=date('Y');
  }
  $sector=Yii::app()->db->createCommand("SELECT DISTINCT sector_name FROM received_app_with_sector where year=$year AND province_owner_id='".$regionID->organization->region_id."'")->queryAll();
  foreach($sector as $sectors)
  {
  ?>
  <tr>
    <td><b><?php echo $sectors['sector_name']?></b></td>
     <?php 
	  foreach ($month as $months) {
	 ?>
    <td>
	<?php 
	 $count=Yii::app()->db->createCommand("SELECT count(*)FROM received_app_with_sector where sector_name='".$sectors['sector_name']."'AND Month=$months and year=$year AND province_owner_id='".$regionID->organization->region_id."'")->queryScalar();
	 if($count!=0)
	 {
	 	echo $count;
	 	$region=Yii::app()->db->createCommand("SELECT DISTINCT region_name FROM received_app_with_sector where sector_name='".$sectors['sector_name']."' AND  Month=$months AND year=$year AND province_owner_id='".$regionID->organization->region_id."'")->queryAll();
		  foreach($region as $regions)
		  {
		  	if($regions['region_name']==Yii::app()->params->Region_Name_Domestic)
		  		echo '<br/>(D'.Yii::app()->db->createCommand("SELECT count(*)FROM received_app_with_sector where sector_name='".$sectors['sector_name']."' AND region_name='".$regions['region_name']."' AND Month=$months and year=$year AND province_owner_id='".$regionID->organization->region_id."'")->queryScalar().')';
		  	
		  	if($regions['region_name']==Yii::app()->params->Region_Name_Foreign)
		  		echo '<br/>(F'.Yii::app()->db->createCommand("SELECT count(*)FROM received_app_with_sector where sector_name='".$sectors['sector_name']."' AND region_name='".$regions['region_name']."' AND Month=$months and year=$year")->queryScalar().')';
		  	if($regions['region_name']==Yii::app()->params->Region_Name_JointVenture)
		  		echo '<br/>(J'.Yii::app()->db->createCommand("SELECT count(*)FROM received_app_with_sector where sector_name='".$sectors['sector_name']."' AND region_name='".$regions['region_name']."' AND Month=$months and year=$year")->queryScalar().')';
		  	
		  }
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