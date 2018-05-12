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
    <th>Sector</th>
    <?php 
    foreach ($region as $regions)
    {
    ?>
    <th><?php echo $regions->region_code?></th>
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
  $investmentLocation=Yii::app()->db->createCommand("SELECT DISTINCT sector_name FROM investment_location where Year=$year AND province_owner_id='".$regionID->organization->region_id."'")->queryAll();
  foreach($investmentLocation as $investmentLocations)
  {
  ?>
  <tr>
  	<th><?php echo $investmentLocations['sector_name']?></th>
  	<?php 
  	foreach ($region as $regions)
    {
    ?>
	    <td>
		    <?php 
			 $count=Yii::app()->db->createCommand("SELECT count(*)FROM investment_location where sector_name='".$investmentLocations['sector_name']."'AND province_name='".$regions->region_name."' and year=$year AND  province_owner_id='".$regionID->organization->region_id."'")->queryScalar();
			 if($count!=0)
			 {
			 	echo $count;
			 	$regionapp=Yii::app()->db->createCommand("SELECT DISTINCT region_name FROM investment_location where sector_name='".$investmentLocations['sector_name']."' AND  province_name='".$regions->region_name."' AND year=$year AND province_owner_id='".$regionID->organization->region_id."'")->queryAll();
				  foreach($regionapp as $regionapps)
				  {
				  	if($regionapps['region_name']==Yii::app()->params->Region_Name_Domestic)
				  		echo '<br/>(D'.Yii::app()->db->createCommand("SELECT count(*)FROM investment_location where region_name='".$regionapps['region_name']."' AND province_name='".$regions->region_name."' AND sector_name='".$investmentLocations['sector_name']."' and year=$year AND province_owner_id='".$regionID->organization->region_id."'")->queryScalar().')';
				  	
				  	if($regionapps['region_name']==Yii::app()->params->Region_Name_Foreign)
				  		echo '<br/>(F'.Yii::app()->db->createCommand("SELECT count(*)FROM investment_location where region_name='".$regionapps['region_name']."' AND province_name='".$regions->region_name."'AND sector_name='".$investmentLocations['sector_name']."'  and year=$year AND province_owner_id='".$regionID->organization->region_id."'")->queryScalar().')';
				  	if($regionapps['region_name']==Yii::app()->params->Region_Name_JointVenture)
				  		echo '<br/>(J'.Yii::app()->db->createCommand("SELECT count(*)FROM investment_location where region_name='".$regionapps['region_name']."' AND province_name='".$regions->region_name."'AND sector_name='".$investmentLocations['sector_name']."'  and year=$year AND province_owner_id='".$regionID->organization->region_id."'")->queryScalar().')';
				  	
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