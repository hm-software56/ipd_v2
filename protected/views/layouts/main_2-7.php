<?php /* @var $this Controller */ ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="lo" lang="lo">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="lo" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css" />
	<?php // Yii::app()->clientScript->registerCoreScript('jquery.ba-bbq.js'); ?>
	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>

<div class="container" id="page">

	<div id="header">
		<div <?php if(!isset(Yii::app()->user->id)){echo "id='logo'";}else{echo "id='logo1'";}?>><?php echo CHtml::encode(Yii::app()->name); ?></div>
	</div>
	
	<!-- header -->
	<?php if(isset(Yii::app()->user->id))
	{
	?>
	
	<?php if(isset(Yii::app()->session['Setting'])):?>
	
	<?php 
		$this->widget('bootstrap.widgets.TbMenu', array(
		    'type'=>'tabs',
		    'items' => array(
			    array('label'=>'ບໍລິຫານໃຫ້ສິດຜູ້ໃຊ້', 'url'=>array('/srbac/authitem/frontpage'),),
			    array('label'=>'ບໍລິຫານຜູ້ໃຊ້', 'url'=>array('/user/index'),
			    	'items' => array(
			    		array('label' => 'ລາຍການຜູ້ໃຊ້', 'url'=>array('user/index'),),
						array('label' => 'ເພີ່ມຜູ້ໃຊ້', 'url'=>array('user/create'),),
					)
			    ),
			    array('label'=>'ບໍລິຫານສະຖານະ', 'url'=>array('/status/index'),
			    	'items' => array(
			    		array('label' => 'ລາຍການສະຖານະ', 'url'=>array('/status/index'),),
						array('label' => 'ເພີ່ມສະຖານະ', 'url'=>array('/status/create'),),
					)
			    ),
			    array('label'=>'ບໍລິຫານປະເພດເອກະສານ', 'url'=>array('/documentType/index'),
			    	'items' => array(
			    		array('label' => 'ລາຍການປະເພດເອກະສານ', 'url'=>array('/documentType/index'),),
						array('label' => 'ເພີ່ມປະເພດເອກະສານ', 'url'=>array('/documentType/create'),),
						array('label' => '-----------------------------------','itemOptions'=>array('style'=>'margin-top: 0px;')),
						array('label' => 'ລາຍການໝວດ', 'url'=>array('/typeLevel/index'),),
						array('label' => 'ເພີ່ມໝວດ', 'url'=>array('/typeLevel/create'),),
					)
			    ),
			    array('label'=>'ອອກຈາກລະບົບ', 'url'=>array('/site/logout') ),
		    )
		));
	?>
	
	 <?php endif;?>
	 <?php if(!isset(Yii::app()->session['Setting'])):?>
	 <br/>
	<div class="row-fluid">
	<div class="span12">
		<div class="row-fluid">
			<div class="span8">
				<div class="row3">ຜູ້ໃຊ້: <?php echo Yii::app()->user->name?></div>
				<div class="row5">
				<?php 
					$this->beginWidget('bootstrap.widgets.TbModal', array('htmlOptions'=>array('id'=>'changepassword','style'=>'width:800px'))); ?>
					 
					<div class="modal-header">
					    <a class="close" data-dismiss="modal">&times;</a>
					    <h4>Document Assign to User</h4>
					</div>
					 
					<div class="modal-body">
					    <p>One fine body...</p>
					</div>
					<?php $this->endWidget(); 
				?>
					<?php 
					echo CHtml::link('ປ່ຽນຂໍ້ມູນສ່ວນຕົວ',array('user/changeprofile/'))." | " ;
					echo CHtml::link('ປ່ຽນລະຫັດ',array('user/changepassword/'))." | " ;
					
					echo CHtml::link('ຕັ້ງຄ່າລະບົບ',array('/site/setting'))." | " ;
					echo CHtml::link('ອອກຈາກລະບົບ',array('/site/logout')) ;
					?>
				</div>
			</div>
			<div class="span4">
				<form class="navbar-form pull-left" action="<?php echo Yii::app()->baseUrl?>/index.php/site/search" method="get">
				<table class="table table-bordered">
					<tr><td colspan='2'><?php echo Yii::t('app','Search Document')?></td></tr>
					<tr><td class="span7" style="vertical-align:middle"><?php echo Yii::t('app','Document No') ?>:
					  		<input type="text" id="docNo" name="docNo" value="<?php echo @$docNo?>" class="span5" />
					  		<button type="submit" class="btn"><?php echo Yii::t('app','Search') ?></button>
				  		</td>
				  	</tr>
				</table>
				</form>
			</div>
		</div>
		</div>
	</div>
	<div style="position:absolute; top:190px">
	<?php
	$this->widget('bootstrap.widgets.TbMenu', array(
		    'type'=>'tabs',
		'items' => array(
			    array('label'=>'ໜ້າຫຼັກ', 'url'=>array('/site/index')),
			    array('label'=>'ຂາເຂົ້າ', 'url'=>array('/inDocument/index')),
			    array('label'=>'ຂາອອກ', 'url'=>array('/outDocument/index')),
			    array('label'=>'ຄົ້ນຫາ', 'url'=>array('#')),
			    array('label'=>'ລາຍງານ', 'url'=>array('#')),
			    )
	));
	?>
	</div>
	<?php endif;?>
	
	<!-- mainmenu -->
	<?php if(isset($this->breadcrumbs)):?>
		<?php $this->widget('zii.widgets.CBreadcrumbs', array(
			'links'=>$this->breadcrumbs,
		)); ?><!-- breadcrumbs -->
	<?php endif?>
	<?php 
	}
	?>
	<?php echo $content; ?>

	<div class="clear"></div>

	<div id="footer">
		<br/>
		All Rights Reserved. Copyright 2013. Information Tracking System, Designed and Developed by CYBERIA, Vientiane - Lao PDR
	</div><!-- footer -->

</div><!-- page -->

</body>
</html>
