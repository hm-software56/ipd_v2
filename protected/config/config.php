<?php
/**
 * This is the configuration for generating message translations
 * for the Yii framework. It is used by the 'yiic message' command.
 */
return array(
	'sourcePath'=>'D:\projectweb\IPD\ipd',
	'messagePath'=>'D:\projectweb\IPD\ipd\protected\messages',
	//'sourcePath'=>'/home/sgplaos/public_html/sgpdatabase',
	//'messagePath'=>'/home/sgplaos/public_html/sgpdatabase/protected/messages',
	'languages'=>array('lo'),
	'fileTypes'=>array('php'),
	'overwrite'=>true,
	'exclude'=>array('messages',),
	'translator'=>'Yii::t',
);
