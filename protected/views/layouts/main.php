<?php /* @var $this Controller */ ?>
<!doctype html>
<!--[if IE]><![endif]-->
<!--[if lt IE 7 ]> <html lang="lo" class="ie6">    <![endif]-->
<!--[if IE 8 ]>    <html lang="lo" class="ie8">    <![endif]-->
<!--[if IE 9 ]>    <html lang="lo" class="ie9">    <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--><html lang="lo"><!--<![endif]-->
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="lo" />
		
	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print" />
	
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->
	
	<?php Yii::app()->bootstrap->register(); ?>
	
    <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/main.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/styles.css" />
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/form.css" />    
    <?php
		if(Yii::app()->controller->action->id =="login")
		{
	?>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/bg/css/style.css">
	<?php
		}
	?>
	<!--  <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->baseUrl; ?>/css/mystyles.css" />-->
	<!--[if lt IE 9]>
		<script type="text/javascript" src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<?php // Yii::app()->bootstrap->registerYiiCss(); ?>
	<?php // Yii::app()->bootstrap->registerCoreScripts(); ?>
</head>
<div class="container" id="page">
	<div id="header">
		<!-- <div <?php if(!isset(Yii::app()->user->id)){echo "id='logo'";}else{echo "id='logo1'";}?>><?php echo CHtml::encode(Yii::app()->name); ?></div> -->
		<div id="logo1">
			<table>
			<tr>
			<td><?php echo CHtml::image(Yii::app()->baseUrl.'/images/logo.gif' ) ?></td>
			<td><div align="right"><?php echo CHtml::image(Yii::app()->baseUrl.'/images/logoright.gif' ) ?></div></td>
			</tr>
			</table>
		</div>
	</div>
	
	<!-- header -->
	<?php if(isset(Yii::app()->user->id))
	{
	?>
	
	<?php if(isset(Yii::app()->session['Setting']) && Yii::app()->user->checkAccess('Administrator')):?>
	
	<?php 
		$this->widget('bootstrap.widgets.TbMenu', array(
		    'type'=>'tabs',
		    'items' => array(
				array('label'=>'ໜ້າຫຼັກ', 'url'=>array('/site/index') ),
			   // array('label'=>'ບໍລິຫານໃຫ້ສິດຜູ້ໃຊ້', 'url'=>array('/srbac/authitem/frontpage'),),
			    array('label'=>'ຄ່າທໍານຽມ', 'url'=>array('/fee/index'),
			    	'items' => array(
			    		array('label' => 'ລາຍການຄ່າທໍານຽມ', 'url'=>array('/fee/index'),),
						array('label' => 'ເພີ່ມຄ່າທໍານຽມ', 'url'=>array('/fee/create'),),
					),
			    ),
			    array('label'=>'ບໍລິຫານຜູ້ໃຊ້', 'url'=>array('/user/index'),
			    	'items' => array(
			    		array('label' => 'ລາຍການຜູ້ໃຊ້', 'url'=>array('/user/index'),),
						array('label' => 'ເພີ່ມຜູ້ໃຊ້', 'url'=>array('/user/create'),),
					)
			    ),
			    array('label'=>'ບໍລິຫານສະຖານະ', 'url'=>array('/status/index'),
			    	'items' => array(
			    		array('label' => 'ລາຍການສະຖານະ', 'url'=>array('/status/index'),),
						array('label' => 'ເພີ່ມສະຖານະ', 'url'=>array('/status/create'),),
					)
			    ),
			    array('label'=>'ບໍລິຫານອົງການຈັດຕັ້ງ', 'url'=>array('/organization/index'),
			    	'items' => array(
			    		array('label' => 'ລາຍການອົງການຈັດຕັ້ງ', 'url'=>array('/organization/index'),),
						array('label' => 'ເພີ່ມອົງການຈັດຕັ້ງະ', 'url'=>array('/organization/create'),),
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
			    array('label'=>'ຂັ້ນຕອນການສົງຄຳຮ້ອງ', 'url'=>array('/status/index'),
			    	'items' => array(
			    		array('label' => 'ລາຍການຂັ້ນຕອນສົງຄຳຮ້ອງ', 'url'=>array('/appform/applicationStep'),),
						array('label' => 'ເພີ່ມຂັ້ນຕອນສົງຄຳຮ້ອງ', 'url'=>array('/appform/applicationStep/create'),),
					)
			    ),
			    
			    array('label'=>'ບໍລິຫານຂະແໜງທຸລະກິດ', 'url'=>array('/businessSector/index'),
			    	'items' => array(
			    		array('label' => 'ລາຍການຂະແໜງທຸລະກິດ', 'url'=>array('/businessSector/index'),),
						array('label' => 'ເພີ່ມຂະແໜງທຸລະກິດ', 'url'=>array('/businessSector/create'),),
					),
			    ),
				array('label' => 'Backup ຖານ​ຂໍ້​ມ​ູນ', 'url' => array('/site/bkdb')),
			    array('label'=>'ອອກຈາກລະບົບ', 'url'=>array('/site/logout') ),
		    ), 
		));
	?>
	
	 <?php endif;?>
	 <?php if(!isset(Yii::app()->session['Setting'])):?>
	 <br/>
	<div class="row-fluid" id="topnavigation">
	<div class="span12">
		<div class="row-fluid">
			<div class="span7" id="username" >
					<div class="row" style="margin-left:1px">ຜູ້ໃຊ້: <?php echo Yii::app()->user->name?></div>
					<div class="row" style="margin-left:1px">
						<?php 
						echo CHtml::link('ປ່ຽນຂໍ້ມູນສ່ວນຕົວ',array('/user/changeprofile/'))." | " ;
						echo CHtml::link('ປ່ຽນລະຫັດ',array('/user/changepassword/'))." | " ;
						if(Yii::app()->user->checkAccess('Administrator'))
							echo CHtml::link('ຕັ້ງຄ່າລະບົບ',array('/site/setting'))." | " ;
						echo CHtml::link('ອອກຈາກລະບົບ',array('/site/logout')) ;
						?>
					</div>
			</div>
			<?php 
			if(!Yii::app()->user->checkAccess('Accounting'))
			{
			?>
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
			<?php 
			}
			?>
		</div>
		</div>
	</div>
	<div id="menu_top">
	<?php
	if(Yii::app()->user->checkAccess('Accounting'))
	{
		$this->widget('bootstrap.widgets.TbMenu', array(
			    'type'=>'tabs',
				'items' => array(
				    array('label'=>'ໜ້າຫຼັກ', 'url'=>array('/caisse/admin')
				    
				    ),
				)
		));
	}else{
		$this->widget('bootstrap.widgets.TbMenu', array(
			    'type'=>'tabs',
			'items' => array(
				    array('label'=>'ໜ້າຫຼັກ', 'url'=>array('/site/index')),
				    array('label'=>'ລາຍການຄໍາຮ້ອງ', 'url'=>array('/appform/applicationForm/index'),
				    	'visible'=>(Yii::app()->getModule('appform')&& Yii::app()->user->checkAccess('SingleWindow') || Yii::app()->user->checkAccess('DG'))
				    ),
				    array('label'=>'ຂາເຂົ້າ', 'url'=>array('/inDocument/index'),
				    	'visible'=>!Yii::app()->user->checkAccess('DG')
				    ),
				    
				    array('label'=>'ຂາອອກ', 'url'=>array('/outDocument/index'),
				    	'visible'=>!Yii::app()->user->checkAccess('DG')
				    ),
				    array('label'=>'ຄົ້ນຫາ', 'url'=>array('/search/index')),
				    array('label'=>'ລາຍງານ', 'url'=>array('#'),
				    	'items'=>array(
				    		array('label'=>'ຄໍາຮ້ອງທີ່ໄດ້ຮັບ', 'url'=>array('/report/applicationReceived')),
				    		array('label'=>'ເອກະສານທົ່ວໄປ', 'url'=>array('/report/generalRecieve')),
				    		array('label'=>'ເອກະສານທົ່ວໄປ (ວິຊາສະເພາະ)', 'url'=>array('/report/generalQualificationRecieve')),
				    		array('label'=>'ສະຖານທີ່ລົງທຶນ', 'url'=>array('/report/investmentLocation')),
				    		array('label'=>'ສະເລຍການຕອບກັບ', 'url'=>array('/report/responseTime')),
				    		//array('label'=>'ເງິນລົງທຶນ', 'url'=>array('/report/registeredCapital')),
				    		array('label'=>'ຄ່າທໍານຽມຕ່າງໆ', 'url'=>array('/report/paidRecieveForm')),
				    		array('label'=>'ວິຊາ', 'url'=>array('/report/visa')),
				    		array('label'=>'ຍືນຄໍາຮ້ອງຂໍລົງທືນ', 'url'=>array('/report/recieveApp')),
				    		array('label'=>'ຍືນຄໍາຮ້ອງຂໍປຽງແປງທາງດ້ານນິຕິກໍາ', 'url'=>array('/report/changeLawApp')),
				    	)
				    ),
				    array('label'=>'ກວດເບີ່ງການຈ່າຍເງີນ', 'url'=>array('/caisse/index'),
				    	'visible'=>Yii::app()->user->checkAccess('SingleWindow')
				    ),
				    )
		));
	}
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