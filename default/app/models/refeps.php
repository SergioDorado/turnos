<?php

class refeps extends ActiveRecord
{
    public function TraerNombre($dni)
    {
        $ref = new refeps();
        return $ref->find_first("dni = $dni")->apynom;
    }
    
    public function TraerMatricula($dni)
    {
        $ref = new refeps();
        return $ref->find_first("dni = $dni")->matricula;
    }
    
     public function ListRefeps($dni) //Trae todos los registro que pertenezcan a un matriculado
    {
        $ref = new refeps();
        return $ref->find("conditions: dni='$dni'");
    } 
}
