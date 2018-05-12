<?php
$this->widget('bootstrap.widgets.TbMenu', array(
		    'type'=>'tabs',
		'items' => array(
			    array('label'=>'General Application', 'url'=>array('/site/searchGeneral')),
			    array('label'=>'Rep Office', 'url'=>array('/site/searchRep')),
			    array('label'=>'Electricity', 'url'=>array('/site/searchElec')),
			    array('label'=>'Mining', 'url'=>array('/site/searchMining')),
			    )
	));