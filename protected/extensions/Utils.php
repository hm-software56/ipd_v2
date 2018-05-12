<?php
class Utils 
{
    /**
     * Return list of enum elements of the model.
     * @param unknown_type $model
     * @param unknown_type $attribute
     */
	public static function enumItem($model,$attribute)
    {
        $attr=$attribute;
        preg_match('/\((.*)\)/',$model->tableSchema->columns[$attr]->dbType,
        	$matches);
        
        foreach(explode(',', $matches[1]) as $value)
        {
            $value=str_replace("'",null,$value);
            $values[$value]=$value;
        }
        
        return $values;
    }
	
}