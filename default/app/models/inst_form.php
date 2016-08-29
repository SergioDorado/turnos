<?php

class InstForm extends ActiveRecord
{
    public function instorde() { //Lista las instituciones formadoras ordenadas por nombre
        $inst = new InstForm();
        return ($inst->find("order: nombre"));
    }
    
    public function InstFiltr($parm) 
    {
        $prov = Load::model('provincia')->DevolverProv($parm);
        $inst = new InstForm();
        return ($inst->find("conditions: provincia='$prov'","order: nombre"));
    }
}



