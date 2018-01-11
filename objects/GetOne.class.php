<?php
class GetOne
{
    public function getOne($class, $ID, $field)
    {
        $listing = (new $class($ID));
        if ($listing->getFields()) 
            foreach ($listing->getFields() as $value) 
                $campos[$value] = $listing->get($value);
        if ($listing->getMeta())
            foreach ($listing->getMeta() as $key => $value) 
                $campos[$key] = $value;
        
        return $campos;        
    }

}