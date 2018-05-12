<?php
class TrackChangeBehavior extends CActiveRecordBehavior {

    private $oldAttributes = array( );

    function afterFind( $event ) {
        parent::afterFind( $event );
        $this->oldAttributes = $this->owner->attributes;
    }

    /**
     * Checks if specified attribute has changed
     */
    public function isAttributeChanged( $name ) {
        if( $this->owner->getIsNewRecord() ) {
            return false;
        }
        return $this->oldAttributes[$name] !== $this->getOwner()->$name;
    }
    
    public function getOldAttributes()
    {
    	return $this->oldAttributes;
    }
}