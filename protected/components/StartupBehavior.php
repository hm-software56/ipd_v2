<?php
class StartupBehavior extends CBehavior
{
    public function attach($owner)
    {
        // set the event callback
        $owner->attachEventHandler('onBeginRequest', array($this, 'beginRequest'));
    }

    /**
     * This method is attached to the 'onBeginRequest' event above.
     **/
    public function beginRequest(CEvent $event)
    {
    	$cookie = Yii::app()->request->cookies['lang'];
        if(empty($cookie->value)){
       		$cookie = new CHttpCookie('lang','lo');
        }
        Yii::app()->language = $cookie->value;
        $cookie->expire=time()+86400;
    }
}
