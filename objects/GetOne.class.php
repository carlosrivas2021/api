<?php
class GetOne
{
    public function get_one($class, $ID, $field='ID')
    {
        $listing = (new $class($ID, $field));
        if ($listing->getFields()) 
            foreach ($listing->getFields() as $value) 
                $campos[$value] = $listing->get($value);
        if ($listing->getMeta())
            foreach ($listing->getMeta() as $key => $value) 
                $campos[$key] = $value;
        
        return $campos;        
    }

}