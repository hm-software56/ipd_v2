<?php
$ogid = null;
$mylist = null;

if($users)
{
  	foreach ($users as $u)
	{
		$member = NULL;
		$mylist[$u->userProfile->organization->organization_name];
		$member=array('label'=>$u->userProfile->first_name.' '.$u->userProfile->last_name);
		$mylist[$u->userProfile->organization->organization_name][]= $member;
	}
}